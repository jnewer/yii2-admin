<?php

namespace common\components;

use yii\helpers\Json;

class Formatter extends \yii\i18n\Formatter
{
    public function asJson($value)
    {
        return "<pre>" . Json::encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>";
    }
}
