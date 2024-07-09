<?php

namespace backend\controllers;

use backend\models\OperationLog;
use backend\components\Controller;

/**
 * OperationLogController implements the CRUD actions for OperationLog model.
 */
class OperationLogController extends Controller
{
    protected $modelClass = OperationLog::class;
}
