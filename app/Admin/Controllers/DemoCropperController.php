<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\DemoCropper;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class DemoCropperController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new DemoCropper(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('cropper');
            $grid->column('cropper2');
            $grid->column('image');
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
        return Show::make($id, new DemoCropper(), function (Show $show) {
            $show->field('id');
            $show->field('cropper');
            $show->field('cropper2');
            $show->field('image');
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
        return Form::make(new DemoCropper(), function (Form $form) {
            $form->display('id');
            $form->cropper('cropper')->ratio(1);
            $form->cropper('cropper2')->ratio(16 / 9);
            $form->image('image')->uniqueName();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
