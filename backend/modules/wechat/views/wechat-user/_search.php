<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use api\modules\wechat\models\WechatConfig;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\search\WechatUserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="wechat-user-search">

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
     <?= $form->field($model, 'wechat_config_id')->dropDownList(WechatConfig::instance()->getListData(), ['prompt'=>'', 'data-placeholder'=>'微信配置', 'class' => 'select2', 'style' => 'width:200px;']) ?>
     <?= $form->field($model, 'openid', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'openid']]) ?>
     <?php // echo $form->field($model, 'nickname', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'昵称']]) ?>
     <?php // echo $form->field($model, 'sex', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'性别']]) ?>
     <?php // echo $form->field($model, 'province', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'省份']]) ?>
     <?php // echo $form->field($model, 'city', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'城市']]) ?>
     <?php // echo $form->field($model, 'country', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'国家']]) ?>
     <?php // echo $form->field($model, 'headimgurl', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'头像']]) ?>
     <?php // echo $form->field($model, 'privilege', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'用户特权信息']]) ?>
     <?php // echo $form->field($model, 'unionid', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'unionid']]) ?>
     <?php // echo $form->field($model, 'access_token', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'access_token']]) ?>
     <?php // echo $form->field($model, 'created_at', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'创建时间']]) ?>
     <?php // echo $form->field($model, 'updated_at', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'更新时间']]) ?>
     <?php // echo $form->field($model, 'subscribed_at', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'关注时间']]) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
