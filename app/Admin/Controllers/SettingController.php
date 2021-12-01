<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use App\Mail\TestSmtpConfig;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Facades\Mail;
use Weiwait\DcatEasySms\Forms\SmsConfig;
use Weiwait\DcatSmtp\Forms\SmtpConfig;
use Weiwait\Filesystem\Forms\FilesystemConfig;
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

        return $content->title('配置')
            ->body($tab->withCard());
    }
}
