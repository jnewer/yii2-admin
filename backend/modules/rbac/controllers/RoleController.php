<?php

namespace backend\modules\rbac\controllers;

use dektrium\rbac\controllers\RoleController as BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\Model;

class RoleController extends BaseController
{
    protected $modelClass = 'backend\modules\rbac\models\Role';
}
