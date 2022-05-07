<?php

namespace Weiwait\DcatVue;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Weiwait\DcatVue\Form\Vue;

class DcatVueServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		//'css/index.css',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		Form::extend('vue', Vue::class);

        $this->publishable();
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
