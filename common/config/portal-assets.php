<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', __DIR__ . '/../../portal/web');
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar ./bin/closure-compiler-v20180402.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar ./bin/yuicompressor-2.4.8.jar --type css {from} -o {to}',
    // The list of asset bundles to compress:
    'bundles' => [
        'portal\assets\AppAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'portal' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@portal/web',
            'baseUrl' => '@web',
            'js' => 'assets/app.min.js',
            'css' => 'assets/app.min.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'appendTimestamp' => true,
        'basePath' => '@portal/web/assets',
        'baseUrl' => '@web/assets',
    ],
];
