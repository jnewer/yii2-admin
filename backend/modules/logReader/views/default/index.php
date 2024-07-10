<?php

/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var integer $defaultTailLine
 */

use yii\grid\GridView;
use yii\helpers\Html;
use backend\modules\logReader\Log;

$this->title = '日志列表';
$this->params['breadcrumbs'][] = '文件日志列表';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "<div class=\"box-body table-responsive\">{items}</div>\n<div class=\"box-footer clearfix\"><div class=\"row\"><div class=\"col-xs-12 col-sm-7\">{pager}</div><div class=\"col-xs-12 col-sm-5 text-right\">{summary}</div></div></div>",
                'tableOptions' => ['class' => 'table table-bordered table-hover'],
                'summary' => '第{page}页，共{pageCount}页，当前第{begin}-{end}项，共{totalCount}项',
                'filterModel' => null,
                'pager' => [
                    'class' => 'backend\widgets\LinkPager',
                    'options' => [
                        'class' => 'pagination pagination-sm no-margin',
                    ],
                ],
                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => '文件',
                        'format' => 'raw',
                        'value' => function (Log $log) {
                            return Html::tag('h5', join("\n", [
                                Html::encode($log->name),
                                '<br/>',
                                Html::tag('small', Html::encode(basename($log->fileName))),
                            ]));
                        },
                    ], [
                        'attribute' => 'counts',
                        'label' => '级别统计',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'sort-ordinal'],
                        'value' => function (Log $log) {
                            return $this->render('_counts', ['log' => $log]);
                        },
                    ], [
                        'attribute' => 'size',
                        'label' => '大小',
                        'format' => 'shortSize',
                        'headerOptions' => ['class' => 'sort-ordinal'],
                    ], [
                        'attribute' => 'updatedAt',
                        'label' => '更新时间',
                        'format' => 'relativeTime',
                        'headerOptions' => ['class' => 'sort-numerical'],
                    ], [
                        'class' => '\yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '{view} {tail} {history} {download}',
                        'urlCreator' => function ($action, Log $log) {
                            return [$action, 'slug' => $log->slug];
                        },
                        'buttons' => [
                            'view' => function ($url, Log $log) {
                                return !$log->isExist ? '' : Html::a('<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-default btn-sm',
                                    'target' => '_blank',
                                ]);
                            },
                            'tail' => function ($url, Log $log) use ($defaultTailLine) {
                                return !$log->isExist ? '' : Html::a('<span>tail</span>', $url + ['line' => $defaultTailLine], [
                                    'class' => 'btn btn-sm btn-primary',
                                    'target' => '_blank',
                                ]);
                            },
                            'history' => function ($url) {
                                return Html::a('<i class="fa fa-tasks" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-sm btn-default',
                                    'title' => '历史'
                                ]);
                            },
                            'download' => function ($url, Log $log) {
                                return !$log->isExist ? '' : Html::a('<i class="fa fa-download" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-sm btn-default',
                                    'title' => '下载'
                                ]);
                            },
                            // 'archive' => function ($url, Log $log) {
                            //     return !$log->isExist ? '' : Html::a('<i class="fa fa-book" aria-hidden="true"></i>', $url, [
                            //         'class' => 'btn btn-sm btn-success',
                            //         'data' => ['method' => 'post', 'confirm' => '确定要归档吗?'],
                            //         'title' => '归档'
                            //     ]);
                            // },
                            // 'delete' => function ($url, Log $log) {
                            //     return !$log->isExist ? '' : Html::a('<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>', array_merge($url, ['since' => $log->updatedAt]), [
                            //         'class' => 'btn btn-sm btn-danger',
                            //         'data' => ['method' => 'post', 'data-a' => 'aa', 'confirm' => '确定要删除吗?'],
                            //     ]);
                            // },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>