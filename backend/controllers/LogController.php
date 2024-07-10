<?php

namespace backend\controllers;

use common\models\Log;
use backend\components\Controller;

/**
 * LogController implements the CRUD actions for Log model.
 *
 * @desc 日志管理
 */
class LogController extends Controller
{
    protected $modelClass = Log::class;

    public static $parentActions = ['index', 'view'];
}
