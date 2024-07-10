<?php

namespace backend\controllers;

use backend\models\LoginLog;
use backend\components\Controller;

/**
 * LoginLogController implements the CRUD actions for LoginLog model.
 * 
 * @desc 登录日志管理
 */
class LoginLogController extends Controller
{
    protected $modelClass = LoginLog::class;

    public static $parentActions = ['index', 'view'];
}
