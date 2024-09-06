<?php

namespace backend\modules\region\controllers;

use Yii;
use common\modules\region\models\Area;
use common\modules\region\models\search\AreaSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for Area model.
 * @desc 区域表管理
 */
class AreaController extends Controller
{
    protected $modelClass = Area::class;
}
