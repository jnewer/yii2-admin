<?php

namespace backend\modules\rbac\controllers;

use dektrium\rbac\controllers\RoleController as BaseController;

class RoleController extends BaseController
{
    protected $modelClass = 'backend\modules\rbac\models\Role';
}
