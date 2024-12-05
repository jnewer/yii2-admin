<?php

use api\modules\wechat\models\WechatConfig;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\search\WechatConfigSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="wechat-config-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => [''],
        'options'=>['class'=>'form-inline', 'role'=>'form'],
        'fieldConfig'=>[
            'template'=>"{label}\n{input}\n",
            'labelOptions'=>['class'=>'sr-only'],
        ],
    ]); ?>
     <?= $form->field($model, 'id', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'ID']]) ?>
     <?= $form->field($model, 'name', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'名称']]) ?>
     <?= $form->field($model, 'app_id', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'AppID']]) ?>
     <?= $form->field($model, 'kind')->dropDownList(WechatConfig::$kindMap, ['prompt'=>'', 'data-placeholder'=>'类型','class'=>'form-control select2','style' => 'width:100px;'])->label(false); ?>
     <?= $form->field($model, 'status')->dropDownList(WechatConfig::$statusMap, ['prompt'=>'', 'data-placeholder'=>'状态','class'=>'form-control select2','style' => 'width:100px;'])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
