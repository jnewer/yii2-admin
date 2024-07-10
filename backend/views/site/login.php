<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @var $this yii\web\View */
/** @var $form yii\bootstrap\ActiveForm */
/** @var $model \common\models\LoginForm */

$this->title = '管理登录';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>",
    'inputOptions' => ['class' => 'form-control input-lg'],
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
    'inputOptions' => ['class' => 'form-control input-lg'],
];
?>
<style>
    #loginform-verifycode-image {
        width: 100px;
        height: 44px;
    }
</style>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><?php echo Yii::$app->name ?></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">输入您的用户名和密码来登录</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['tabindex' => 1, 'placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['tabindex' => 2, 'placeholder' => $model->getAttributeLabel('password')]) ?>
        <?= $form
            ->field($model, 'verifyCode', ['options' => ['class' => 'form-group has-feedback'], 'template' => "{input}\n{hint}\n{error}"])
            ->widget(yii\captcha\Captcha::class, ['options' => ['tabindex' => '4', 'class' => 'form-control input-lg', 'autocomplete' => 'off', 'placeholder' => '验证码'], 'template' => '<div class="input-group"><span class="input-group-addon" style="padding:0;"><div  style="padding:0;width:100px;height:44px;overflow: hidden;">{image}</div></span>{input}<span class="glyphicon glyphicon-text-background form-control-feedback"></span></div>']) ?>
        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!-- <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div> -->
        <!-- /.social-auth-links -->
        <hr>
        <!--  <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->