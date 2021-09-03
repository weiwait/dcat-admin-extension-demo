<?php

namespace Weiwait\DcatSmtp;

use Dcat\Admin\Extend\Setting as Form;
use Dcat\Admin\Models\Menu;
use Weiwait\DcatSmtp\Models\SmtpConfig;

class Setting extends Form
{
    public function form()
    {
        $this->switch('independent', '独立菜单')
            ->default(SmtpConfig::get(SmtpConfig::INDEPENDENT, false));
        $this->text('menu_name', '菜单名称')->default(__('Smtp Config'));
    }

    public function handle(array $input): \Dcat\Admin\Http\JsonResponse
    {
        SmtpConfig::set(['independent' => (boolean)$input['independent']]);

        /** @var Menu $menu */
        $menu = config('admin.database.menu_model');

        if ($input['independent']) {
            $res = $menu::query()->updateOrCreate(
                ['uri' => 'dcat-smtp'],
                [
                    'title' => $input['menu_name'],
                    'show' => 1,
                    'icon' => 'fa-envelope',
                ]
            );

            SmtpConfig::set(['independent_menu_id' => $res->getKey()]);

            return $this->response()->success('菜单已生成')->refresh();
        } else {
            if ($menu = $menu::query()->find(SmtpConfig::get('independent_menu_id'))) {
                $menu->delete();
            }

            return $this->response()->success('菜单已删除')->refresh();
        }
    }
}
