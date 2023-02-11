<?php

namespace App\Admin\Controllers;

use App\Models\OrderableFirst;
use App\Models\OrderableSecond;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderableSecondController extends AdminController
{
    protected $title = '排序-筛选后排序';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OrderableSecond(), function (Grid $grid) {
            $grid->model()->orderByDesc('order');

            $grid->column('id')->sortable();
            $grid->column('orderable_first_id', '排序限制');
            $grid->column('name');
            $grid->column('order')->when(request('orderable_first_id'), function ($obj) {
                return $obj->sequencable();
            })->hide();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('orderable_first_id', 'first')
                    ->select(OrderableFirst::all()->pluck('name', 'id'));

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
        return Show::make($id, new OrderableSecond(), function (Show $show) {
            $show->field('id');
            $show->field('orderable_first_id');
            $show->field('name');
            //$show->field('order');
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
        return Form::make(new OrderableSecond(), function (Form $form) {
            $form->display('id');
            $form->select('orderable_first_id')
                ->options(OrderableFirst::all()->pluck('name', 'id'));
            $form->text('name');
            //$form->text('order');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
