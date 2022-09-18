<?php
return [
    'cronJobs' => [
        'tmp/send' => [
            'cron' => '* * * * *',
        ],
        'tmp/get' => [
            'cron' => '* * * * *',
        ],
        // 'customer/send' => [
        //     'cron'      => '* * * * *',
        // ],
        'emails/iressa' => [
            'cron' => '30 * * * *',
        ],
        'test/send' => [
            'cron' => '* * * * *',
        ],
    ],
];
