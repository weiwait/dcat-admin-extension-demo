<?php

namespace Weiwait\DcatOrderable;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Column;
use Weiwait\DcatOrderable\Grid\Displayers\Orderable;

class DcatOrderableServiceProvider extends ServiceProvider
{
	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		Column::extend('sequencable', Orderable::class);

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
