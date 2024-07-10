<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $model common\models\MessageSearch */
/** @var $form yii\widgets\ActiveForm */
?>

<div class="message-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => ['class' => 'form-inline', 'role' => 'form'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n",
            'labelOptions' => ['class' => 'sr-only'],
        ],
    ]); ?>


    <?= $form->field($model, 'content', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '内容']]) ?>

    <?= $form->field($model, 'user_mobile', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '用户电话']]) ?>

    <?php echo $form->field($model, 'user_name', ['labelOptions' => ['class' => 'sr-only'], 'inputOptions' => ['class' => 'form-control', 'placeholder' => '用户姓名']]) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>