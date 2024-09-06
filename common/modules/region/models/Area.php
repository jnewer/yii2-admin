<?php

namespace common\modules\region\models;

use Yii;
use common\components\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use backend\components\OperationLogBehavior;

/**
 * This is the model class for table "area".
 *
 * @property integer $id [mediumint(6) unsigned] ID
 * @property string $name [varchar(60)] 区域名称
 * @property integer $pid [mediumint(6) unsigned] 城市id
 *
 * @property-read City $city 所属城市
 */
class Area extends ActiveRecord
{
    public static $modelName = '区域';
    public $fileAttributes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
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
            'name' => '区域名称',
            'pid' => '城市id',
            'city.name' => '所属城市'
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'pid']);
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
