<?php

use Weiwait\DcatAuth\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('auth/login', [Controllers\DcatAuthController::class, 'getLogin']);
Route::post('auth/login', [Controllers\DcatAuthController::class, 'postLogin']);
