<?php

namespace common\filters;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\filters\RateLimitInterface;

class CRateLimiterUser implements RateLimitInterface
{
    /**
     * @var string 限制的key
     */
    public $limitKey;

    /**
     * @var string 限制的key字段
     */
    public $limitKeyField = 'ip';

    /**
     * @var int 允许的最大请求数
     */
    public $rateLimit;

    /**
     * @var int 时间段
     */
    public $timePeriod;

    /**
     * @param string $limitKey
     * @param int $rateLimit
     * @param int $timePeriod
     * @param string $limitKeyField
     * @return self
     */
    public static function findByKey($limitKey, $rateLimit, $timePeriod, $limitKeyField = 'ip')
    {
        $user = new self();
        $user->limitKeyField = $limitKeyField;
        $user->limitKey = $limitKey;
        $user->rateLimit = $rateLimit;
        $user->timePeriod = $timePeriod;

        return $user;
    }


    /**
     * Returns the maximum number of allowed requests and the window size.
     * @param Request $request the current request
     * @param Action $action the action to be executed
     * @return array an array of two elements. The first element is the maximum number of allowed requests,
     * and the second element is the size of the window in seconds.
     */
    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, $this->timePeriod];
    }

    /**
     * Loads the number of allowed requests and the corresponding timestamp from a persistent storage.
     * @param Request $request the current request
     * @param Action $action the action to be executed
     * @return array an array of two elements. The first element is the number of allowed requests,
     * and the second element is the corresponding UNIX timestamp.
     */
    public function loadAllowance($request, $action)
    {
        $cache = Yii::$app->cache;
        return [
            $cache->get($this->getAllowanceKey($action)),
            $cache->get($this->getAllowanceUpdatedAtKey($action)),
        ];
    }

    /**
     * Saves the number of allowed requests and the corresponding timestamp to a persistent storage.
     * @param Request $request the current request
     * @param Action $action the action to be executed
     * @param integer $allowance the number of allowed requests remaining.
     * @param integer $timestamp the current timestamp.
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $cache = Yii::$app->cache;
        $cache->set($this->getAllowanceKey($action), $allowance);
        $cache->set($this->getAllowanceUpdatedAtKey($action), $timestamp);
    }

    public function getKeyPrefix($action)
    {
        return 'user.ratelimit.' . $this->limitKeyField . '.' . $action->getUniqueId();
    }

    public function getAllowanceKey($action)
    {
        return md5($this->getKeyPrefix($action) . '.allowance.' . $this->limitKey);
    }

    public function getAllowanceUpdatedAtKey($action)
    {
        return md5($this->getKeyPrefix($action) . '.allowance_updated_at.' . $this->limitKey);
    }
}
