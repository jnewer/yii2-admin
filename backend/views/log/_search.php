<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\LogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => ['class' => 'form-inline', 'role' => 'form'],
    ]); ?>
    <?php echo $form->field($model, 'level', ['labelOptions' => ['class' => 'sr-only']])->dropdownList($model::$levelMap, ['prompt' => '', 'data-placeholder' => '级别', 'class' => 'form-control select2', 'style' => 'width:120px']) ?>
    <?= $form->field($model, 'category', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '分类']]) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
