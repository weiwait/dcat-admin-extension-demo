<?php

namespace Weiwait\DcatSmtp\Forms;

use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Widgets\Form;

class SmtpConfig extends Form
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
        return \Weiwait\DcatSmtp\Models\SmtpConfig::adminFormHandle($this, $input);
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('smtp_host', 'SMTP地址')->required();
        $this->text('smtp_port', 'SMTP端口')->required();
        $this->text('mail_username', '用户')->required();
        $this->text('mail_password', '密码')->required();
        $this->text('mail_encryption', '加密方式')->required();
        $this->text('mail_from_address', '发送人邮箱')->required();
        $this->text('mail_from_name', '发送人')->required();
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default(): array
    {
        return \Weiwait\DcatSmtp\Models\SmtpConfig::get([
            \Weiwait\DcatSmtp\Models\SmtpConfig::SMTP_HOST,
            \Weiwait\DcatSmtp\Models\SmtpConfig::SMTP_PORT,
            \Weiwait\DcatSmtp\Models\SmtpConfig::MAIL_USERNAME,
            \Weiwait\DcatSmtp\Models\SmtpConfig::MAIL_PASSWORD,
            \Weiwait\DcatSmtp\Models\SmtpConfig::MAIL_ENCRYPTION,
            \Weiwait\DcatSmtp\Models\SmtpConfig::MAIL_FROM_ADDRESS,
            \Weiwait\DcatSmtp\Models\SmtpConfig::MAIL_FROM_NAME,
        ]);
    }
}
