<?php

namespace backend\modules\rbac\controllers;

use dektrium\rbac\controllers\RoleController as BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\Model;

class RoleController extends BaseController
{
    protected $modelClass = 'backend\modules\rbac\models\Role';

    /**
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            die;
        }
    }
}
