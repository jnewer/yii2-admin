<?php

namespace common\filters;

use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\web\Request;

class IpUser extends Model
{
    /**
     * @var string 客户端IP
     */
    private $ip;

    /**
     * @var int 允许的最大请求数
     */
    private $rateLimit;

    /**
     * @var int 时间段
     */
    private $timePeriod;

    /**
     * @param string $ip
     * @param int $timePeriod
     * @return self
     */
    public static function findByIp($ip, $rateLimit, $timePeriod)
    {
        $user = new self();
        $user->ip = $ip;
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
        return 'user.ratelimit.ip.' . $action->getUniqueId();
    }

    public function getAllowanceKey($action)
    {
        return md5($this->getKeyPrefix($action) . '.allowance.' . $this->ip);
    }

    public function getAllowanceUpdatedAtKey($action)
    {
        return md5($this->getKeyPrefix($action) . '.allowance_updated_at.' . $this->ip);
    }
}