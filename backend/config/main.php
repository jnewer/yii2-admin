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
