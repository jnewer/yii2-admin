<?php

use yii\helpers\Html;
use common\modules\region\models\City;


/** @var yii\web\View $this */
/** @var common\modules\region\models\City $model */

$this->title = '新增'.City::$modelName;
$this->params['breadcrumbs'][] = ['label' => City::$modelName.'管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新增';
?>
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default', 'data-dismiss'=>'modal']) ?>
        </div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
