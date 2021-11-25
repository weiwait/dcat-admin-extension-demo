<?php

namespace Weiwait\Wechat\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;
use Weiwait\Wechat\Forms\WechatAppletConfig;

class DcatWechatConfigController extends Controller
{
    public function index(Content $content): Content
    {
        return $content
            ->title(__('微信小程序'))
            ->body(new WechatAppletConfig());
    }
}
