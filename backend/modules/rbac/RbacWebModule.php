<?php

namespace backend\modules\rbac;

use Yii;
use dektrium\rbac\RbacWebModule as BaseModule;

class RbacWebModule extends BaseModule
{
    /** @var bool Whether to show flash messages */
    public $enableFlashMessages = true;

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

        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['rbac*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '/messages',
        ];
    }
}
