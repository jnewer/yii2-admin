<?php

namespace common\filters;

use common\helpers\HttpHelper;
use Yii;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;

/**
 *
 * ```php
 * public function behaviors()
 * {
 *    $behaviors = parent::behaviors();
 *    if ($this->enableIpFilter) {
 *        $behaviors['ipFilter'] = [
 *            'class' => \common\filters\IpFilter::class,
 *            'allowedIps' => ['127.0.0.1'],
 *            'allowedActions' => ['*'],
 *        ];
 *    }
 *
 *    return $behaviors;
 * }
 * ```
 *
 */
class IpFilter extends ActionFilter
{
    public $allowedIps = [];

    public $allowedActions = [];

    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws InvalidConfigException
     */
    public function beforeAction($action)
    {
        $clientIp = HttpHelper::getClientIp();

        // 处理OPTIONS请求
        if (is_options()) {
            return parent::beforeAction($action);
        }

        // 检查IP和行动权限
        if (!$this->isAccessAllowed($clientIp, $action->id)) {
            $this->logAccessViolation($clientIp, $action);
            throw new ForbiddenHttpException('您没有权限访问该操作。');
        }

        return parent::beforeAction($action);
    }

    /**
     * 检查访问是否被允许
     *
     * @param string $clientIp
     * @param string $actionId
     * @return bool
     */
    protected function isAccessAllowed($clientIp, $actionId)
    {
        return in_array($clientIp, $this->allowedIps) ||
            in_array($actionId, $this->allowedActions) ||
            in_array('*', $this->allowedActions);
    }

    /**
     * 记录IP校验失败的日志
     *
     * @param string $clientIp
     * @param $action
     */
    protected function logAccessViolation($clientIp, $action)
    {
        $fullUrl = request()->getAbsoluteUrl();
        $headers = json_encode(request()->getHeaders()->toArray(), JSON_UNESCAPED_UNICODE);
        $body = json_encode(request()->getBodyParams(), JSON_UNESCAPED_UNICODE);
        $serverIp = $_SERVER['SERVER_ADDR'] ?? '';

        Yii::info("IP验证失败, clientIp={$clientIp}, serverIp={$serverIp}, url={$fullUrl}, headers={$headers}, body={$body}");
    }
}
