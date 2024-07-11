<?php

namespace backend\models;

use yii\base\Model;

class SystemInfo extends Model
{
    public $os;
    public $osVersion;
    public $osMachineType;
    public $hostname;
    public $serverName;
    public $serverSoftware;
    public $serverProtocol;
    public $databaseDriverName;
    public $databaseVersion;
    public $databaseUser;
    public $databaseCharset;
    public $enableSchemaCache;
    public $schemaCacheDuration;
    public $tablePrefix;

    public function init()
    {
        $this->os                  = PHP_OS;
        $this->osVersion           = php_uname('v');
        $this->osMachineType       = php_uname('m');
        $this->hostname            = php_uname('n');
        $this->serverProtocol      = $_SERVER['SERVER_PROTOCOL'];
        $this->serverSoftware      = $_SERVER['SERVER_SOFTWARE'];
        $this->serverName          = $_SERVER['SERVER_NAME'];
        $this->databaseVersion     = db()->getServerVersion();
        $this->databaseDriverName  = db()->getDriverName();
        $this->databaseUser        = db()->username;
        $this->databaseCharset     = db()->charset;
        $this->enableSchemaCache   = db()->enableSchemaCache ? '是' : '否';
        $this->schemaCacheDuration = (db()->enableSchemaCache ? db()->schemaCacheDuration : 0) . '秒';
        $this->tablePrefix         = db()->tablePrefix ?: '无';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'os'                  => '系统类型',
            'osVersion'           => '系统版本',
            'osMachineType'       => '机器类型',
            'hostname'            => '主机名',
            'serverName'          => '当前域名',
            'serverProtocol'      => '服务协议',
            'serverSoftware'      => '服务软件',
            'databaseDriverName'  => '数据库类型',
            'databaseVersion'     => '数据库版本',
            'databaseUser'        => '数据库用户',
            'databaseCharset'     => '数据库字符集',
            'enableSchemaCache'   => '缓存表结构',
            'schemaCacheDuration' => '缓存表结构时间',
            'tablePrefix'         => '表前缀',
        ];
    }
}
