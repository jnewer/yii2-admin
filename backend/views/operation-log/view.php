<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\OperationLog;

/** @var yii\web\View $this */
/** @var common\models\Sms $model */

$this->title = OperationLog::$modelName.'详情 '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'id', 'url' => ['index']];
$this->params['breadcrumbs'][] = OperationLog::$modelName.'详情';
?>
<style>.operation_log tr:nth-child(odd) {background-color: #f4f4f4;}</style>
<div class="box">
    <div class="box-header">
        <!-- /.btn-group -->
        <div class="pull-right">
            <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="20%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'operator_id',
            'operator_name',
            'type',
            'category',
            'ip',
            'created_at',
            'model',
            'model_pk',
            [
                'attribute'     =>  'attributeDesc',
                'label'     =>  '属性',
                'value' =>  function ($model) {
                    return $model->attributeDesc;
                },
                'format'    => 'html',
            ],
        ],
    ]) ?>

    </div>
    <!-- /.box-body -->
</div>
