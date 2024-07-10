<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

/** @var $this yii\web\View */
/** @var $model common\models\User */
/** @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
    <?php if ($model->isNewRecord) : ?>
        <?= $form->field($model, 'password')->widget(PasswordInput::class, [
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => false
            ]
        ])->hint('请勿使用过于简单的密码') ?>
    <?php else : ?>
        <?= $form->field($model, 'password')->widget(PasswordInput::class, [
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => false
            ]
        ])->hint('若无需修改密码则留空即可') ?>
    <?php endif ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'roles')->dropdownList($roles, ['prompt' => '', 'data-placeholder' => '角色', 'class' => 'form-control select2', 'style' => 'width:100%']) ?>
    <?= $form->field($model, 'status')->dropdownList(User::$statusMap, ['prompt' => '', 'data-placeholder' => '状态', 'class' => 'form-control select2', 'style' => 'width:100%']) ?>
    <div class="box-footer">
        <a href="javascript:history.back();" class="btn btn-default">取消</a>
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
