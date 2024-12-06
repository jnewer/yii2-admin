<?php

use api\modules\wechat\models\WechatConfig;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\WechatConfig $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="box-body">
    <?php  $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal', 'enctype'=>'multipart/form-data'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
            'labelOptions'=>['class'=>'col-sm-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'kind')->dropDownList(WechatConfig::$kindMap, ['prompt'=>'', 'data-placeholder'=>'请选择', 'class' => 'select2', 'style' => 'width:100%']) ?>
    <?= $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'app_secret')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(WechatConfig::$statusMap, ['prompt'=>'', 'data-placeholder'=>'请选择', 'class' => 'select2', 'style' => 'width:100%']) ?>
    <?= $form->field($model, 'server_url')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'encoding_aes_key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'login_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'login_password')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'original_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'qrcode_url')->widget(backend\widgets\FileInput::class)->hint('支持JPG、PNG格式，不要超过500KB为宜') ?>
    <?= $form->field($model, 'welcome_msg')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'enable_debug')->dropDownList(WechatConfig::$enableDebugMap, ['prompt'=>'', 'data-placeholder'=>'请选择', 'class' => 'select2', 'style' => 'width:100%']) ?>
    <div class="box-footer">
        <a data-dismiss="modal" href="javascript:history.back();" class="btn btn-default">取消</a>
        <?=  Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <?php  ActiveForm::end(); ?>
</div>
