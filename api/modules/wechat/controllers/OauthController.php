<?php

namespace api\modules\wechat\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\Cors;
use yii\web\Response;
use yii\base\UserException;
use yii\filters\RateLimiter;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use api\modules\wechat\models\WechatUser;
use api\modules\wechat\models\WechatConfig;

class OauthController extends BaseController
{
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge([
            'corsFilter' =>
            [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [$_SERVER['HTTP_ORIGIN']],

                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Request-Headers' => ['Access-Control-Allow-Origin', 'Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                ],
            ],
        ], parent::behaviors());

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'text/html' => Response::FORMAT_JSON,
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::class,
        ];

        return $behaviors;
    }

    public function actionGetRedirectUrl()
    {

        $redirectUrl = Url::to(['oauth/login', 'redirectUrl' => $_GET['redirectUrl']], true);
        $response = $this->wechatApp->oauth->scopes(['snsapi_userinfo'])->redirect($redirectUrl);

        return $response->getTargetUrl();
    }

    public function actionLogin()
    {
        $oauth = $this->wechat->oauth;
        // 获取 OAuth 授权结果用户信息
        $userInfo = $oauth->user();
        if ($userInfo->id) {
            $wechatUser = WechatUser::findOne(['openid' => $userInfo->id, 'wechat_config_id' => $this->wechatConfig->id]);
            if ($wechatUser === null) {
                $wechatUser = new WechatUser();
                $wechatUser->subscribe_at = date('Y-m-d H:i:s');
                $wechatUser->wechat_config_id = $this->wechatConfig->id;
                $wechatUser->openid = $userInfo->id;
                $wechatUser->access_token = md5(uniqid() . $this->wechatConfig->appid);
                $wechatUser->save(false);
            }

            $originalInfo = $userInfo->getOriginal();
            if ($originalInfo) {
                $wechatUser->setAttributes($originalInfo, false);
                $wechatUser->save(false);
            }

            Yii::$app->user->login($wechatUser, 86400);

            return $this->redirect($_GET['redirectUrl'] ? $_GET['redirectUrl'] : "/index.html");
        }

        echo '获取您的用户信息失败，请重新进入以重试。';
        Yii::$app->end();
    }


    public function actionGetCurrentUser()
    {
        if (Yii::$app->request->isGet) {
            if (!Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;
                $wechatConfig = WechatConfig::find()->where(['module_id' => $this->module->id])->one();
                if ($wechatConfig !== null && $user->wechat_config_id != $wechatConfig->id) {
                    throw new UserException('获取当前用户信息失败，请重试。');
                }

                $data = $user->toArray();
                if (empty($data['username']) || empty($data['headimgurl'])) {
                    $user = WechatUser::findOne(['openid' => $data['openid'], 'config_id' => $wechatConfig->id]);
                    if ($user !== null) {
                        $data['username'] = $data['username'] ?: $user->username;
                        $data['headimgurl'] = $data['headimgurl'] ?: $user->headimgurl;
                    }
                }
                $data['access_token'] = $user->access_token;
                return $data;
            } else {
                throw new UserException('获取当前用户信息失败。');
            }
        }
    }

    public function actionJsSdkConfig($url)
    {
        $app = $this->wechat;
        $app->jssdk->setUrl($url);
        return $app->jssdk->buildConfig([
            "checkJsApi",
            "onMenuShareTimeline",
            "onMenuShareAppMessage",
            "onMenuShareQQ",
            "onMenuShareWeibo",
            "hideMenuItems",
            "showMenuItems",
            "hideAllNonBaseMenuItem",
            "showAllNonBaseMenuItem",
            "translateVoice",
            "startRecord",
            "stopRecord",
            "onVoiceRecordEnd",
            "playVoice",
            "pauseVoice",
            "stopVoice",
            "uploadVoice",
            "downloadVoice",
            "chooseImage",
            "previewImage",
            "uploadImage",
            "downloadImage",
            "getLocalImgData",
            "getNetworkType",
            "openLocation",
            "getLocation",
            "hideOptionMenu",
            "showOptionMenu",
            "closeWindow",
            "scanQRCode",
            "chooseWXPay",
            "openProductSpecificView",
            "addCard",
            "chooseCard",
            "openCard",
        ], !!$this->wechatConfig->enable_debug, false, false);
    }
}
