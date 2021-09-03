<?php

namespace Weiwait\DcatSmtp\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;
use Weiwait\DcatSmtp\Forms\SmtpConfig;

class DcatSmtpController extends Controller
{
    public function index(Content $content): Content
    {
        return $content
            ->title(__('smtp'))
            ->body(new SmtpConfig());
    }
}
