<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = '用户详情';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
        <div class="btn-group">
            <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?php if ($model->id != \Yii::$app->user->id) : ?>
                <?= Html::a('<i class="fa fa-trash-o"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-default',
                    'data' => [
                        'confirm' => '您确定要删除该项目吗？',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
            <!-- /.btn-group -->
        </div>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'nickname',
                'email',
                'roleNames:text:角色',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
    <!-- /.box-body -->
</div>
