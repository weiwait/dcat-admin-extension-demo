<?php

namespace Weiwait\DcatAuth;

use Dcat\Admin\Extend\Setting as Form;
use Dcat\Admin\Form\NestedForm;

class Setting extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        admin_setting([
            'weiwait_auth.enable_captcha' => $input['enable_captcha'],
            'weiwait_auth.background' => $input['background'],
            'weiwait_auth.footer' => $input['footer'],
        ]);

        return $this
            ->response()
            ->success('保存成功')
            ->refresh();
    }

    public function form()
    {
        $this->switch('enable_captcha', DcatAuthServiceProvider::trans('auth.enable_captcha'))
            ->default(true);
        $this->image('background', DcatAuthServiceProvider::trans('auth.background'))
            ->uniqueName()
            ->autoUpload();
        $this->array('footer', DcatAuthServiceProvider::trans('auth.footer'), function (NestedForm $form) {
            $form->text('name', DcatAuthServiceProvider::trans('auth.footers.name'));
            $form->text('path', DcatAuthServiceProvider::trans('auth.footers.path'));
        });
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return admin_setting()->getArray('weiwait_auth');
    }
}
