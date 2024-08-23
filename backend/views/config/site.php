<?php


use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ],
    'id' => 'site-form'
]); ?>
<div class="form-group">
    <label class="col-lg-3 control-label">网站名称</label>
    <div class="col-lg-9">
        <input type="text" name="site_name" class="form-control" value="<?php echo $config['site_name'] ?? '' ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">网站关键字</label>
    <div class="col-lg-9">
        <input type="text" name="site_keywords" class="form-control" value="<?php echo $config['site_keywords'] ?? '' ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">网站描述</label>
    <div class="col-lg-9">
        <input type="text" name="site_desc" class="form-control" value="<?php echo $config['site_desc'] ?? '' ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">版权信息</label>
    <div class="col-lg-9">
        <input type="text" name="site_copyright" class="form-control" value="<?php echo $config['site_copyright'] ?? '' ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">网站备案号</label>
    <div class="col-lg-9">
        <input type="text" name="site_record_number" class="form-control" value="<?php echo $config['site_record_number'] ?? '' ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <button type="submit" class="btn btn-sm btn-primary">保存</button>
        <button type="button" class="btn btn-sm btn-default" id="reset-site-btn">重置</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script>
    $(document).ready(function() {
        $("#reset-site-btn").click(function() {
            $("#site-form")[0].reset();
        });
    });
</script>