<?php

namespace Weiwait\Wechat\Forms;

use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Widgets\Form;
use Weiwait\Wechat\Models\WechatConfig;

class WechatAppletConfig extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        return WechatConfig::adminFormHandle($this, $input);
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('mini_program_app_id', '小程序Appid')->required();
        $this->text('mini_program_secret', '小程序密钥Secret')->required();

        $this->text('wechat_payment_mch_id', '商户号MchID');
        $this->text('wechat_payment_key', '商户号密钥Key')
            ->minLength(32)
            ->maxLength(32);
        $this->textarea('wechat_payment_cert_path', '商户证书Cert');
        $this->textarea('wechat_payment_key_path', '商户证书Key');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default(): array
    {
        return WechatConfig::get([
            WechatConfig::MINI_PROGRAM_APP_ID,
            WechatConfig::MINI_PROGRAM_SECRET,
            WechatConfig::WECHAT_PAYMENT_MCH_ID,
            WechatConfig::WECHAT_PAYMENT_KEY,
            WechatConfig::WECHAT_PAYMENT_CERT_PATH,
            WechatConfig::WECHAT_PAYMENT_KEY_PATH,
        ]);
    }
}
