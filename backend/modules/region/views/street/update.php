<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\region\models\Street  $model */
use common\modules\region\models\Street;

$this->title = '修改' .Street::$modelName. ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '管理'.Street::$modelName, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="box box-info">
    <div class="box-header">
        <?=  Html::a('<i class="fa fa-trash-o"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除该项目吗？',
                'method' => 'post',
            ],
        ]) ?>
        <!-- /.btn-group -->
        <div class="pull-right">
            <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
