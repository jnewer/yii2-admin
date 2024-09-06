<?php

use common\modules\region\models\Province;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\region\models\City $model */
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
    <?= $form->field($model, 'pid')->dropdownList(Province::instance()->getListData(), ['prompt' => '', 'data-placeholder' => '请选择', 'class' => 'form-control select2', 'style' => 'width:100%'])->label('所属省份') ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="box-footer">
        <a data-dismiss="modal" href="javascript:history.back();" class="btn btn-default">取消</a>
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
