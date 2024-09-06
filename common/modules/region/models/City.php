<?php

namespace common\modules\region\models;

use Yii;
use common\components\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use backend\components\OperationLogBehavior;

/**
 * This is the model class for table "city".
 *
 * @property integer $id [mediumint(6) unsigned] ID
 * @property string $name [varchar(60)] 城市名称
 * @property integer $pid [mediumint(6) unsigned] 省份id
 *
 * @property-read Province $province 所属省份
 */
class City extends ActiveRecord
{
    public static $modelName = '城市';
    public $fileAttributes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pid'],'required'],
            [['pid'], 'integer'],
            [['name'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '城市名称',
            'pid' => '省份id',
            'province.name' => '所属省份'
        ];
    }

    public function getProince()
    {
        return $this->hasOne(Province::class, ['id' => 'pid']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            OperationLogBehavior::class,
        ];
    }
}
