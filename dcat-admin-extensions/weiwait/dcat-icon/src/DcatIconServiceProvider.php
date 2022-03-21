<?php

namespace Weiwait\DcatIcon;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Weiwait\DcatIcon\Form\Field\Icon;

class DcatIconServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/weiwait.icon.js',
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

		Admin::css(\Storage::disk(config('admin.upload.disk'))->url('icons/icon-svg.css'));

		Form::extend('icon', Icon::class);
		Form::extend('oIcon', Form\Field\Icon::class);

		Admin::requireAssets('@weiwait.dcat-icon');

        $this->publishable();
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
