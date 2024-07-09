<?php

namespace backend\models;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "operation_log".
 *
 * @property integer $id [int(11)] ID
 * @property string $date [datetime] 操作时间
 * @property integer $time [int(11)] 时间戳
 * @property string $ip [char(15)] 操作员ip
 * @property integer $operator_id [int(11)] 操作员id
 * @property string $operator_name [varchar(50)] 操作员名
 * @property string $type [varchar(50)] 操作行为的大类
 * @property string $category [varchar(40)] 该操作属于何种性质的操作(常规维护 或者其它 )
 * @property string $description [varchar(255)] 操作员输入的操作描述
 * @property integer $is_delete [tinyint(1)] 是否已标记为删除. 0否, 1是.
 * @property string $model [varchar(50)] 操作的model
 * @property string $model_pk [varchar(100)] 操作的model的主键
 * @property string $model_attributes_old [text] 旧数据
 * @property string $model_attributes_new [text] 新数据
 */
class OperationLog extends ActiveRecord
{
    public static $modelName = '操作日志表';

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
            [['date'], 'safe'],
            [['time', 'ip', 'operator_name', 'type', 'model_pk', 'model_attributes_old', 'model_attributes_new'], 'required'],
            [['time', 'operator_id'], 'integer'],
            [['is_delete'], 'boolean'],
            [['model_attributes_old', 'model_attributes_new'], 'string'],
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
            'date' => '操作时间',
            'time' => '时间戳',
            'ip' => '用户ip',
            'operator_id' => '用户id',
            'operator_name' => '用户名',
            'type' => '操作大类',
            'category' => '操作小类',
            'description' => '操作员输入的操作描述',
            'is_delete' => '是否已标记为删除. 0否, 1是.',
            'model' => '操作的model',
            'model_pk' => '操作的model的主键',
            'model_attributes_old' => '旧数据',
            'model_attributes_new' => '新数据',
            'attributeDesc' => '操作描述',
        ];
    }

    public function getAttributeDesc()
    {
        $model_attributes_old = Json::decode($this->model_attributes_old, true);
        $model_attributes_new = Json::decode($this->model_attributes_new, true);

        $string = '';
        // 日志记录的资源类 如Product、Notice
        $modelclass = $this->model;
        // 获得表的项
        if ($modelclass) {
            $model = new $modelclass;
            $attributeLabels = $model->attributeLabels();
            if (!empty($attributeLabels)) {
                $string .= "<TABLE class='operation_log' style='width: 100%'>";
                $string .= "<TBODY><TR><TH style='min-width: 100px;'>修改项</TH><TH>旧数据</TH><TH>新数据</TH></TR>";
                foreach ($attributeLabels as $key => $name) {
                    $old_value = $model_attributes_old[$key];
                    $new_value = $model_attributes_new[$key];
                    $class = $old_value == $new_value ? '' : ' class="update_diff"';
                    $string .= "<TR".$class."><TR><TD>$name</TD><TD>$old_value</TD><TD>$new_value</TD></TR>";
                }
                $string .= "</TBODY></TABLE>";
            }
        } else {
            $attributeLabels = $model_attributes_old?$model_attributes_old:$model_attributes_new;
            $attributeLabels = array_keys($attributeLabels);
            $string .= "<TABLE class=operation_log style='width: 100%'>";
            $string .= "<TBODY><TR><TH>修改项</TH><TH>旧数据</TH><TH>新数据</TH></TR>";
            foreach ($attributeLabels as $key => $name) {
                $old_value = $model_attributes_old[$name];
                $new_value = $model_attributes_new[$name];
                $class = $old_value == $new_value ? '' : ' class="update_diff"';
                if (is_array($old_value)) {
                    $old_value = implode(',', $old_value);
                }
                if (is_array($new_value)) {
                    $new_value = implode(',', $new_value);
                }
                $string .= "<TR".$class."><TR><TD>$name</TD><TD>$old_value</TD><TD>$new_value</TD></TR>";
            }
            $string .= "</TBODY></TABLE>";
        }
        return $string;
    }

    public static function create($type, $category, $attributes_old, $attributes_new)
    {
        $log = new OperationLog();
        $info = array(
            'ip'=>Yii::$app->request->getUserIP(),
            'operator_id'=>Yii::$app->user->identity->id,
            'operator_name'=>Yii::$app->user->identity->username,
            'type'=>$type,
            'category'=>$category,
            'model'=>'',
            'model_pk'=>0,
            'model_attributes_old'=>Json::encode($attributes_old),
            'model_attributes_new'=>Json::encode($attributes_new),
            'date'=>date('Y-m-d H:i:s'),
            'time'=>time(),
        );
        $log->attributes = $info;
        $log->save();
    }
}
