<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\form\ActiveForm;


$this->title = '系统设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => false,
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'options' => ['role' => 'form']
        ]); ?>
        <div class="form-group">
            <label class="col-lg-3 control-label">APP Name</label>
            <div class="col-lg-9">
                <input type="text" name="iressa_email" class="form-control"
                       value="<?php echo $config['app_name'] ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9">
                <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
