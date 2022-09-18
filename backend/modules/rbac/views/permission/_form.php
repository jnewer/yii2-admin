<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this  yii\web\View
 * @var $model dektrium\rbac\models\Role
 */

use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]) ?>

<?= $form->field($model, 'name')->label('名称') ?>

<?= $form->field($model, 'description')->label('描述') ?>

<?= $form->field($model, 'rule')->label('规则') ?>

<?= $form->field($model, 'children')->widget(Select2::class, [
    'data' => $model->getUnassignedItems(),
    'options' => [
        'id' => 'children',
        'multiple' => true
    ],
])->label('子项') ?>

<?= Html::submitButton('保存', ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>