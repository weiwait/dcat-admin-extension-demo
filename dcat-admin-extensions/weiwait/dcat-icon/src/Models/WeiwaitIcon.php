<?php

namespace Weiwait\DcatIcon\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Support\Facades\Storage;

class WeiwaitIcon extends \Illuminate\Database\Eloquent\Model
{
    use HasDateTimeFormatter;

    const SVG = 0;

    const TYPE = [
        'svg', 'icon-font'
    ];

    protected $guarded = [];

    public static function generatingIcons()
    {
        $stub = file_get_contents(__DIR__ . '/../../resources/assets/css/index.css');

        Storage::disk(config('admin.upload.disk'))
            ->delete('icons/icon-svg.css');

        Storage::disk(config('admin.upload.disk'))
            ->put('icons/icon-svg.css', $stub);

        WeiwaitIcon::query()
            ->where('type', WeiwaitIcon::SVG)
            ->each(function (WeiwaitIcon $icon) {
                WeiwaitIcon::appendSvg($icon->name, $icon->icon);
            });
    }

    public static function appendSvg($fullName, $icon)
    {
        $filename = 'icons/' . $fullName . '.svg';

        Storage::disk(config('admin.upload.disk'))
            ->put($filename, $icon);

        $url = Storage::disk(config('admin.upload.disk'))->url($filename);
        $background = <<<CSS
.$fullName::before{background-image: url("$url");}
CSS;

        Storage::disk(config('admin.upload.disk'))
            ->append('icons/icon-svg.css', $background);
    }
}
