<?php

namespace Weiwait\DcatSmtp;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Weiwait\DcatSmtp\Models\SmtpConfig;

class DcatSmtpServiceProvider extends ServiceProvider
{
	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		if ('smtp' === config('mail.default')) {
		    config()->set('mail.mailers.smtp.host', SmtpConfig::get(SmtpConfig::SMTP_HOST));
		    config()->set('mail.mailers.smtp.port', SmtpConfig::get(SmtpConfig::SMTP_PORT));
		    config()->set('mail.mailers.smtp.username', SmtpConfig::get(SmtpConfig::MAIL_USERNAME));
		    config()->set('mail.mailers.smtp.password', SmtpConfig::get(SmtpConfig::MAIL_PASSWORD));
		    config()->set('mail.mailers.smtp.encryption', SmtpConfig::get(SmtpConfig::MAIL_ENCRYPTION));
		    config()->set('mail.from.address', SmtpConfig::get(SmtpConfig::MAIL_FROM_ADDRESS));
		    config()->set('mail.from.name', SmtpConfig::get(SmtpConfig::MAIL_FROM_NAME));
        }

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
