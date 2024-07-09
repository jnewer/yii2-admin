<?php

/**
 * This class only exists here for IDE (PHPStorm/Netbeans/...) autocompletion.
 * This file is never included anywhere.
 * Adjust this file to match classes configured in your application config, to enable IDE autocompletion for custom components.
 * Example: A property phpdoc can be added in `__Application` class as `@property \vendor\package\Rollbar|__Rollbar $rollbar` and adding a class in this file
 * ```php
 * // @property of \vendor\package\Rollbar goes here
 * class __Rollbar {
 * }
 * ```
 */
class Yii
{
    /**
     * @var __Application|\yii\web\Application|\yii\console\Application|\common\components\WebApplication
     */
    public static $app;
}

/**
 * @property yii\rbac\DbManager $authManager
 * @property __WebUser|\yii\web\User $user
 * @property abhimanyu\config\components\Config $config
 * @property  yii\redis\Mutex $mutex
 * @property  yii\redis\Connection $redis
 */
class __Application
{
}

/**
 * @property common\models\User $identity
 */
class __WebUser
{
}
