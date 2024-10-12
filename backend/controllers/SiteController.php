<?php

namespace backend\controllers;

use backend\models\LoginLog;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use backend\models\LoginForm;
use common\models\PasswordModifyForm;

/**
 * Site controller
 *
 * @desc 登录管理
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge([
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['server-env'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 80,
                'height' => 40,
                'testLimit' => 10,
                'maxLength' => 4,
                'minLength' => 4,
                'foreColor' => 0x333333,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @desc 首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @desc 登录
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $log = new LoginLog();
            $log->user_id = Yii::$app->user->identity->id;
            $log->username = Yii::$app->user->identity->username;
            $log->login_ip = Yii::$app->request->getUserIP();
            $log->created_at = date('Y-m-d H:i:s');
            $log->save();

            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     * @desc 退出登录
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @desc 修改密码
     * @return void
     */
    public function actionPassword()
    {
        $model = new PasswordModifyForm;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->data = ActiveForm::validate($model);
            return Yii::$app->response;
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->modify()) {
            Yii::$app->session->setFlash('success', '您的登录密码已修改成功！');
            return $this->redirect(['/site/index']);
        }

        return $this->render('password', [
            'model'  => $model,
        ]);
    }

    /**
     * Displays server env.
     *
     * @desc 服务器环境
     *
     * @return string
     */
    public function actionServerEnv()
    {
        return $this->render('server-env');
    }
}
