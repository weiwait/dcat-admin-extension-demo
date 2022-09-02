<?php

namespace Weiwait\Wechat;

use Weiwait\Wechat\Models\WechatConfig;

class Application
{
    public static function applet(): \EasyWeChat\MiniApp\Application
    {
        return new \EasyWeChat\MiniApp\Application([
            'app_id' => WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID),
            'secret' => WechatConfig::get(WechatConfig::MINI_PROGRAM_SECRET),
        ]);
    }

    public static function pay(): \EasyWeChat\Pay\Application
    {
        return new \EasyWeChat\Pay\Application([
            'app_id' => WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID),
            'mch_id' => WechatConfig::get(WechatConfig::WECHAT_PAYMENT_MCH_ID),
            'v2_secret_key' => WechatConfig::get(WechatConfig::WECHAT_PAYMENT_KEY), // v2
            'secret_key' => WechatConfig::get(WechatConfig::WECHAT_PAYMENT_KEY_V3), // v3
            'private_key' => storage_path('app/wechat-config/api_client_key.pem'),
            'certificate' => storage_path('app/wechat-config/api_client_cert.pem'),
            'platform_certs' => storage_path('app/wechat-config/platform_certs.pem'),
        ]);
    }
}
