<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use common\components\ActiveRecord;
use yii\base\NotSupportedException;
use kartik\password\StrengthValidator;
use backend\components\OperationLogBehavior;
use common\components\behaviors\DatetimeBehavior;

/**
 * User model
 *
 * @property integer $id [int(11)] ID
 * @property string $username [varchar(32)] 用户名
 * @property string $nickname [varchar(32)] 昵称
 * @property string $auth_key [varchar(32)] 授权KEY
 * @property string $password_hash [varchar(64)] 密码
 * @property string $password_reset_token [varchar(64)] 密码重置TOKEN
 * @property string $email [varchar(32)] 邮箱
 * @property integer $status [smallint(1)] 状态
 * @property integer $created_at [datetime] 创建时间
 * @property integer $updated_at [datetime] 更新时间
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static $modelName = '用户';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static $statusMap = [
        self::STATUS_ACTIVE => '正常',
        self::STATUS_INACTIVE => '已禁用',
    ];

    public $password;
    public $roles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            DatetimeBehavior::class,
            OperationLogBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['username', 'auth_key', 'password_hash', 'email','status'], 'required'],
            [['status'], 'integer'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 64],
            [['username','nickname', 'email','auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['password', 'roles', 'created_at', 'updated_at'], 'safe'],
            [['password'], StrengthValidator::class, 'preset' => 'normal', 'userAttribute' => 'username'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'auth_key' => '授权KEY',
            'password' => '密码',
            'password_hash' => '密码',
            'password_reset_token' => '密码重置TOKEN',
            'email' => '邮箱',
            'status' => '状态',
            'roles' => '系统角色',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function afterFind()
    {
        parent::beforeValidate();

        if (Yii::$app->has('authManager')) {
            $roles = Yii::$app->authManager->getRolesByUser($this->id);
            if (!empty($roles)) {
                $roles = array_keys($roles);
                $this->roles = $roles[0];
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->authManager->revokeAll($this->id);
        if (!empty($this->roles)) {
            // 授予角色
            $role = Yii::$app->authManager->getRole($this->roles);
            Yii::$app->authManager->assign($role, $this->id);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 得到当前用户的角色名称
     * @return string
     */
    public function getRoleNames($as_array = false)
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);

        $names = [];
        foreach ($roles as $role) {
            $names[$role->name] = $role->description && !$as_array ? $role->description : $role->name;
        }

        if ($as_array) {
            return $names;
        }

        return implode('/', $names);
    }
}
