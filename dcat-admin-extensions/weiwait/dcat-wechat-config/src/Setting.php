<?php

namespace Weiwait\Wechat;

use Dcat\Admin\Extend\Setting as Form;
use Dcat\Admin\Models\Menu;
use Weiwait\Wechat\Models\WechatConfig;

class Setting extends Form
{
    public function form()
    {
        $this->switch('independent', '独立菜单')
            ->default(WechatConfig::get(WechatConfig::INDEPENDENT, false));
        $this->text('menu_name', '菜单名称')->default(__('微信小程序'));
    }

    public function handle(array $input): \Dcat\Admin\Http\JsonResponse
    {
        WechatConfig::set(['independent' => (boolean)$input['independent']]);

        /** @var Menu $menu */
        $menu = config('admin.database.menu_model');

        if ($input['independent']) {
            $res = $menu::query()->updateOrCreate(
                ['uri' => 'dcat-wechat-config'],
                [
                    'title' => $input['menu_name'],
                    'show' => 1,
                    'icon' => 'fa-wechat',
                ]
            );

            WechatConfig::set(['independent_menu_id' => $res->getKey()]);

            return $this->response()->success('菜单已生成')->refresh();
        } else {
            if ($menu = $menu::query()->find(WechatConfig::get('independent_menu_id'))) {
                $menu->delete();
            }

            return $this->response()->success('菜单已删除')->refresh();
        }
    }
}
