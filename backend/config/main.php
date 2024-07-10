<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'Yii2-Admin',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'rbac' => [
            'class' => 'backend\modules\rbac\RbacWebModule',
            'admins' => ['admin'],
        ],
        'log-reader' => [
            'class' => 'backend\modules\logReader\Module',
            'aliases' => [
                'backend-app' => '@backend/runtime/logs/app.log',
                'backend-debug' => '@backend/runtime/logs/debug.log',
                'backend-db' => '@backend/runtime/logs/db.log',
                'backend-email' => '@backend/runtime/logs/email.log',
                'api-app' => '@api/runtime/logs/app.log',
                'api-api' => '@api/runtime/logs/api.log',
                'api-debug' => '@api/runtime/logs/debug.log',
                'api-db' => '@api/runtime/logs/db.log',
                'api-email' => '@api/runtime/logs/email.log',
                'console-app' => '@console/runtime/logs/app.log',
                'console-debug' => '@console/runtime/logs/debug.log',
                'console-db' => '@console/runtime/logs/db.log',
                'console-email' => '@console/runtime/logs/email.log',
            ],
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => 'backend\components\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 60 * 30,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'app-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager',
        // ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/rbac/views' => '@app/modules/rbac/views'
                ],
            ],
        ],

        'urlManager' => [
            'class' => 'backend\components\RUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'assetManager' => [
            'bundles' => require(__DIR__ . '/' . (YII_ENV === 'prod' ? 'assets-prod.php' : 'assets-dev.php'))
        ],
        // 'i18n' => [
        //     'translations' => [
        //         'app*' => [
        //             'class' => 'yii\i18n\PhpMessageSource',
        //             //'basePath' => '@app/messages',
        //             //'sourceLanguage' => 'en-US',
        //             'fileMap' => [
        //                 'app' => 'app.php',
        //                 'rbac' => '@app/modules/rbac/messages',
        //             ],
        //         ],
        //     ],
        // ],

    ],
    'params' => $params,
];
