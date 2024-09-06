<?php
return [
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'retries' => 1,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => 'redis',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '--',
            'defaultTimeZone' => 'Asia/Shanghai',
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'config' => [
            'class'         => 'abhimanyu\config\components\Config', // Class (Required)
            'db'            => 'db',                                 // Database Connection ID (Optional)
            'tableName'     => '{{%config}}',                        // Table Name (Optioanl)
            'cacheId'       => 'cache',                              // Cache Id. Defaults to NULL (Optional)
            'cacheKey'      => 'config.cache',                       // Key identifying the cache value (Required only if cacheId is set)
            'cacheDuration' => 100                                   // Cache Expiration time in seconds. 0 means never expire. Defaults to 0 (Optional)
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 24 * 3600,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '',
                'password' => '',
            ],
        ],
        'log' => [
            'traceLevel' => 3,
            'targets' => [
                'app' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logVars' => ['_GET', '_POST', '_SESSION'],
                    'except' => [
                        'api',
                        'yii\base\UserException',
                        'yii\db\*',
                    ],
                ],
                'api' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'categories' => ['api', 'yii\base\UserException'],
                    'logVars' => ['_GET', '_POST', '_SESSION'],
                    'logFile' => '@runtime/logs/api.log',
                ],
                'email' => [
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error'],
                    'except' => [
                        'yii\base\UserException',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                        'common\base\*',
                    ],
                    'logVars' => ['_GET', '_POST', '_SESSION'],
                    'message' => [
                        'from' => [],
                        'to' => [''],
                        'subject' => '',
                    ],
                ],
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => ['_GET', '_POST', '_SESSION'],
                    'except' => [
                        'yii\base\UserException',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                    ],
                ],
                'debug' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'maxLogFiles' => 30,
                    'categories' => ['debug'],
                    'logVars' => ['_GET', '_POST', '_SESSION'],
                    'logFile' => '@runtime/logs/debug.log',
                ],
            ],
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'as log' => \yii\queue\LogBehavior::class,
        ],
    ],
    'modules' => [
        'region' => [
            'class' => 'backend\modules\region\Module',
        ],
    ]
];
