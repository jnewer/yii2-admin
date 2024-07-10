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
        
        if (!is_options() && !in_array($clientIp, $this->allowedIps) && !in_array($action->id, $this->allowedActions) && in_array('*', $this->allowedActions)) {
            $fullUrl = request()->getAbsoluteUrl();
            $headers = json_encode(request()->getHeaders()->toArray(), JSON_UNESCAPED_UNICODE);
            $body = json_encode(request()->getBodyParams(), JSON_UNESCAPED_UNICODE);
            $serverIp = $_SERVER['SERVER_ADDR'] ?? '';

            Yii::info("ip校验异常,clientIp={$clientIp},serverIp={$serverIp},url={$fullUrl},headers={$headers},body={$body}");
            
            throw new ForbiddenHttpException('You are not allowed to access this action.');
        }

        return parent::beforeAction($action);
    }
}
