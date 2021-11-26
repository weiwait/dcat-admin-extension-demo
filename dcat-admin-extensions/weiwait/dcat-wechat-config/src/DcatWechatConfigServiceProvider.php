<?php

namespace Weiwait\Wechat;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Weiwait\Wechat\Models\WechatConfig;

class DcatWechatConfigServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];

	public function register()
	{
	    //
	}

	public function init()
	{
		parent::init();
//        if (config()->has('wechat.mini_program.default')) {
//            config()->set(
//                'wechat.mini_program.default.app_id',
//                WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID)
//            );
//            config()->set(
//                'wechat.mini_program.default.secret',
//                WechatConfig::get(WechatConfig::MINI_PROGRAM_SECRET)
//            );
//        }
//
//        if (config()->has('wechat.payment.default')) {
//            config()->set(
//                'wechat.payment.default.app_id',
//                WechatConfig::get(WechatConfig::MINI_PROGRAM_APP_ID)
//            );
//            config()->set(
//                'wechat.payment.default.mch_id',
//                WechatConfig::get(WechatConfig::WECHAT_PAYMENT_MCH_ID)
//            );
//            config()->set(
//                'wechat.payment.default.key',
//                WechatConfig::get(WechatConfig::WECHAT_PAYMENT_KEY)
//            );
//            config()->set(
//                'wechat.payment.default.cert_path',
//                storage_path('app/wechat-config/api_client_cert.pem')
//            );
//            config()->set(
//                'wechat.payment.default.key_path',
//                storage_path('app/wechat-config/api_client_key.pem')
//            );
//        }
	}

	public function settingForm(): Setting
    {
		return new Setting($this);
	}
}
