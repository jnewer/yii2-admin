<?php

namespace common\components;

use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;

class ActiveRecord extends BaseActiveRecord
{
    //日期属性
    public $dateAttributes = [];

    public static $usedIds = [];

    // SELECT FOR UPDATE 锁定
    public function lockForUpdate()
    {
        if ($this->getDb()->getTransaction() === null) {
            throw new Exception('Running transaction is required');
        }

        $pk = ArrayHelper::getValue(self::primaryKey(), 0);
        $model = self::findBySql('SELECT * FROM `' . $this->tableName() . '` WHERE ' . $pk . ' = :pk FOR UPDATE', [
            ':pk' => $this->getPrimaryKey(),
        ])->one();

        $this->refreshInternal($model);
    }

    /**
     * 抛出错误的保存方法
     */
    public function save($runValidation = true, $attributes = null, $throwException = true)
    {
        if ($throwException) {
            if (!parent::save($runValidation, $attributes)) {
                $ers = [];
                foreach ($this->errors as $val) {
                    $ers[] = implode('', $val);
                }
                throw new \yii\base\UserException(implode('', $ers));
            } else {
                return true;
            }
        } else {
            return parent::save($runValidation, $attributes);
        }
    }

    /**
     * 返回列表项目 供dropdownlist、checkboxlist、radiobuttonlist使用
     *
     * @param  string  $id     值字段名
     * @param  string  $name   名称字段名
     * @param  string  $group  分组字段名
     * @param  string  $sort   排序字段名
     * @param  string  $condition   附加查询条件
     * @return array
     */
    public function getListData($valueField = 'id', $textField = 'name', $groupField = null, $sort = '', $condition = '', $condition2 = '')
    {
        $key = get_class($this) . $valueField . $textField . $groupField . $sort . $condition;
        $key = md5(Yii::$app->user->id . $key);

        // $data = Yii::$app->cache->get($key);
        // if ($data === false) {
        if (empty($sort)) {
            $sort = $this->hasAttribute('sortnum') ? 'sortnum' : 'id';
        }

        $sort = $this->hasAttribute('first_char') ? 'first_char' : $sort; //首字母排序优先
        if (empty($groupField)) {
            $groupField = $this->hasAttribute('first_char') ? 'first_char' : null;
        }
        //有首字母字段的，用于分组

        $query = Yii::createObject(ActiveQuery::class, [get_class($this)]);
        $query->orderBy($sort . ' ASC');

        if ($this->hasAttribute('deleted')) {
            $query->andWhere(['deleted' => 0]);
        }

        if (!empty($condition)) {
            $query->andWhere($condition);
        }

        if (!empty($condition2)) {
            $query->andWhere($condition2);
        }

        return yii\helpers\ArrayHelper::map($query->all(), $valueField, $textField, $groupField);
    }

    /**
     * 返回禁用项目 供dropdownlist、checkboxlist、radiobuttonlist使用
     * @param  string $valueField [description]
     * @return [type]             [description]
     */
    public function getListOptions($valueField = 'id')
    {
        if (!$this->hasAttribute('stoped') && !$this->hasAttribute('is_enabled')) {
            return array();
        }

        $models = Yii::createObject(ActiveQuery::class, [get_class($this)]);
        if ($this->hasAttribute('deleted')) {
            $models->where(['deleted' => 0]);
        }

        $objs = $models->all();
        $options = array();
        foreach ($objs as $data) {
            if ($this->hasAttribute('stoped') && $data->stoped) {
                $options[$data->$valueField] = array('disabled' => true);
            }

            if ($this->hasAttribute('is_enabled') && !$data->is_enabled) {
                $options[$data->$valueField] = array('disabled' => true);
            }
        }

        return $options;
    }

    public function getConstOptions($prefix, $except = [])
    {
        $options = array();

        $rec = new \ReflectionClass(get_class($this));
        $consts = $rec->getConstants();
        if (is_array($consts)) {
            foreach ($consts as $name => $value) {
                if (strpos($name, $prefix) === 0) {
                    $options[$value] = $value;
                }
            }
        }
        if (!empty($except)) {
            foreach ($except as $item) {
                unset($options[$item]);
            }
        }

        return $options;
    }

    /**
     * 处理上传文件
     * @param  array  $attributes 文件上传属性
     * @return void
     */
    public function uploadFiles(array $attributes, $extensions = ['jpg', 'png', 'jpeg', 'gif', 'zip', 'rar', '7z', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'mp4', 'avi', 'mov'])
    {
        $className = explode('\\', get_class($this));
        $className = array_pop($className);

        $validator = new FileValidator(['skipOnEmpty' => true, 'extensions' => $extensions]);
        foreach ($attributes as $attribute) {
            $file = UploadedFile::getInstance($this, $attribute);
            if ($file !== null) {
                if ($validator->validate($file, $error)) {
                    $filename = time() . rand(1000, 9999) . '.' . $file->getExtension();

                    $dir = '/upload/' . strtolower($className) . '/' . $attribute . '/' . date('Ym') . '/';
                    if (!file_exists(Yii::getAlias('@webroot') . $dir)) {
                        FileHelper::createDirectory(Yii::getAlias('@webroot') . $dir);
                    }

                    $filepath = '@webroot' . $dir . $filename;
                    $filepath = Yii::getAlias($filepath);
                    if ($file->saveAs($filepath)) {
                        $this->$attribute = $dir . $filename;
                    }
                } else {
                    $this->addError($attribute, $error);
                }
            }
        }
    }

    public function uploadImages(array $attributes, $extensions = ['jpg', 'png', 'jpeg', 'gif'], $dirPrefix = '', $maxSize = 1024 * 1024)
    {
        $className = explode('\\', get_class($this));
        $className = array_pop($className);

        $validator = new ImageValidator(['skipOnEmpty' => true, 'extensions' => $extensions, 'maxSize' => $maxSize, 'tooBig' => '图片文件体积过大，不能超过{formattedLimit}.']);
        foreach ($attributes as $attribute) {
            $file = UploadedFile::getInstance($this, $attribute);
            if ($file !== null) {
                if ($validator->validate($file, $error)) {
                    $filename = time() . rand(1000, 9999) . '.' . $file->getExtension();

                    $dir = ($dirPrefix ? $dirPrefix : '/upload/' . strtolower($className) . '/' . $attribute) . '/' . date('Ym') . '/';
                    if (!file_exists(Yii::getAlias('@webroot') . $dir)) {
                        FileHelper::createDirectory(Yii::getAlias('@webroot') . $dir);
                    }

                    $filepath = '@webroot' . $dir . $filename;
                    $filepath = Yii::getAlias($filepath);
                    if ($file->saveAs($filepath)) {
                        $this->$attribute = $dir . $filename;
                    }
                } else {
                    $this->addError($attribute, $error);
                }
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!isset($this->fileAttributes) || !is_array($this->fileAttributes)) return;
        foreach ($this->fileAttributes as $attribute) {
            if (isset($changedAttributes[$attribute])) {
                $filename = realpath(Yii::getAlias("@webroot") . $changedAttributes[$attribute]);
                if (is_file($filename)) {
                    @unlink($filename);
                }
            }
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if (!isset($this->fileAttributes) || !is_array($this->fileAttributes)) return;
        foreach ($this->fileAttributes as $attribute) {
            $filename = realpath(Yii::getAlias("@webroot") . $this->$attribute);
            if (is_file($filename)) {
                @unlink($filename);
            }
        }
    }

    public function getErrorstr()
    {
        foreach ($this->errors as $val) {
            $ers[] = implode('', $val);
        }
        return implode('', $ers);
    }

    /**
     * @param $pk
     * @return static
     * @throws UserException
     */
    public static function findModel($pk)
    {
        $model = static::findOne($pk);
        if ($model === null) {
            throw new UserException(static::$modelName . '不存在');
        }

        return $model;
    }
}
