<?php

namespace Weiwait\Filesystem\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Illuminate\Routing\Controller;
use Weiwait\Filesystem\Forms\FilesystemConfig;

class DcatFilesystemConfigController extends Controller
{
    public function index(Content $content): Content
    {
        return $content
            ->body(new FilesystemConfig());
    }
}
