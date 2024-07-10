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

    public const LEVEL_ERROR = 1;
    public const LEVEL_WARNING = 2;
    public const LEVEL_INFO = 4;
    public const LEVEL_TRACE = 8;
    public const LEVEL_PROFILE = 64;
    public const LEVEL_PROFILE_BEGIN = 80;
    public const LEVEL_PROFILE_END = 96;

    public static $levelMap = [
        self::LEVEL_ERROR => '错误',
        self::LEVEL_WARNING => '警告',
        self::LEVEL_INFO => '信息',
        self::LEVEL_TRACE => '跟踪',
        self::LEVEL_PROFILE => '性能',
        self::LEVEL_PROFILE_BEGIN => '性能开始',
        self::LEVEL_PROFILE_END => '性能结束',
    ];

    /**
     * @var array
     */
    public $levelClasses = [
        self::LEVEL_ERROR => 'label-danger',
        self::LEVEL_WARNING => 'label-warning',
        self::LEVEL_INFO => 'label-info',
        self::LEVEL_TRACE => 'label-default',
        self::LEVEL_PROFILE => 'label-default',
        self::LEVEL_PROFILE_BEGIN => 'label-default',
        self::LEVEL_PROFILE_END => 'label-default',
    ];

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
            'levelName' => '级别',
        ];
    }

    public function getLevelName()
    {
        return self::$levelMap[$this->level] ?? '未知';
    }
}
