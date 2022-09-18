<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\xbk\XbkChangeBindSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xbk Change Binds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xbk-change-bind-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Xbk Change Bind', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'config_id',
            'wechat_user_id',
            'patient_id',
            'to_wechat_user_id',
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
