<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\region\models\search\AreaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="area-search">

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
     <?= $form->field($model, 'city_name', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'所属城市']]) ?>
     <?= $form->field($model, 'name', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'区域名称']]) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
