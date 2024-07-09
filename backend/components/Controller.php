<?php

namespace backend\components;

use yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller as BaseController;

/**
 * 控制器基类
 */
class Controller extends BaseController
{
    protected $modelClass = '';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            //超级管理员
                            if (!Yii::$app->user->isGuest && Yii::$app->user->isAdmin) {
                                return true;
                            }

                            $parts = explode('-', $action->controller->id);
                            $controllerName = '';
                            if (is_array($parts)) {
                                foreach ($parts as $part) {
                                    $controllerName .= ucfirst($part);
                                }
                            }
                            $itemName = $controllerName . ".*";
                            $subItemName = $controllerName . "." . ucfirst($action->id);

                            $moduleName = $action->controller->module->id;
                            if (strpos($moduleName, 'app-') === false) {
                                $itemName = ucfirst($moduleName) . '.' . $itemName;
                                $subItemName = ucfirst($moduleName) . '.' . $subItemName;
                            }

                            // 控制器权限
                            if (Yii::$app->user->can($itemName)) {
                                return true;
                            }

                            // 具体动作权限
                            return Yii::$app->user->can($subItemName);
                        },
                    ],
                ],
            ],
            [
                'class' => \backend\components\BlankUrlFilter::class,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    
    protected function getSearchModelClass()
    {
        $modelClass = $this->modelClass;

        $lastSlash = strrpos($modelClass, '\\')+1;
        $searchModelClass = substr($modelClass, 0, $lastSlash-1)."\\search\\". substr($modelClass, $lastSlash).'Search';
        if (!class_exists($searchModelClass)) {
            $searchModelClass = substr($modelClass, 0, $lastSlash-1)."\\query\\". substr($modelClass, $lastSlash).'Query';
        }

        return $searchModelClass;
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelClass = $this->getSearchModelClass();
        $searchModel = new $searchModelClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->modelClass::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
