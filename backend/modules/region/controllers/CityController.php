<?php

namespace backend\modules\region\controllers;

use Yii;
use common\modules\region\models\City;
use common\modules\region\models\search\CitySearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * CityController implements the CRUD actions for City model.
 * @desc 城市表管理
 */
class CityController extends Controller
{
    protected $modelClass = City::class;
}
