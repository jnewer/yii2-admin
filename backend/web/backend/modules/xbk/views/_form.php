<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\xbk\XbkChangeBind */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xbk-change-bind-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'config_id')->textInput() ?>

    <?= $form->field($model, 'wechat_user_id')->textInput() ?>

    <?= $form->field($model, 'patient_id')->textInput() ?>

    <?= $form->field($model, 'to_wechat_user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
