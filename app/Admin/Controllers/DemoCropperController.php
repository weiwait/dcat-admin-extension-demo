<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\DemoCropper;
use App\Models\DemoDistpicker;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DemoCropperController extends AdminController
{
    protected $title = '表单组件';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new DemoCropper(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('cropper', '图片')->image(height: 60);
            $grid->column('cropper2', '图片')->image(height: 60);
            $grid->column('image', '图片')->image(height: 60);
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
                ->jpeg()
                ->ratio(16 / 9)
                ->resolution(1920, 1080)
                ->help('提示信息');
//            $form->cropper('cropper2')->ratio(16 / 9)->help('支持多次调用');
            $form->image('image', '原生图片');
//            $form->multipleCropper('images')->ratio(['1:1' => 1, '16:9' => 16/9])->jpeg()->limit(12);

//            $form->vMultipleImage('images')->options(['hello', 'world']);
            $form->vDateRange('start', 'end', '日期范围');

//            $form->table('tables', function (Form\NestedForm $form) {
//                $form->vImage('image');
//                $form->vFile('file');
//                $form->vTags('tags');
//                $form->vMultipleImage('multiple_images');
//                $form->vMultipleFile('multiple_files');
//                $form->vKeyValue('images')->sortable();
//            });

            $form->vList('list', '列表')
                ->watch('tags', <<<JS
                    (target, form, store) => {
                        store.request({
                            method: 'GET',
                            url: '/admin'
                        }).then(res => console.log(res))
                    }
                JS);
            $form->vTags('tags', '标签');
            $form->vKeyValue('images', '选项')->serial()->sortable();

            $form->vSelect('select', '答案')
                ->options(['123', '456'])
                ->concatKey()
//                ->optionsFromKeyValue('images');
                ->modelLoad(DemoDistpicker::class, 'id', 'province', ['number' => 'id'], 20);

            $form->vMultipleSelect('ms', '答案')
                ->options(['123', '456'])
                ->concatKey()
                ->optionsFromKeyValue('images');

            $form->vNumber('number', '整数')
                ->bothButton()
                ->max(88);

            $form->vNumber('float', '浮点')
                ->precision(2);

            $form->vCheckbox('box', '多选盒')
                ->options(['first', 'second', 'third'])
                ->watch('number', <<<JS
                    (target, form, store) => {
                        console.log(target, form, store)
                    }
                JS);

            $form->vIcon('vic', '图标')
                ->withColor('color_field')
                ->default(['vic' => 'fa-angellist', 'color_field' => '#00DD77FF']);

            $form->vSku('skus');

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
            });
        });
    }
}
