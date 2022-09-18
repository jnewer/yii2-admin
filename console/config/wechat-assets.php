<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', __DIR__ . '/../../wechat/web');
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar ./bin/closure-compiler-v20180402.jar --language_out=ECMASCRIPT3 --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar ./bin/yuicompressor-2.4.8.jar --type css {from} -o {to}',
    // The list of asset bundles to compress:
    'bundles' => [
        'wechat\assets\AppAsset',
        'yii\widgets\ActiveFormAsset',
        // 'yii\web\YiiAsset',
        // 'yii\web\JqueryAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'wechat' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@wechat/web',
            'baseUrl' => '@web',
            'js' => 'assets/app.min.js',
            'css' => 'assets/app.min.css',
            'depends'=>[],
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'appendTimestamp' => true,
        'basePath' => '@wechat/web/assets',
        'baseUrl' => '@web/assets',
    ],
];