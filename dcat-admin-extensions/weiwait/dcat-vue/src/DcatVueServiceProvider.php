<?php

namespace Weiwait\DcatVue;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Weiwait\DcatVue\Field\DateRange;
use Weiwait\DcatVue\Field\Distpicker;
use Weiwait\DcatVue\Field\File;
use Weiwait\DcatVue\Field\Image;
use Weiwait\DcatVue\Field\KeyValue;
use Weiwait\DcatVue\Field\ListField;
use Weiwait\DcatVue\Field\MultipleFile;
use Weiwait\DcatVue\Field\MultipleImage;
use Weiwait\DcatVue\Field\MultipleSelect;
use Weiwait\DcatVue\Field\Select;
use Weiwait\DcatVue\Field\Tag;
use Weiwait\DcatVue\Field\Vue;
use Weiwait\DcatVue\Models\FilesystemConfig;

class DcatVueServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/helper.js',
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

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->hackConfigs();

        $this->exceptRoutes = [
            'auth' => 'weiwait*',
            'permission' => 'weiwait*',
        ];

//		Form::extend('vue', Vue::class);
		Form::extend('vFile', File::class);
		Form::extend('vMultipleFile', MultipleFile::class);
        Form::extend('vImage', Image::class);
        Form::extend('vMultipleImage', MultipleImage::class);
        Form::extend('vTags', Tag::class);
        Form::extend('vList', ListField::class);
        Form::extend('vKeyValue', KeyValue::class);
        Form::extend('vDistpicker', Distpicker::class);
        Form::extend('vDateRange', DateRange::class);
        Form::extend('vSelect', Select::class);
        Form::extend('vMultipleSelect', MultipleSelect::class);

        Admin::requireAssets('@weiwait.dcat-vue');
	}

	public function settingForm()
	{
		return new Setting($this);
	}

    protected function hackConfigs()
    {
        if (is_file(app()->getCachedConfigPath())) {
            return;
        }

        app()->booted(function () {
            config()->set('filesystems.disks.oss', [
                'access_key' => FilesystemConfig::get('oss_access_key'),
                'secret_key' => FilesystemConfig::get('oss_secret_key'),
                'endpoint' => FilesystemConfig::get('oss_endpoint'),
                'bucket' => FilesystemConfig::get('oss_bucket'),
                'driver' => 'oss',
                'root' => '',
                'isCName' => false,
            ]);

            config()->set('filesystems.disks.qiniu', [
                'access_key' => FilesystemConfig::get('qiniu_access_key'),
                'secret_key' => FilesystemConfig::get('qiniu_secret_key'),
                'domain' => FilesystemConfig::get('qiniu_domain'),
                'bucket' => FilesystemConfig::get('qiniu_bucket'),
                'driver' => 'qiniu',
            ]);

            config()->set('filesystems.disks.cosv5', [
                'driver' => 'cosv5',
                'region'          => FilesystemConfig::get('cos_region'),
                'credentials'     => [
                    'appId'     => FilesystemConfig::get('cos_app_id'),
                    'secretId'  => FilesystemConfig::get('cos_secret_id'),
                    'secretKey' => FilesystemConfig::get('cos_secret_key'),
                    'token'     => null,
                ],
                'timeout'         => 60,
                'connect_timeout' => 60,
                'bucket'          => FilesystemConfig::get('cos_bucket'),
                'cdn'             => FilesystemConfig::get('cos_cdn'),
                'scheme'          => config('admin.https') ? 'https' : 'http',
                'read_from_cdn'   => false,
                'cdn_key'         => null,
                'encrypt'         => false,
            ]);

            config()->set('filesystems.default', FilesystemConfig::get('disk', config('filesystems.default')));

            config()->set('admin.auth.except', array_merge((array)config('admin.auth.except'), ['weiwait*']));
        });

        Event::listen('admin:booted', function () {
            config()->set('admin.upload.disk', FilesystemConfig::get('disk', config('admin.upload.disk')));
        });
    }
}
