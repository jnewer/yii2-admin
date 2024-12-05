<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use api\modules\wechat\models\WechatConfig;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\WechatUser $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="box-body">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'wechat_config_id')->dropDownList(WechatConfig::instance()->getListData(), ['prompt'=>'', 'data-placeholder'=>'微信配置', 'class' => 'select2', 'style' => 'width:100%'])->label('微信配置') ?>
    <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'headimgurl')->widget(backend\widgets\FileInput::class)->hint('支持JPG、PNG格式，不要超过500KB为宜') ?>
    <?php //= $form->field($model, 'country')->textInput(['maxlength' => true])
    ?>
    <?php //= $form->field($model, 'province')->textInput(['maxlength' => true])
    ?>
    <?php //= $form->field($model, 'city')->textInput(['maxlength' => true])
    ?>
    <div class="box-footer">
        <a data-dismiss="modal" href="javascript:history.back();" class="btn btn-default">取消</a>
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
