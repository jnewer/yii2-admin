<?php

namespace common\filters;

use Yii;
use yii\filters\RateLimiter;
use yii\filters\RateLimitInterface;

/**
 * 使用示例:
 * ```php
 * public function behaviors()
 * {
 *    $behaviors = parent::behaviors();
 *    $behaviors['rateLimiter'] = [
 *        // Use class
 *        'class' => \common\filters\IpRateLimiter::class,
 *
 *        // 允许的最大请求数
 *        'rateLimit' => 100,
 *
 *        // 时间段(秒)
 *        'timePeriod' => 600,
 *
 *        // 是否分开限制未授权和已授权的用户
 *        // 默认为 true
 *        // - false: 统一限制
 *        // - true: 分开限制
 *        'separateRates' => false,
 *
 *        // 是否返回频率限制相关的http头
 *        'enableRateLimitHeaders' => false,
 *    ];
 *
 *    return $behaviors;
 * }
 * ```
 */
class IpRateLimiter extends RateLimiter
{
    /**
     * @var bool 是否分开限制未授权和已授权的用户
     */
    public $separateRates = true;

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
        $user = $this->user;

        if ($this->separateRates) {
            $user = $user ?: Yii::$app->getUser()->getIdentity(false);
        }

        if (!$user) {
            $user = IpUser::findByIp(Yii::$app->request->userIP, $this->rateLimit, $this->timePeriod);
        }

        if ($user instanceof RateLimitInterface) {
            return parent::beforeAction($action);
        }

        Yii::debug('Check rate limit', __METHOD__);
        $this->checkRateLimit($user, $this->request, $this->response, $action);

        return true;
    }
}
