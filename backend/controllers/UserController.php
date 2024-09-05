<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\components\Controller;

/**
 * UserController implements the CRUD actions for User model.
 *
 * @desc 用户管理
 */
class UserController extends Controller
{
    protected $modelClass = User::class;

    public static $parentActions = ['index', 'view'];

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @desc 新增
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findByUsername($model->username);
            if (!$user) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->save();
            } else {
                $user->load(Yii::$app->request->post());
                $user->setPassword($user->password);
                $user->generateAuthKey();
                $user->update();
            }
            $id = $model->id ? $model->id : $user->id;

            return $this->redirect(['view', 'id' => $id]);
        } else {
            $roles = \yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');

            if (!Yii::$app->user->isAdmin) {
                unset($roles['Admin']);
            }

            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @desc 更新
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->password) {
                $model->setPassword($model->password);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $roles = \yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');

        if (!Yii::$app->user->isAdmin) {
            unset($roles['Admin']);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles
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
        if ($model->username === 'admin') {
            Yii::$app->session->setFlash('error', '不能删除管理员！');
            return $this->redirect(['index']);
        }

        if ($model->id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', '不能删除自己！');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('warning', $this->modelClass::$modelName . '#' . $model->id . '已成功删除。');
        $model->delete();

        return $this->redirect(['index']);
    }
}
