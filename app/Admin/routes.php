<?php

namespace App\Admin\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

});

Route::prefix(config('admin.route.prefix'))
    ->middleware(config('admin.route.middleware'))
    ->group(function () {
        Route::resource('demo-croppers', DemoCropperController::class);
        Route::resource('demo-distpickers', DemoDistpickerController::class);
    });
