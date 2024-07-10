<?php

namespace common\models;

use common\components\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property integer $id [bigint(20)] ID
 * @property integer $level [int(11)] 级别
 * @property string $category [varchar(255)] 分类
 * @property double $log_time [double] 记录时间
 * @property string $prefix [text] 前缀
 * @property string $message [text] 错误信息
 */
class Log extends ActiveRecord
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
