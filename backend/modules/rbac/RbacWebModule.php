<?php

namespace backend\modules\rbac;

use dektrium\rbac\RbacWebModule as BaseModule;

class RbacWebModule extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\rbac\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
