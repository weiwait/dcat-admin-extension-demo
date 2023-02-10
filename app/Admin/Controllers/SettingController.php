<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Tab;
use Weiwait\DcatEasySms\Forms\SmsConfig;
use Weiwait\DcatSmtp\Forms\SmtpConfig;
use Weiwait\DcatVue\Forms\AuthSetting;
use Weiwait\DcatVue\Forms\FilesystemConfig;
use Weiwait\Wechat\Forms\WechatAppletConfig;

class SettingController extends Controller
{
    public function index(Content $content): Content
    {
        $tab = Tab::make();
        $tab->add('SMTP', new SmtpConfig());
        $tab->add('短信', new SmsConfig());
        $tab->add('微信小程序', new WechatAppletConfig());
        $tab->add('文件存储', new FilesystemConfig());
        $tab->add('站点配置', new AuthSetting());

        return $content->title('配置')
            ->body($tab->withCard());
    }
}
