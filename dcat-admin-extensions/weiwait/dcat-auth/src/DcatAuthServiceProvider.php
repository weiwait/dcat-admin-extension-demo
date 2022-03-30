<?php

namespace Weiwait\DcatAuth;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class DcatAuthServiceProvider extends ServiceProvider
{
	protected $js = [
    ];
	protected $css = [
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

        config()->set('captcha.default.length', 4);
        config()->set('captcha.default.height', 34);
        config()->set('captcha.default.width', 100);
        config()->set('captcha.default.quality', 100);
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
