<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = '留言管理';
$this->params['breadcrumbs'][] = ['label' => '留言回复', 'url' => ['index']];
$this->params['breadcrumbs'][] = '回复';
?>
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-bordered detail-view">
            <tbody>
                <tr>
                    <th width="20%">提问人</th>
                    <td><?= $model->user_name ?></td>
                </tr>
                <tr>
                    <th width="20%">提问详情</th>
                    <td><?= $model->content ?></td>
                </tr>
            </tbody>
        </table>
		<br>
		<h4>回复</h4>
		<br>
		<table class="table table-striped table-bordered detail-view">
            <tbody>
            	<?php foreach ($model->replys as $value) :?>
                <tr>
                    <th width="20%"><?= $value->user->username ?></th>
                    <td><?= Yii::$app->formatter->asNtext($value->content) ?></td>
                    <td width="5%">
                    	<?=  Html::a('<i class="fa fa-trash-o"></i>', ['delete-reply', 'id' => $value->id], [
				            'class' => 'btn btn-danger',
				            'data' => [
				                'confirm' => '您确定要删除该回复吗？',
				                'method' => 'post',
				            ],
				        ]) ?>
				    </td>
                </tr>
                <?php endforeach ;?>
            </tbody>
        </table>
		<br>
	    <?php  $form = ActiveForm::begin([
	        'options'=>['class'=>'form-horizontal', 'enctype'=>'multipart/form-data'],
	        'fieldConfig'=>[
	            'template'=>"{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
	            'labelOptions'=>['class'=>'col-sm-2 control-label'],
	        ],
	    ]); ?>

	    <?= $form->field($reply, 'content')->textarea(['rows' => 6]) ?>

	    <div class="box-footer">
	        <a href="javascript:history.back();" class="btn btn-default">取消</a>
	        <?=  Html::submitButton('回复', ['class' => 'btn btn-success pull-right']) ?>
	    </div>
	    <?php  ActiveForm::end(); ?>
	</div>

</div>