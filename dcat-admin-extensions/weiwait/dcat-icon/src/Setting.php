<?php

namespace Weiwait\DcatIcon;

use Dcat\Admin\Extend\Setting as Form;
use Illuminate\Support\Facades\Storage;
use Weiwait\DcatIcon\Models\WeiwaitIcon;

class Setting extends Form
{
    public function form()
    {
        $this->text('name')->required();
        $this->textarea('icon')->required();
    }

    public function handle(array $input)
    {
        $fullName = 'icon-svg-' . $input['name'];

        WeiwaitIcon::query()->updateOrCreate(
            ['name' => $fullName],
            ['icon' => $input['icon']]
        );

        if (!Storage::disk(config('admin.upload.disk'))->exists('icons/icon-svg.css')) {
            $stub = file_get_contents(__DIR__ . '/../resources/assets/css/index.css');

            Storage::disk(config('admin.upload.disk'))
                ->put('icons/icon-svg.css', $stub);

            WeiwaitIcon::query()
                ->where('type', WeiwaitIcon::SVG)
                ->each(function (WeiwaitIcon $icon) {
                    $this->appendSvg($icon->name, $icon->icon);
                });
        } else {
            $this->appendSvg($fullName, $input['icon']);
        }

    }

    protected function appendSvg($fullName, $icon)
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
