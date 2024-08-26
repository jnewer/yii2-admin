<?php

namespace backend\models;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "operation_log".
 *
 * @property integer $id [int(11)] ID
 * @property integer $operator_id [int(11)] 操作人id
 * @property string $operator_name [varchar(50)] 操作人名
 * @property string $type [varchar(50)] 操作行为的大类
 * @property string $category [varchar(40)] 该操作属于何种性质的操作(常规维护 或者其它 )
 * @property string $ip [char(15)] 操作员ip
 * @property string $description [varchar(255)] 操作员输入的操作描述
 * @property string $model [varchar(50)] 操作的model
 * @property string $model_pk [varchar(20)] 操作的model的主键
 * @property string $oldAttributes [text] 旧数据
 * @property string $newAttributes [text] 新数据
 * @property string $created_at [datetime] 操作时间
 *
 * @property-read string $attributeDesc
 */
class OperationLog extends ActiveRecord
{
    public static $modelName = '操作日志';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation_log';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['ip', 'operator_name', 'type', 'model_pk', 'old_attributes', 'new_attributes'], 'required'],
            [['operator_id'], 'integer'],
            [['old_attributes', 'new_attributes'], 'string'],
            [['ip'], 'string', 'max' => 15],
            [['operator_name', 'type', 'model'], 'string', 'max' => 50],
            [['category'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operator_id' => '操作人id',
            'operator_name' => '操作人名',
            'type' => '操作大类',
            'category' => '操作小类',
            'ip' => '操作人ip',
            'description' => '描述',
            'model' => '模型',
            'model_pk' => '模型主键',
            'old_attributes' => '旧数据',
            'new_attributes' => '新数据',
            'created_at' => '操作时间',
        ];
    }

    public function getAttributeDesc()
    {
        $oldAttributes = Json::decode($this->old_attributes, true);
        $newAttributes = Json::decode($this->new_attributes, true);

        $string = '';
        // 日志记录的资源类 如Product、Notice
        $modelclass = $this->model;
        // 获得表的项
        if ($modelclass) {
            $model = new $modelclass;
            $attributeLabels = $model->attributeLabels();
            if (!empty($attributeLabels)) {
                $string .= "<table class='operation_log' style='width: 100%'>";
                $string .= "<tbody><tr><th style='min-width: 100px;'>修改项</th><th>旧数据</th><th>新数据</th></tr>";
                foreach ($attributeLabels as $key => $name) {
                    $oldValue = $oldAttributes[$key] ?? '';
                    $newValue = $newAttributes[$key] ?? '';
                    $style = $oldValue == $newValue ? '' : 'style="background-color: yellow;"';
                    $string .= "<tr" . $style . "><tr><td>$name</td><td>$oldValue</td><td>$newValue</td></tr>";
                }
                $string .= "</tbody></table>";
            }
        } else {
            $attributeLabels = $oldAttributes ?: $newAttributes;
            $attributeLabels = array_keys($attributeLabels);
            $string .= "<table class=operation_log style='width: 100%'>";
            $string .= "<tbody><tr><th>修改项</th><th>旧数据</th><th>新数据</th></tr>";
            foreach ($attributeLabels as $key => $name) {
                $oldValue = $oldAttributes[$name] ?? '';
                $newValue = $newAttributes[$name] ?? '';
                $style = $oldValue == $newValue ? '' : 'style="background-color: yellow;"';
                if (is_array($oldValue)) {
                    $oldValue = implode(',', $oldValue);
                }
                if (is_array($newValue)) {
                    $newValue = implode(',', $newValue);
                }
                $string .= "<tr" . $style . "><tr><td>$name</td><td>$oldValue</td><td>$newValue</td></tr>";
            }
            $string .= "</tbody></table>";
        }

        return $string;
    }

    public static function create($type, $category, $attributes_old, $attributes_new)
    {
        $log = new OperationLog();
        $info = array(
            'ip' => Yii::$app->request->getUserIP(),
            'operator_id' => Yii::$app->user->identity->id,
            'operator_name' => Yii::$app->user->identity->username,
            'type' => $type,
            'category' => $category,
            'model' => '',
            'model_pk' => 0,
            'old_attributes' => Json::encode($attributes_old),
            'new_attributes' => Json::encode($attributes_new),
            'created_at' => date('Y-m-d H:i:s')
        );
        $log->attributes = $info;
        $log->save();
    }
}
