<?php

namespace Weiwait\DcatOrderable\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DcatOrderableController extends Controller
{
    public function ordering(Request $request)
    {
        $model = $request['model']::query()->findOrFail($request['id']);

        try {
            switch ($request['action']) {
                case 'to':
                    $model->moveOrderTo($request['order']);
                    break;
                case 'ascend':
                    $model->moveOrderAscend($request['order']);
                    break;
                case 'descend':
                    $model->moveOrderDescend($request['order']);
                    break;
                default:
                    throw new NotFoundHttpException('该操作不存在');
            }
        } catch (\Exception $exception) {
            return response($exception, 500);
        }

        return response('排序成功', 200);
    }
}
