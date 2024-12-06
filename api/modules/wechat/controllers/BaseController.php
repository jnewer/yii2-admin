<?php

namespace api\modules\wechat\controllers;

use Yii;
use yii\web\Controller;
use yii\base\UserException;
use api\modules\wechat\models\WechatConfig;

class BaseController extends Controller
{
    /**
     * @var WechatConfig
     */
    public $wechatConfig;

    /**
     * @var Application
     */
    public $wechatApp;

    public function init()
    {
        parent::init();

        if (!isset($_GET['wechat_config_id']) || empty($_GET['wechat_config_id'])) {
            $wechatConfig = WechatConfig::find()->where(['module_id' => $this->module->id])->one();
        } else {
            $wechatConfig = WechatConfig::findOne($_GET['wechat_config_id']);
        }

        if (is_null($wechatConfig)) {
            throw new UserException('找不到对应的微信配置');
        }

        $this->wechatConfig = $wechatConfig;
        $this->wechatApp = $this->config->getWechatApp();
    }
}
