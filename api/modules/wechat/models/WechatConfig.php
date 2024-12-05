<?php

namespace api\modules\wechat\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;
use yii\queue\LogBehavior;

/**
 * This is the model class for table "wechat_config".
 *
 * @property integer $id [int(11)] ID
 * @property string $name [varchar(50)] 名称
 * @property string $app_id [varchar(50)] AppID
 * @property string $app_secret [varchar(50)] AppSecret
 * @property string $server_url [varchar(100)] 服务器地址
 * @property string $token [varchar(50)] Token
 * @property string $encoding_aes_key [varchar(50)] EncodingAESKey
 * @property integer $kind [tinyint(3) unsigned] 账号分类
 * @property string $login_email [varchar(50)] 登录邮箱
 * @property string $login_password [varchar(50)] 登录密码
 * @property string $original_id [varchar(30)] 原始ID
 * @property string $qrcode_url [varchar(200)] 二维码URL
 * @property integer $auth_type [tinyint(3) unsigned] 授权类型
 * @property integer $status [int(11) unsigned] 状态
 * @property string $welcome_msg [varchar(200)] 欢迎语
 * @property string $created_at [datetime] 创建时间
 * @property string $updated_at [datetime] 更新时间
 *
 * @property string  $statusText 状态文字描述
 * @property string  $statusLabelClass 状态文字颜色
 * @property string  $kindText 分类文字描述
 */
class WechatConfig extends ActiveRecord
{
    public static $modelName = '微信配置';
    public $fileAttributes = ['qrcode_url'];

    public const KIND_SERVICE = 0;
    public const KIND_SUBSCRIBE = 1;
    public const KIND_APP = 2;

    public static $kindMap = [
        self::KIND_SERVICE => '服务号',
        self::KIND_SUBSCRIBE => '公众号',
        self::KIND_APP => '小程序',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static $statusMap = [
        self::STATUS_ACTIVE => '正常',
        self::STATUS_INACTIVE => '禁用',
    ];

    public const AUTH_TYPE_DIRECT = 0;
    public const AUTH_TYPE_OPEN_PLATFORM = 1;

    public static $authTypeMap = [
        self::AUTH_TYPE_DIRECT => '直接授权',
        self::AUTH_TYPE_OPEN_PLATFORM => '开放平台授权',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_config';
    }
    public function behaviors()
    {
        return [
            DatetimeBehavior::class,
            LogBehavior::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'app_id', 'app_secret', 'kind', 'status'], 'required'],
            [['kind', 'status'], 'integer'],
            [['name', 'app_id', 'app_secret', 'token', 'encoding_aes_key', 'login_email', 'login_password'], 'string', 'max' => 50],
            [['server_url'], 'string', 'max' => 100],
            [['original_id'], 'string', 'max' => 30],
            [['qrcode_url', 'welcome_msg'], 'string', 'max' => 200],
            [['original_id'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'app_id' => 'AppID',
            'app_secret' => 'AppSecret',
            'server_url' => '服务器地址',
            'token' => 'Token',
            'encoding_aes_key' => 'EncodingAESKey',
            'kind' => '账号分类',
            'login_email' => '登录邮箱',
            'login_password' => '登录密码',
            'original_id' => '原始ID',
            'qrcode_url' => '二维码URL',
            'auth_type' => '授权类型',
            'status' => '状态',
            'welcome_msg' => '欢迎语',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function getStatusText()
    {
        return self::$statusMap[$this->status] ?? '';
    }

    public function getStatusLabelClass()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'label-success';
        } elseif ($this->status == self::STATUS_INACTIVE) {
            return 'label-danger';
        }

        return 'label-default';
    }

    public function getKindText()
    {
        return self::$kindMap[$this->kind] ?? '';
    }

    public function getAuthTypeText()
    {
        return self::$authTypeMap[$this->auth_type] ?? '';
    }
}
