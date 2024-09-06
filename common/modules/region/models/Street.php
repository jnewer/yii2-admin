<?php

namespace common\modules\region\models;

use Yii;
use common\components\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use backend\components\OperationLogBehavior;

/**
 * This is the model class for table "street".
 *
 * @property integer $id [mediumint(6) unsigned] ID
 * @property string $name [varchar(60)] 街道名称
 * @property integer $pid [mediumint(6) unsigned] 区域id
 *
 * @property-read Area $area 所属区域
 */
class Street extends ActiveRecord
{
    public static $modelName = '街道';
    public $fileAttributes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'street';
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
            'name' => '街道名称',
            'pid' => '区域id',
            'area.name' => '所属区域'
        ];
    }

    public function getArea()
    {
        return $this->hasOne(Area::class, ['id' => 'pid']);
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
