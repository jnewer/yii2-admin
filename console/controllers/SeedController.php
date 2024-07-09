<?php

namespace console\controllers;

use Yii;
use common\models\User;
use yii\console\Controller;

class SeedController extends Controller
{
    public function actionCreateAdmin()
    {
        $user = User::findByUsername('admin');
        if ($user) {
            echo "User 'admin' already exists.\n";
            return;
        }
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@qq.com';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->save();

        echo "User created successfully.\n";

        Yii::$app->setComponents([
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
            ],
        ]);

        $auth = Yii::$app->authManager;
        $role = $auth->createRole('Admin');
        $role->description = '超级管理员';
        $auth->add($role);

        $auth->assign($role, $user->id);

        echo "Role assigned successfully.\n";
    }
}
