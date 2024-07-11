<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Class PhpInfo
 * @package backend\components\helper
 */
class PhpInfo extends Model
{

    public $phpVersion = PHP_VERSION;
    public $phpBinary = PHP_BINDIR;
    public $phpConfigFilePath;
    public $phpExtensionDir = PHP_EXTENSION_DIR;
    public $maxExecutionTime;
    public $postMaxSize;
    public $fileUploads;
    public $maxUploadSize;
    public $maxFileUploads;
    public $uploadTmpDir;
    public $memoryLimit;
    public $shortOpenTag;
    public $documentRoot;

    public $yiiVersion;

    public function init()
    {
        $this->phpConfigFilePath =  php_ini_loaded_file();
        $this->maxExecutionTime = ini_get('max_execution_time') . '秒';
        $this->postMaxSize      = ini_get('post_max_size');
        $this->maxUploadSize    = ini_get('upload_max_filesize');
        $this->fileUploads      = ini_get('file_uploads') ? '开' : '关';
        $this->maxFileUploads   = ini_get('max_file_uploads') . '个';
        $this->uploadTmpDir     = ini_get('upload_tmp_dir');
        $this->memoryLimit      = ini_get('memory_limit');
        $this->shortOpenTag     = ini_get('short_open_tag') ? '是' : '否';
        $this->documentRoot     = $_SERVER['DOCUMENT_ROOT'];
        $this->yiiVersion       = Yii::getVersion();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phpBinary'         => 'PHP命令目录',
            'maxExecutionTime'  => 'PHP超时限制',
            'phpConfigFilePath' => 'PHP配置文件目录',
            'phpExtensionDir'   => 'PHP扩展目录',
            'phpVersion'        => 'PHP版本',
            'postMaxSize'       => 'POST数据限制',
            'yiiVersion'        => 'Yii2版本',
            'maxUploadSize'     => '上传文件大小',
            'maxFileUploads'    => '上传文件数量',
            'uploadTmpDir'      => '临时文件保存地址',
            'memoryLimit'       => '内存限制',
            'fileUploads'       => '上传文件开关',
            'shortOpenTag'      => '开启短标签',
            'documentRoot'      => '入口文件目录',
        ];
    }
}
