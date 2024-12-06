<?php

namespace api\modules\wechat\models;

use Yii;
use yii\queue\LogBehavior;
use yii\web\IdentityInterface;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;

/**
 * This is the model class for table "wechat_user".
 *
 * @property integer $id [int(11)] ID
 * @property integer $wechat_config_id [int(11) unsigned] 公众号配置ID
 * @property string $openid [varchar(32)] openid
 * @property string $nickname [varchar(32)] 昵称
 * @property integer $sex [tinyint(1) unsigned] 性别
 * @property string $province [varchar(20)] 省份
 * @property string $city [varchar(20)] 城市
 * @property string $country [varchar(20)] 国家
 * @property string $headimgurl [varchar(255)] 头像
 * @property string $privilege [varchar(512)] 用户特权信息
 * @property string $unionid [varchar(32)] unionid
 * @property string $access_token [varchar(64)] access_token
 * @property string $created_at [datetime] 创建时间
 * @property string $updated_at [datetime] 更新时间
 * @property string $subscribed_at [datetime] 关注时间
 * @property string $auth_key [varchar(32)] 授权KEY
 *
 * @property WechatConfig $wechatConfig
 */
class WechatUser extends ActiveRecord implements IdentityInterface
{
    public static $modelName = '微信用户表';
    public $fileAttributes = ['headimgurl'];

    public const SEX_UNKNOWN = 0;
    public const SEX_MALE = 1;
    public const SEX_FEMALE = 2;

    public static $sexMap = [
        self::SEX_UNKNOWN => '未知',
        self::SEX_MALE => '男',
        self::SEX_FEMALE => '女',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_user';
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
            [['wechat_config_id', 'openid'], 'required'],
            [['wechat_config_id'], 'integer'],
            [['created_at', 'updated_at', 'subscribed_at'], 'safe'],
            [['openid', 'nickname', 'unionid'], 'string', 'max' => 32],
            [['province', 'city', 'country'], 'string', 'max' => 20],
            [['headimgurl'], 'string', 'max' => 255],
            [['privilege'], 'string', 'max' => 512],
            [['access_token'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wechat_config_id' => '公众号配置ID',
            'openid' => 'openid',
            'nickname' => '昵称',
            'sex' => '性别',
            'province' => '省份',
            'city' => '城市',
            'country' => '国家',
            'headimgurl' => '头像',
            'privilege' => '用户特权信息',
            'unionid' => 'unionid',
            'access_token' => 'access_token',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'subscribed_at' => '关注时间',
            'wechatConfig.name' => '微信配置名称',
            'auth_key' => '授权KEY',
        ];
    }

    public function getWechatConfig()
    {
        return $this->hasOne(WechatConfig::class, ['id' => 'wechat_config_id']);
    }

    public function getSexText()
    {
        return self::$sexMap[$this->sex] ?? '';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key']);
        unset($fields['access_token']);

        return $fields;
    }
}
