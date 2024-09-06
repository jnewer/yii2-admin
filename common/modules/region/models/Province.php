<?php

namespace common\modules\region\models;

use Yii;
use common\components\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use backend\components\OperationLogBehavior;

/**
 * This is the model class for table "province".
 *
 * @property integer $id [mediumint(6) unsigned] ID
 * @property string $name [varchar(30)] 省份名称
 */
class Province extends ActiveRecord
{
    public static $modelName = '省份';
    public $fileAttributes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'province';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '省份名称',
        ];
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
