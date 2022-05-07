<?php

use Weiwait\DcatOrderable\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::put('dcat-orderable/ordering', [Controllers\DcatOrderableController::class, 'ordering'])
    ->name('weiwait.orderable.ordering');
