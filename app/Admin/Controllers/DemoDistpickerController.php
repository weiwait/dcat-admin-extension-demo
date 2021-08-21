<?php

namespace App\Admin\Controllers;

use App\Models\DemoDistpicker;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class DemoDistpickerController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new DemoDistpicker(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('province');
            $grid->column('city');
            $grid->column('district');
            $grid->column('longitude');
            $grid->column('latitude');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
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
        return Show::make($id, new DemoDistpicker(), function (Show $show) {
            $show->field('id');
            $show->field('province');
            $show->field('city');
            $show->field('district');
            $show->field('longitude');
            $show->field('latitude');
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
        return Form::make(new DemoDistpicker(), function (Form $form) {
            $form->display('id');
            $form->distpicker(['province', 'city', 'district'], 'China area')
//                ->detail('detail')
                ->coordinate(['longitude', 'latitude']);
//            $form->text('city');
//            $form->text('district');
//            $form->text('longitude');
//            $form->text('latitude');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
