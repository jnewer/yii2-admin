<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use api\modules\wechat\models\WechatUser;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\WechatUser  $model */

$this->title = WechatUser::$modelName.'详情 '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'id', 'url' => ['index']];
$this->params['breadcrumbs'][] = WechatUser::$modelName.'详情';
?>

<div class="box">
    <div class="box-header">
        <div class="btn-group">
            <?=  Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <!-- /.btn-group -->
        </div>
        <?=  Html::a('<i class="fa fa-trash-o"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除该项目吗？',
                'method' => 'post',
            ],
        ]) ?>
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
            'wechat_config_id',
            'openid',
            'nickname',
            [
                'attribute' => 'sex',
                'value' => function ($model) {
                    return $model->getSexText();
                }
            ],
            'province',
            'city',
            'country',
            [
                'attribute' => 'headimgurl',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->headimgurl, ['width' => '100px']);
                }
            ],
            'privilege',
            'unionid',
            'access_token',
            'created_at',
            'updated_at',
            'subscribed_at',
        ],
    ]) ?>

    </div>
    <!-- /.box-body -->
</div>
