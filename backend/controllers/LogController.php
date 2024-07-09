<?php

namespace backend\controllers;

use Yii;
use common\models\Log;
use common\models\search\LogSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{

    protected $modelClass = Log::class;

    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
