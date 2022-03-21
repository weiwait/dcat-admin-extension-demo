<?php

namespace Weiwait\DcatIcon;

use Dcat\Admin\Extend\Setting as Form;
use Illuminate\Support\Facades\Storage;
use Weiwait\DcatIcon\Models\WeiwaitIcon;

class Setting extends Form
{
    public function form()
    {
        $this->text('name')->placeholder('svg-twrap')->required();
        $this->textarea('icon')
            ->placeholder('<svg class="icon" style="width: 1em;height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="479"><path d="M731.0848 143.7696c-125.0816-54.528-270.7456 2.6624-325.2736 127.7952l-3.7376 8.6016-8.6016-3.7376c-125.0816-54.5792-270.6944 2.6112-325.2224 127.744-54.528 125.0816 2.6624 270.7456 127.7952 325.2736l368.0256 160.4096c51.712 22.528 111.872-1.1264 134.4-52.7872l0.0512-0.1024c0-0.0512 0.0512-0.1024 0.0512-0.1536l160.3072-367.7696c54.528-125.1328-2.6624-270.7456-127.7952-325.2736z" fill="#F85F69" p-id="480"></path><path d="M586.9568 433.8688c72.2432-31.488 156.3136 1.536 187.8016 73.7792l2.1504 4.9664 4.9664-2.1504c72.2432-31.488 156.3136 1.536 187.8016 73.7792 31.488 72.2432-1.536 156.3136-73.7792 187.8016l-212.48 92.6208c-29.8496 13.0048-64.5632-0.6144-77.568-30.464v-0.0512c0-0.0512-0.0512-0.0512-0.0512-0.1024l-92.5696-212.3264c-31.488-72.2944 1.536-156.3648 73.728-187.8528z" fill="#F85F69" p-id="481"></path><path d="M781.8752 510.4128l-4.9664 2.1504-2.1504-4.9664c-31.488-72.2432-115.5584-105.2672-187.8016-73.7792s-105.2672 115.5584-73.7792 187.8016l92.5696 212.3264c0 0.0512 0.0512 0.0512 0.0512 0.1024v0.0512c12.3904 28.3648 44.3904 42.0864 73.1648 32.1536a101.4784 101.4784 0 0 0 19.4048-29.2352l0.0512-0.1024c0-0.0512 0.0512-0.1024 0.0512-0.1536l147.4048-338.0736c-21.248-1.024-43.1104 2.6624-64 11.7248z" fill="#F33B3D" p-id="482"></path></svg>')
            ->required();
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
