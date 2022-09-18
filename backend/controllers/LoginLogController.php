<?php

namespace backend\controllers;

use Yii;
use backend\models\LoginLog;
use backend\models\search\LoginLogSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginLogController implements the CRUD actions for LoginLog model.
 */
class LoginLogController extends Controller
{

    /**
     * Lists all LoginLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoginLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the LoginLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoginLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoginLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
