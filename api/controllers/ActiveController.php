<?php

namespace api\controllers;

use yii;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\rest\ActiveController as Controller;
use common\components\behaviors\RequestIdBehavior;

/**
 * ActiveController
 */
class ActiveController extends Controller
{
    public $defaultFilter = [];

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

        $behaviors['requestId'] = [
            'class' => RequestIdBehavior::class,
        ];

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
        $modelClass = $this->modelClass;

        $lastSlash = strrpos($modelClass, '\\') + 1;
        $searchModelClass = substr($modelClass, 0, $lastSlash - 1) . "\\search\\" . substr($modelClass, $lastSlash) . 'Search';

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
        
        if ($modelClass::instance()->hasAttribute('deleted_at')) {
            $query->andFilterWhere(['deleted_at' => null]);
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
        Yii::$app->setComponents([
            'response' => [
                'class' => 'yii\web\Response',
                'format' => 'json',
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
                        $responseData = [
                            'data' => $response->data,
                            'code' => $response->isSuccessful ? 0 : ($response->data['name'] == 'Exception' ? $response->data['code'] : $response->statusCode),
                            'message' => $response->isSuccessful ? 'ok' : ($response->data['message'] ?? 'Internal Server Error'),
                        ];

                        $response->data = $responseData;
                    } else {
                        $response->data = null;
                    }
                },
            ],
        ]);

        return parent::beforeAction($action);
    }
}
