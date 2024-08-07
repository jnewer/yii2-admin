<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $searchModel common\models\MessageSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <!-- Check all button -->
                <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> -->
                <div class="btn-group">
                    <?//= Html::a('<i class="fa fa-pencil-square-o"></i>', ['create'], ['class' => 'btn btn-primary']) ?>
                </div>
                <!-- /.btn-group -->
                <a type="button" class="btn btn-default" href="javascript:window.location.reload()"><i class="fa fa-refresh"></i></a>
                <div class="pull-right">
                    <!-- <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div> -->
                    <?=  $this->render('_search', [
                        'model' => $searchModel,
                    ]); ?>
                                        <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
            </div>
            <!-- /.box-header -->
            <?=  GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "<div class=\"box-body table-responsive\">{items}</div>\n<div class=\"box-footer clearfix\"><div class=\"row\"><div class=\"col-xs-12 col-sm-7\">{pager}</div><div class=\"col-xs-12 col-sm-5 text-right\">{summary}</div></div></div>",
                'tableOptions'=>['class'=>'table table-bordered table-hover'],
                'summary'=>'第{page}页，共{pageCount}页，当前第{begin}-{end}项，共{totalCount}项',
                'filterModel'=>null,
                'pager'=>[
                    'class'=>'backend\widgets\LinkPager',
                    'options' => [
                        'class' => 'pagination pagination-sm no-margin',
                    ],
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    // 'config_id',
                    'content:ntext',
                    'user_mobile',
                    'user_name',
                    ['label' => '回复状态', 'value' => function ($data)
                    {
                        return empty($data->replys) ? '等待回复' : '已回复';
                    }],
                    'created_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'操作',
                    'headerOptions'=>['style'=>'width:150px'],
                    'buttonOptions'=>['class'=>'btn btn-default btn-sm'],
                    'template'=>'{view} {reply}',
                    'buttons'=>[
                        'reply' => function ($url, $model, $key) {
                            return Html::a('<i class="glyphicon glyphicon-edit"></i>', $url, ['title'=>'回复', 'class' =>'btn btn-default btn-sm']);
                        },
                    ],

                ],
            ],
        ]); ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

