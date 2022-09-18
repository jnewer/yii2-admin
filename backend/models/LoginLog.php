<?php

namespace backend\models;

use backend\components\OperationLogBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;

/**
 * This is the model class for table "login_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $login_ip
 * @property string $created_at
 */
class LoginLog extends \common\components\ActiveRecord
{
    public static $modelName = '登录日志表';
    public $fileAttributes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_log';
    }
    public function behaviors()
    {
        return [
            DatetimeBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'login_ip'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 64],
            [['login_ip'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'username' => '用户名',
            'login_ip' => '登录Ip',
            'updated_at' => '更新时间',
            'created_at' => '登陆时间',
        ];
    }
}
