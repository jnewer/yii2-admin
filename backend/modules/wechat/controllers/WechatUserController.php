<?php

namespace backend\modules\wechat\controllers;

use Yii;
use api\modules\wechat\models\WechatUser;
use api\modules\wechat\models\search\WechatUserSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * WechatUserController implements the CRUD actions for WechatUser model.
 * @desc 微信用户表管理
 */
class WechatUserController extends Controller
{
    protected $modelClass = WechatUser::class;

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
        /** @var \common\components\ActiveRecord $model */
        $model->loadDefaultValues();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // 取消注释来上传文件/图片
            $model->uploadImages($model->fileAttributes);

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
            $model->uploadImages($model->fileAttributes);

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