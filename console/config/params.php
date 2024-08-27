<?php
return [
    'cronJobs' => [
        'log/truncate' => [
            'cron' => '0 0 1 3,6,9,12 *',
            'desc' => '清理系统日志',
            'frequency' => '在3、6、9和12月的每月1日的00:00执行'
        ],
        'log/drop-operation-log' => [
            'cron' => '0 1 1 1 *',
            'desc' => '清理操作日志',
            'frequency' => '在1月1日的01:00执行'
        ],
        'log/drop-login-log' => [
            'cron' => '0 2 1 1 *',
            'desc' => '清理登录日志',
            'frequency' => '在1月1日的02:00执行'
        ],
    ],
];
