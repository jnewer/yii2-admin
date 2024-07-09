<?php

namespace common\models;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $level
 * @property string $category
 * @property double $log_time
 * @property string $prefix
 * @property string $message
 */
class Log extends \common\components\ActiveRecord
{
    public static $modelName = '系统日志';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['log_time'], 'number'],
            [['prefix', 'message'], 'string'],
            [['category'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '级别',
            'category' => '分类',
            'log_time' => '记录时间',
            'prefix' => '前缀',
            'message' => '错误信息',
        ];
    }
}
