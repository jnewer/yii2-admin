<?php

namespace backend\controllers;

use Yii;
use backend\models\OperationLog;
use backend\models\search\OperationLogSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OperationLogController implements the CRUD actions for OperationLog model.
 */
class OperationLogController extends Controller
{
    protected $modelClass = OperationLog::class;
}
