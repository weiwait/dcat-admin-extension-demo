<?php

namespace Weiwait\Distpicker\Http\Controllers;

use Illuminate\Routing\Controller;
use Weiwait\Distpicker\Models\ChinaArea;

class DistpickerController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {

        $provinces = ChinaArea::provinces()->map(fn(ChinaArea $item) => array_values($item->toArray()));
        $cities = ChinaArea::cities()->map(fn(ChinaArea $item) => array_values($item->toArray()));
        $districts = ChinaArea::districts()->map(fn(ChinaArea $item) => array_values($item->toArray()));

        return response()->json(compact( 'provinces', 'cities', 'districts'));
    }
}
