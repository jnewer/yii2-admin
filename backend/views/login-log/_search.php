<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\LoginLogSearch $model */
/** @var yii\widgets\ActiveForm $form */
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
    <?= $form->field($model, 'user_id', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'用户ID']]) ?>
    <?= $form->field($model, 'username', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'用户名']]) ?>
    <div class="form-group">
        <div class="input-daterange input-group">
            <?= $form->field($model, 'created_at_from', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '登陆时间', 'style' => 'width:120px']]); ?>
            <span class="input-group-addon">至</span>
            <?= $form->field($model, 'created_at_to', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '登陆时间', 'style' => 'width:120px']]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
