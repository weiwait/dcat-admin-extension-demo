<?php

namespace Weiwait\DcatIcon\Form\Field;

use Dcat\Admin\Form\Field\Text;
use Weiwait\DcatIcon\Models\WeiwaitIcon;

class Icon extends Text
{
    protected $view = 'weiwait.dcat-icon::index';

    public function render()
    {
        $this->defaultAttribute('autocomplete', 'off')
            ->defaultAttribute('style', 'width: 160px;flex:none');

        $this->addVariables(['icons' => WeiwaitIcon::all()]);

        return parent::render();
    }
}
