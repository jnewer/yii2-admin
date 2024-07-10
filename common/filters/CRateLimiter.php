<?php

namespace common\filters;

use yii\filters\RateLimiter;

/**
 * 使用示例:
 * ```php
 * public function behaviors()
 * {
 *    $behaviors = parent::behaviors();
 *    $behaviors['rateLimiter'] = [
 *        'class' => \common\filters\CRateLimiter::class,
 *
 *        //限制的key, user为null时必传
 *        'limitKey' => '127.0.0.1',
 *
 *         //限制的key字段, user为null时必传
 *        'limitKeyField' => 'ip',
 *
 *        // 允许的最大请求数, user为null时必传
 *        'rateLimit' => 100,
 *
 *        // 时间段(秒), user为null时必传
 *        'timePeriod' => 600,
 *
 *        // 是否返回频率限制相关的http头
 *        'enableRateLimitHeaders' => false,
 *
 *        // 自定义用户类
 *        user' => function() {
 *            return CRateLimiterUser::findByKey('127.0.0.1', 100, 600, 'ip')
 *        }
 *    ];
 *
 *    return $behaviors;
 * }
 * ```
 */
class CRateLimiter extends RateLimiter
{
    /**
     * @var string 限制的key
     */
    public $limitKey;

    /**
     * @var string 限制的key字段
     */
    public $limitKeyField;

    /**
     * @var int 允许的最大请求数
     */
    public $rateLimit;

    /**
     * @var int 时间段
     */
    public $timePeriod;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->user === null) {
            $this->user = CRateLimiterUser::findByKey($this->limitKey, $this->rateLimit, $this->timePeriod, $this->limitKeyField);
        }

        return parent::beforeAction($action);
    }
}
