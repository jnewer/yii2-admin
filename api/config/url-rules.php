<?php
return [
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    [
        'class' => 'yii\rest\UrlRule', 'prefix' => '<appid:wx\w+>', 'controller' => [],
        'extraPatterns' => [
            'GET,POST,OPTIONS <id:\d+>/<action:.+?>/<uid:\w+>' => '<action>',//对单个对象的操作
            'GET,POST,OPTIONS <id:\d+>/<action:.+?>' => '<action>',//对单个对象的操作
            'GET,POST,OPTIONS <action:[a-z\-]+?>' => '<action>',//自定义get方法
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule', 'controller' => [
        'version'
        ],
        'extraPatterns' => [
            'GET,POST,OPTIONS <id:\d+>/<action:.+?>' => '<action>',//对单个对象的操作
            'GET,POST,OPTIONS <action:[a-z\-]+?>' => '<action>',//自定义get方法
        ],
    ],
];
