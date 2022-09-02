<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\DemoCropper;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

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
            $grid->column('cropper')->image();
            $grid->column('cropper2')->image();
            $grid->column('image')->image();
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
            $form->file('cropper2')->mimeTypes('video/*');
            $form->image('cropper')
                ->large()
                ->jpeg(1)
                ->ratio(16 / 9)
                ->resolution(1920, 1080);
//            $form->cropper('cropper2')->ratio(16 / 9)->help('支持多次调用');
            $form->image('image');
//            $form->multipleCropper('images')->ratio(['1:1' => 1, '16:9' => 16/9])->jpeg()->limit(12);

            $form->multipleImage('images')->options(['hello', 'world'])->required();
            $form->dateRange('start', 'end', 'Date Range')->disableDates([
                ['', '2022/01/01'], ['2022/02/1', '2022/02/16'], ['2022/08/01']
            ])->required();
            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
            });
        });
    }
}
