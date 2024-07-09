<?php

namespace backend\controllers;

use backend\models\LoginLog;
use backend\components\Controller;

/**
 * LoginLogController implements the CRUD actions for LoginLog model.
 */
class LoginLogController extends Controller
{
    protected $modelClass = LoginLog::class;
}
