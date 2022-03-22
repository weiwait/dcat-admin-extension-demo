<?php

use Weiwait\Distpicker\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('distpicker/regions', Controllers\DistpickerController::class . '@index')
    ->name('distpicker.regions');
