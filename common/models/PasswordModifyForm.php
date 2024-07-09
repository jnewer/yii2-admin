<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * 修改密码表单模型
 */
class PasswordModifyForm extends Model
{
    public $password;
    public $newpassword;
    public $renewpassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'requiredFields' => [['password', 'newpassword', 'renewpassword'], 'required'],
            'compareFields' => [['renewpassword'], 'compare', 'compareAttribute'=>'newpassword'],
            'passwordValidate' => ['password', function ($attribute) {
                if (!Yii::$app->user->identity->validatePassword($this->password)) {
                    $this->addError($attribute, '当前密码错误，请重新输入。');
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => '当前密码',
            'newpassword' => '新的密码',
            'renewpassword' => '确认新密码',
        ];
    }

    public function modify()
    {
        $user= Yii::$app->user->identity;
        $user->setPassword($this->newpassword);
        return $user->save(false);
    }
}
