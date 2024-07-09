<?php

use yii\helpers\Html;

$this->title = '系统配置';
$this->params['breadcrumbs'][] = ['label' => '系统配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = '系统配置';
echo \yii\bootstrap\Tabs::widget([
    'id' => 'tabs',
    'renderTabContent' => false,
    'items' => [
        [
            'label' => '站点配置',
            'options' => ['id' => 'site'],
            'active' => true,
        ],
        [
            'label' => '上传配置',
            'options' => ['id' => 'upload'],
        ],
    ],
]);
?>
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <div class="box-body">
        <div class="tab-content">
            <div id="site" class="tab-pane active"><?= $this->render('site', ['config' => $config]) ?></div>
            <div id="upload" class="tab-pane"><?= $this->render('upload', ['config' => $config]) ?></div>
        </div>
    </div>
</div>
