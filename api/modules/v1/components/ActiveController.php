<?php

namespace api\modules\v2\components;

use yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\ActiveController as Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ActiveController
 */
class ActiveController extends Controller
{
    public $requestUrl;

    public $defaultFilter = [];

        /**
     * @var string
     */
    protected $requestId;

    protected $requestKey;

    protected $notFormat = [];

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    //header传参：key=>Authorization,value=>Bearer (access_token)
    //或GET传参：key=>access_token,value=>(access_token)
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(['corsFilter' =>
            [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => Yii::$app->params['origins'],
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Request-Headers' => ['X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                    'Access-Control-Expose-Headers' => ['Origin', 'Access-Control-Allow-Origin', 'X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                ]
            ]], parent::behaviors());

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'text/html' => Response::FORMAT_JSON,
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // 禁用"delete" 和 "create" 动作
        unset($actions['delete']);

        // 使用"prepareDataProvider()"方法自定义数据provider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function prepareDataProvider()
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $lastSlash = strrpos($modelClass, '\\') + 1;
        $searchModelClass = substr($modelClass, 0, $lastSlash - 1) . "\\search\\" . substr($modelClass, $lastSlash) . 'Search';
        if (!class_exists($searchModelClass)) {
            $searchModelClass = substr($modelClass, 0, $lastSlash - 1) . "\\query\\" . substr($modelClass, $lastSlash) . 'Query';
        }

        $filter = new ActiveDataFilter([
            'searchModel' => $searchModelClass,
        ]);

        $filterCondition = null;
        $query = $modelClass::find();
        $get = \Yii::$app->request->get();
        if (isset($get['filter']) && $filter->filter = Json::decode($get['filter'])) {
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
            $query->andFilterWhere($filterCondition);
        } else {
            $query->andFilterWhere(ArrayHelper::filter($get, $modelClass::instance()->attributes()));
        }
        if ($modelClass::instance()->hasAttribute('is_deleted')) {
            $query->andFilterWhere(['is_deleted' => 0]);
        }
        if (!empty($this->defaultFilter)) {
            $query->andFilterWhere($this->defaultFilter);
        }
        $order = ['id' => SORT_DESC];
        if ($modelClass::instance()->hasAttribute('sort')) {
            $order = ['sort' => SORT_DESC];
        }

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => $order, 'enableMultiSort' => true],
            'pagination' => ['validatePage' => false],
        ]);
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action == 'delete' || $action == 'update') {
            if ($model->hasAttribute('user_id') && $model->user_id && !Yii::$app->user->isGuest) {
                if ($model->user_id != Yii::$app->user->id) {
                    throw new ForbiddenHttpException('You can not delete the data does not belongs to yourself! model->user_id = ' . $model->user_id . ', user_id=' . Yii::$app->user->id);
                }
            }
        }

        if ($action == 'view') {
            if ($model->hasAttribute('status') && !$model->status) {
                throw new NotFoundHttpException('the resources is not exists.');
            }
        }
    }

    public function beforeAction($action)
    {
        if (!in_array($action->id, $this->notFormat)) {
            Yii::$app->setComponents([
                'response' => [
                    'class' => 'yii\web\Response',
                    'format' => 'json',
                    'on beforeSend' => function ($event) {
                        $response = $event->sender;
                        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
                            if ($this->requestId && Yii::$app->redis->sismember('response-id-list-' . date('W'), $this->requestId)) {
                                if ($response->statusCode == 200) {
                                    Yii::$app->redis->set($this->requestKey, Json::encode($response->data), 'PX', 3 * 24 * 3600000);
                                } else {
                                    Yii::$app->redis->srem('response-id-list-' . date('W'), $this->requestId);
                                }
                            }
                            $response->data = [
                                'data' => $response->data,
                                'status' => $response->statusCode,
                                'code' => $response->isSuccessful ? 0 : ($response->data['name'] == 'Exception' ? $response->data['code'] : 'unknown code'),
                                'message' => $response->isSuccessful ? 'ok' : ($response->data['message'] ? $response->data['message'] : 'unknown error'),
                                'ts' => DatetimeHelper::getMicRoTime(),
                                'requestId' => $this->requestId ?? StringHelper::createRequestId()
                            ];
                        } else {
                            $response->data = null;
                        }
                    },
                ],
            ]);
        }
        return parent::beforeAction($action);
    }

    public function runAction($id, $params = [])
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($post['requestId']) {
                $this->requestId = $post['requestId'];
                $this->requestKey = 'request:' . $this->requestId;
                if (Yii::$app->redis->sismember('response-id-list-'.date('W'), $this->requestId)) {
                    $result = Json::decode(Yii::$app->redis->get($this->requestKey));
                    if (!empty($result)) {
                        $action = $this->createAction($id);
                        $this->beforeAction($action);
                        return $result;
                    }
                } else {
                    Yii::$app->redis->sadd('response-id-list-'.date('W'), $this->requestId);
                    if (Yii::$app->redis->ttl('response-id-list-'.date('W')) < 1) {
                        Yii::$app->redis->expire('response-id-list-'.date('W'), 7 * 24 * 3600);
                    }
                }
            }
        }
        return parent::runAction($id, $params);
    }
}
