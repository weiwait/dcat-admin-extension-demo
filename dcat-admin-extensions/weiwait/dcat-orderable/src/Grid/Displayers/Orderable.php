<?php

namespace Weiwait\DcatOrderable\Grid\Displayers;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;

class Orderable extends AbstractDisplayer
{
    protected static $js = [
        '@grid-extension',
    ];

    public function display()
    {
        Admin::script($this->script());

        return <<<EOT

<div class="">
    <div class="btn-group">
        <button title="上升" data-id="{$this->row->id}" data-action="ascend" class="btn btn-sm btn-info weiwait-orderable">
            <i class="fa fa-caret-up fa-fw"></i>
        </button>
        <button title="下降" data-id="{$this->row->id}" data-action="descend" class="btn btn-sm btn-default weiwait-orderable">
            <i class="fa fa-caret-down fa-fw"></i>
        </button>
    </div>
</div>
EOT;
    }

    protected function script()
    {
        $url = route('dcat.admin.weiwait.orderable.ordering');
        $model = get_class($this->grid->model()->repository()->model());
        $model = str_replace('\\', '\\\\', $model);

        return <<<JS

$('.weiwait-orderable').click(e => {
    const id = $(e.currentTarget).data('id');
    const action = $(e.currentTarget).data('action');

    $.ajax({
        url: `$url`,
        method: 'PUT',
        data: {
            id,
            action,
            model: `$model`,
            order: 0
        },
        success: d => {
            toastr.success(d)
            Dcat.reload()
        }
    })
})
JS;
    }
}
