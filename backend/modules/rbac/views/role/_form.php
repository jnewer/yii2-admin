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

// use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;

Yii::$app->params['role_children'] = $model->children;
?>
<div class="alert alert-info">超级管理员Admin角色不需要授予任何权限，授予了带*号的项目后，就无需再授予该权限下的子权限了。</div>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]) ?>

<?= $form->field($model, 'name')->label('名称') ?>

<?= $form->field($model, 'description')->label('描述') ?>

<?= $form->field($model, 'rule')->label('规则') ?>

<div class="form-group field-role-rule">
    <label for="role-rule" class="control-label">授权项</label>
    <?= GridView::widget([
        'dataProvider' => $model->getUnassignedItemsDataProvider(),
        'filterModel'  => null,
        'layout'       => "{items}\n{pager}",
        'columns'      => [
            [
                'class' => CheckboxColumn::class,
                'name' => 'Role[children][]',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model['name'], 'checked' => in_array($model['name'], Yii::$app->params['role_children'])];
                },
                'options'   => [
                    'style' => 'width: 40px'
                ],
            ],
            [
                'attribute' => 'name',
                'header'    => '名称',
                'options'   => [
                    'style' => 'width: 20%'
                ],
            ],
            [
                'attribute' => 'description',
                'header'    => '描述',
            ],
        ],
    ]) ?>
</div>
<?= Html::submitButton('保存', ['class' => 'btn btn-success btn-block', 'style' => "position: fixed;bottom: 10px; width: 100%;"]) ?>

<?php ActiveForm::end() ?>