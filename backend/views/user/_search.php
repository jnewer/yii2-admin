<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options'=>['class'=>'form-inline'],
            'fieldConfig'=>[
                'template'=>"{label}\n{input}\n",
                'labelOptions'=>['class'=>'sr-only'],
            ],
        ]); ?>

        <?= $form->field($model, 'id')->textInput(['placeholder'=>'ID']) ?>
        <?= $form->field($model, 'username')->textInput(['placeholder'=>'用户名']) ?>
        <?= $form->field($model, 'nickname')->textInput(['placeholder'=>'昵称']) ?>
        <?= $form->field($model, 'email')->textInput(['placeholder'=>'邮箱']) ?>
        <?= $form->field($model, 'status')->dropdownList(User::$statusMap, ['prompt'=>'', 'data-placeholder'=>'状态', 'class'=>'form-control select2', 'style'=>'width:120px']) ?>

        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
