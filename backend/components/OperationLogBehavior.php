<?php


namespace backend\components;

use Yii;
use yii\helpers\Json;
use yii\base\UserException;
use backend\models\OperationLog;
use common\components\behaviors\ActiveRecordBehavior;

class OperationLogBehavior extends ActiveRecordBehavior
{

    private $_oldattributes = array();

    public function afterFind($event)
    {
        $attributes = $this->owner->getAttributes();
        $this->setOldAttributes($attributes);
        parent::afterFind($event);
    }

    public function afterUpdate($event)
    {
        $this->saveLogs($event, '修改');
        parent::afterUpdate($event);
    }

    public function afterInsert($event)
    {
        $this->saveLogs($event, '添加');
        parent::afterInsert($event);
    }

    public function afterDelete($event)
    {
        $this->saveLogs($event, '删除');
        parent::afterDelete($event);
    }

    private function saveLogs($event, $act)
    {
        // 只记录后台操作
        if (basename(Yii::$app->basePath) != 'backend') {
            return false;
        }
        $newattributes = $this->owner->getAttributes();
        $oldattributes = $this->getOldAttributes();
        // 获得该操作资源的类名
        $modelclass = get_class($this->owner);
        // 获得该操作资源的名称 如 ‘产品’、‘新闻’
        $model_vars = get_class_vars($modelclass);
        $resource_name = $model_vars['modelName'];
        // 获得该操作资源的主键
        $pk = $this->owner->getPrimaryKey();
        if (is_array($pk)) {
            $pk = implode(',', $pk);
        }
        if (!$pk) {
            $pk = 0;
        }
        //后台log
        $log = new OperationLog();
        //LOG 一级大类
        $type = $resource_name . '管理';
        //LOG 二级分类
        $category = $act . $resource_name;
        $model_attributes_old = json_encode($oldattributes);
        $model_attributes_new = json_encode($newattributes);
        $info = array(
            'ip' => Yii::$app->request->getUserIP(),
            'operator_id' => Yii::$app->user->identity->id,
            'operator_name' => Yii::$app->user->identity->username,
            'type' => $type,
            'category' => $category,
            'model' => $modelclass,
            'model_pk' => $pk,
            'model_attributes_old' => $model_attributes_old,
            'model_attributes_new' => $act == '删除' ? json_encode([]) : $model_attributes_new,
            'date' => date('Y-m-d H:i:s'),
            'time' => time(),
        );

        $log->attributes = $info;
        $log->save();

        if ($log->getErrors()) {
            throw new UserException(Json::encode($log->getErrors(), JSON_UNESCAPED_UNICODE));
        }
    }

    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }

    public function setOldAttributes($value)
    {
        $this->_oldattributes = $value;
    }
}
