<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options'=>['class'=>'form-inline', 'role'=>'form'],
    ]); ?>
     <?//= $form->field($model, 'level', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'级别']]) ?>
     <?php echo $form->field($model, 'level', ['labelOptions'=>['class'=>'sr-only']])->dropdownList($model::$levelMap, ['prompt'=>'', 'data-placeholder'=>'级别', 'class'=>'form-control select2', 'style'=>'width:120px']) ?>
     <?= $form->field($model, 'category', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'分类']]) ?>
     <?php // echo $form->field($model, 'log_time', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'Log Time']]) ?>
     <?php // echo $form->field($model, 'prefix', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'Prefix']]) ?>
     <?php // echo $form->field($model, 'message', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'Message']]) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
