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
	}

	public function settingForm(): Setting
    {
		return new Setting($this);
	}
}
