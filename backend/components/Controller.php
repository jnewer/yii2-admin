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


    protected function getSearchModel()
    {
        $modelClass = $this->modelClass;

        $lastSlash = strrpos($modelClass, '\\') + 1;
        $searchModelClass = substr($modelClass, 0, $lastSlash - 1) . "\\search\\" . substr($modelClass, $lastSlash) . 'Search';
        if (!class_exists($searchModelClass)) {
            $searchModelClass = substr($modelClass, 0, $lastSlash - 1) . "\\query\\" . substr($modelClass, $lastSlash) . 'Query';
        }

        return new $searchModelClass();
    }

    /**
     * Lists all models.
     *
     * @desc 列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->getSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
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
     *
     * @desc 查看
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
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @desc 删除
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->setFlash('warning', $this->modelClass::$modelName . '#' . $model->id . '已成功删除。');
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @desc 新增
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->loadDefaultValues();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // 取消注释来上传文件/图片
            // $model->uploadImages(['image']);

            if (!$model->hasErrors() && $model->save()) {
                Yii::$app->session->setFlash('success', $this->modelClass::$modelName . '#' . $model->id . '已添加成功。');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @desc 更新
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // 取消注释来上传文件/图片
            // $model->uploadImages(['image']);

            if (!$model->hasErrors() && $model->save()) {
                Yii::$app->session->setFlash('success', $this->modelClass::$modelName . '#' . $model->id . '已更新成功。');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
