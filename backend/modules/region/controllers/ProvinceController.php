<?php

namespace backend\modules\region\controllers;

use Yii;
use common\modules\region\models\Province;
use common\modules\region\models\search\ProvinceSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProvinceController implements the CRUD actions for Province model.
 * @desc 省份管理
 */
class ProvinceController extends Controller
{
    protected $modelClass = Province::class;

    public static $parentActions = ['index', 'create', 'view', 'update', 'delete'];
}
