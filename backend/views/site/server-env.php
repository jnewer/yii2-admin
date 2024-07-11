<?php

use yii\widgets\DetailView;

/** @var yii\web\View  $this */

$this->title = '服务环境';

$this->params['breadcrumbs'] = [$this->title];

$systemInfo = new \backend\models\SystemInfo();
$phpInfo = new \backend\models\PhpInfo();

?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">系统信息</h3>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $systemInfo,
                    'attributes' => $systemInfo->attributes()
                ]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">PHP信息</h3>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $phpInfo,
                    'attributes' => $phpInfo->attributes()
                ]); ?>
            </div>
        </div>
    </div>
</div>
