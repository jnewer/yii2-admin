<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\LoginForm $model */

$this->title = '修改登录密码';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']])->passwordInput() ?>
                <?= $form->field($model, 'newpassword', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->passwordInput() ?>
                <?= $form->field($model, 'renewpassword', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->passwordInput() ?>

                <?= Html::submitButton('确定', ['class' => 'btn btn-primary btn-block', 'tabindex' => '4']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
