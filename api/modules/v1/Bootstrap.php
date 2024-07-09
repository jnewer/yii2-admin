<?php

namespace api\modules\v1;

use Yii;
use yii\base\BootstrapInterface;

/**
 * v1 module bootstrap class
 */
class Bootstrap implements BootstrapInterface
{
    /** @inheritdoc */
    public function bootstrap($app)
    {
        Yii::$app->urlManager->addRules([
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => [
                    'v1/user',
                ],
            ],
        ]);
    }
}
