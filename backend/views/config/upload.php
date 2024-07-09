<?php


use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ],
    'id' => 'upload-form'
]); ?>
<div class="form-group">
    <label class="col-lg-3 control-label">文件类型</label>
    <div class="col-lg-9">
        <input type="text" name="upload_allow_file_ext" class="form-control" value="<?php echo $config['upload_allow_file_ext'] ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">文件大小(M)</label>
    <div class="col-lg-9">
        <input type="text" name="upload_allow_file_size" class="form-control" value="<?php echo $config['upload_allow_file_size'] ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">图片类型</label>
    <div class="col-lg-9">
        <input type="text" name="upload_allow_image_ext" class="form-control" value="<?php echo $config['upload_allow_image_ext'] ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">图片大小(M)</label>
    <div class="col-lg-9">
        <input type="text" name="upload_allow_image_size" class="form-control" value="<?php echo $config['upload_allow_image_size'] ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <button type="submit" class="btn btn-sm btn-primary">保存</button>
        <button type="button" class="btn btn-sm btn-default" id="reset-upload-btn">重置</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script>
    $(document).ready(function() {
        $("#reset-upload-btn").click(function() {
            $("#upload-form")[0].reset();
        });
    });
</script>