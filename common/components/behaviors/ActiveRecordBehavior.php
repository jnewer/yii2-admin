<?php


namespace common\components\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class ActiveRecordBehavior extends Behavior
{

    /**
     * @return array|string[]
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT    =>  'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE    =>  'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE    =>  'afterDelete',
            ActiveRecord::EVENT_AFTER_FIND    =>  'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT    =>  'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE    =>  'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE    =>  'beforeDelete',
        ];
    }

    /**
     * @param $event
     */
    public function afterInsert($event)
    {
    }

    /**
     * @param $event
     */
    public function afterUpdate($event)
    {
    }

    /**
     * @param $event
     */
    public function afterDelete($event)
    {
    }

    /**
     * @param $event
     */
    public function afterFind($event)
    {
    }

    /**
     * @param $event
     */
    public function beforeInsert($event)
    {
    }

    /**
     * @param $event
     */
    public function beforeUpdate($event)
    {
    }

    /**
     * @param $event
     */
    public function beforeDelete($event)
    {
    }
}
