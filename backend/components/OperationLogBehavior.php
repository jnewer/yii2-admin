<?php


namespace backend\components;

use Yii;
use yii\helpers\Json;
use yii\base\UserException;
use backend\models\OperationLog;
use common\components\behaviors\ActiveRecordBehavior;

class OperationLogBehavior extends ActiveRecordBehavior
{

    private $oldAttributes = [];

    public function afterFind($event)
    {
        $attributes = $this->owner->getAttributes();
        $this->setOldAttributes($attributes);
        parent::afterFind($event);
    }

    public function afterUpdate($event)
    {
        $this->saveLogs('修改');
        parent::afterUpdate($event);
    }

    public function afterInsert($event)
    {
        $this->saveLogs('添加');
        parent::afterInsert($event);
    }

    public function afterDelete($event)
    {
        $this->saveLogs('删除');
        parent::afterDelete($event);
    }

    private function saveLogs($act)
    {
        // 只记录后台操作
        if (basename(Yii::$app->basePath) != 'backend') {
            return false;
        }
        // 获得该操作资源的类名
        $modelclass = get_class($this->owner);
        // 获得该操作资源的名称 如 ‘产品’、‘新闻’
        $modelVars = get_class_vars($modelclass);
        $modelName = $modelVars['modelName'];
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
        $type = $modelName . '管理';
        //LOG 二级分类
        $category = $act . $modelName;
        $oldAttributes = Json::encode($this->getOldAttributes(), JSON_UNESCAPED_UNICODE);
        $newAttributes = Json::encode($this->owner->getAttributes(), JSON_UNESCAPED_UNICODE);
        $info = array(
            'ip' => Yii::$app->request->getUserIP(),
            'operator_id' => Yii::$app->user->identity->id,
            'operator_name' => Yii::$app->user->identity->username,
            'type' => $type,
            'category' => $category,
            'model' => $modelclass,
            'model_pk' => $pk,
            'old_attributes' => $oldAttributes,
            'new_attributes' => $act == '删除' ? Json::encode([]) : $newAttributes,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $log->attributes = $info;
        $log->save();

        if ($log->getErrors()) {
            throw new UserException(Json::encode($log->getErrors(), JSON_UNESCAPED_UNICODE));
        }
    }

    public function getOldAttributes()
    {
        return $this->oldAttributes;
    }

    public function setOldAttributes($value)
    {
        $this->oldAttributes = $value;
    }
}
