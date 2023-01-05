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
    protected $title = '裁剪';

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
            $form->vFile('cropper2', '文件')->mimeTypes('video/*');
            $form->vImage('cropper', '裁剪')
                ->jpeg(1)
                ->ratio(16 / 9)
                ->resolution(1920, 1080)
                ->accept('images/png');
//            $form->cropper('cropper2')->ratio(16 / 9)->help('支持多次调用');
            $form->image('image', '原生图片');
//            $form->multipleCropper('images')->ratio(['1:1' => 1, '16:9' => 16/9])->jpeg()->limit(12);

//            $form->vMultipleImage('images')->options(['hello', 'world']);
            $form->vDateRange('start', 'end', '日期范围')->required();

//            $form->table('tables', function (Form\NestedForm $form) {
//                $form->vImage('image');
//                $form->vFile('file');
//                $form->vTags('tags');
//                $form->vMultipleImage('multiple_images');
//                $form->vMultipleFile('multiple_files');
//                $form->vKeyValue('images')->sortable();
//            });

//            $form->vList('images');
            $form->vKeyValue('images', '选项')->serial()->sortable();

            $form->vSelect('select', '答案')
                ->options(['123', '456'])
                ->concatKey()
                ->optionsFromKeyValue('images')
                ->required();

            $form->vMultipleSelect('ms', '答案')
                ->options(['123', '456'])
                ->concatKey()
                ->optionsFromKeyValue('images')
                ->required();

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
            });
        });
    }
}
