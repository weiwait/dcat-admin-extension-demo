<?php

namespace App\Admin\Controllers;

use App\Models\OrderableFirst;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderableFirstController extends AdminController
{
    protected $title = '排序-降序';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OrderableFirst(), function (Grid $grid) {
            $grid->model()->orderByDesc('order');

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('order')->sequencable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->enableDialogCreate();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new OrderableFirst(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('order');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new OrderableFirst(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            //$form->text('order');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
