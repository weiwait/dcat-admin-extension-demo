<?php

namespace Weiwait\Wechat;

use EasyWeChat\Factory;
use Weiwait\Wechat\Models\WechatConfig;

class Application
{
    public static function applet(): \EasyWeChat\MiniProgram\Application
    {
        return Factory::miniProgram([
            'app_id' => WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID),
            'secret' => WechatConfig::get(WechatConfig::MINI_PROGRAM_SECRET),
        ]);
    }

    public static function pay(): \EasyWeChat\Payment\Application
    {
        return Factory::payment([
            'app_id' => WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID),
            'mch_id' => WechatConfig::get(WechatConfig::WECHAT_PAYMENT_MCH_ID),
            'key' => WechatConfig::get(WechatConfig::WECHAT_PAYMENT_KEY),
            'key_path' => storage_path('app/wechat-config/api_client_key.pem'),
            'cert_path' => storage_path('app/wechat-config/api_client_cert.pem'),
        ]);
    }
}
