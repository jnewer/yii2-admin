<?php

namespace common\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Application;

class RequestIdBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'setRequestId',
        ];
    }

    public function setRequestId($event)
    {
        try {
            $requestId = str_replace('.', '', uniqid('req_', true));
            Yii::$app->request->headers->set('X-Request-Id', $requestId);
        } catch (\Exception $e) {
            Yii::error("设置请求ID时发生错误: " . $e->getMessage(), __METHOD__);
        }
    }
}
