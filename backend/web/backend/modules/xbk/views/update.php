<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\xbk\XbkChangeBind */

$this->title = 'Update Xbk Change Bind: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Xbk Change Binds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="xbk-change-bind-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
