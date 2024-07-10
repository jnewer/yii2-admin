<?php

/**
 * @var \yii\web\View $this
 * @var string $name
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var integer $fullSize
 * @var integer $defaultTailLine
 */

use backend\modules\logReader\Log;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\i18n\Formatter;

$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $name;

$formatter = new Formatter();
$fullSizeFormat = $formatter->format($fullSize, 'shortSize');
$captionBtn = [];
if ($fullSize > 1) {
    $captionBtn[] = Html::a('打包', ['zip', 'slug' => Yii::$app->request->get('slug')], ['class' => 'btn btn-success btn-sm']);
    $captionBtn[] = Html::a('清理', ['clean', 'slug' => Yii::$app->request->get('slug')], ['class' => 'btn btn-danger btn-sm']);
}
$captionBtnStr = implode(' ', $captionBtn);
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
                'caption' => "全部大小: {$fullSizeFormat}. {$captionBtnStr}",
                'columns' => [
                    [
                        'attribute' => 'fileName',
                        'label' => '文件',
                        'format' => 'raw',
                        'value' => function (Log $log) {
                            return pathinfo($log->fileName, PATHINFO_BASENAME);
                        },
                    ], [
                        'attribute' => 'counts',
                        'label' => '级别统计',
                        'format' => 'raw',
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
                        'template' => '{view} {tail}{download} {delete}',
                        'urlCreator' => function ($action, Log $log) {
                            return [$action, 'slug' => $log->slug, 'stamp' => $log->stamp];
                        },
                        'buttons' => [
                            'view' => function ($url, Log $log) {
                                return !$log->isExist || $log->isZip ? '' : Html::a('<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-default btn-sm',
                                    'target' => '_blank',
                                ]);
                            },
                            'tail' => function ($url, Log $log) use ($defaultTailLine) {
                                if ($log->isZip) {
                                    return '';
                                }
                                return Html::a('<span>tail</span>', $url + ['line' => $defaultTailLine], [
                                    'class' => 'btn btn-sm btn-primary',
                                    'target' => '_blank',
                                ]);
                            },
                            'download' => function ($url, Log $log) {
                                return !$log->isExist ? '' : Html::a('<i class="fa fa-download" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-sm btn-default',
                                    'title' => '下载'
                                ]);
                            },
                            'delete' => function ($url, Log $log) {
                                return !$log->isExist ? '' : Html::a('<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>', $url, [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => ['method' => 'post', 'data-a' => 'aa', 'confirm' => '确定要删除吗?'],
                                ]);
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>