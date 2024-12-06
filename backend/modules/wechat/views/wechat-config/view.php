<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use api\modules\wechat\models\WechatConfig;

/** @var yii\web\View $this */
/** @var api\modules\wechat\models\WechatConfig  $model */

$this->title = WechatConfig::$modelName.'详情 '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'id', 'url' => ['index']];
$this->params['breadcrumbs'][] = WechatConfig::$modelName.'详情';
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
            'name',
            'app_id',
            'app_secret',
            'server_url:url',
            'token',
            'encoding_aes_key',
            [
                'attribute' => 'kind',
                'value' => function ($model) {
                    return $model->getKindText();
                }
            ],
            'login_email:email',
            'login_password',
            'original_id',
            [
                'attribute' => 'qrcode_url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->qrcode_url, ['width' => '100px']);
                }
            ],
            [
                'attribute' => 'auth_type',
                'value' => function ($model) {
                    return $model->getAuthTypeText();
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('span', $model->getStatusText(), [
                        'class' => 'label ' . $model->getStatusLabelClass(),
                    ]);
                }
            ],
            'welcome_msg',
            [
                'attribute' => 'enable_debug',
                'value' => function ($model) {
                    return WechatConfig::$enableDebugMap[$model->enable_debug] ?? '否';
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    </div>
    <!-- /.box-body -->
</div>
<?php
// $this->registerJs("$('img').viewer();", \yii\web\View::POS_END);
?>
