<?php

namespace backend\modules\region\controllers;

use Yii;
use common\modules\region\models\Street;
use common\modules\region\models\search\StreetSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * StreetController implements the CRUD actions for Street model.
 * @desc 街道表管理
 */
class StreetController extends Controller
{
    protected $modelClass = Street::class;
}
