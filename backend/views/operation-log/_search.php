<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\OperationLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="sms-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options'=>['class'=>'form-inline', 'role'=>'form'],
        'fieldConfig'=>[
            'template'=>"{label}\n{input}\n",
            'labelOptions'=>['class'=>'sr-only'],
        ],
    ]); ?>
    <?= $form->field($model, 'operator_name', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'用户名']]) ?>
    <?= $form->field($model, 'type', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'操作大类']]) ?>
    <?= $form->field($model, 'category', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'操作小类']]) ?>
    <div class="form-group">
        <div class="input-daterange input-group">
            <?= $form->field($model, 'date_from', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '操作时间', 'style' => 'width:120px']]); ?>
            <span class="input-group-addon">至</span>
            <?= $form->field($model, 'date_to', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '操作时间', 'style' => 'width:120px']]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
