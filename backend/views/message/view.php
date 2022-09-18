<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = '留言详情 ' .$model->id;
$this->params['breadcrumbs'][] = ['label' => '留言管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <!-- /.btn-group -->
        <div class="pull-right">
            <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
            <?=  Html::a('<i class="fa fa-edit"></i>', ['reply', 'id'=>$model->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="20%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'config.name',
            'user_mobile',
            'user_name',
            'content:ntext',
            'created_at',
        ],
    ]) ?>

    </div>
    <br>
    <div class="box-header">
        <div class="pull-left">
            回复
        </div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-striped table-bordered detail-view">
            <tbody>
                <?php foreach ($model->replys as $reply) :?>
                <tr>
                    <th width="20%"><?= $reply->user->username ?></th>
                    <td><?= Yii::$app->formatter->asNtext($reply->content) ?></td>
                    <td width="5%">
                        <?=  Html::a('<i class="fa fa-trash-o"></i>', ['delete-reply', 'id' => $reply->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '您确定要删除该回复吗？',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <?php endforeach ;?>
            </tbody>
        </table>
    </div>
</div>
