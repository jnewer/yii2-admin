<?php

use yii\helpers\Html;
use common\modules\region\models\Area;


/** @var yii\web\View $this */
/** @var common\modules\region\models\Area $model */

$this->title = '新增'.Area::$modelName;
$this->params['breadcrumbs'][] = ['label' => Area::$modelName.'管理', 'url' => ['index']];
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
