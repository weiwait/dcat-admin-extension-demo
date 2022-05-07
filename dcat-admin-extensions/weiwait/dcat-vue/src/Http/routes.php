<?php

use Weiwait\DcatVue\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-vue', Controllers\DcatVueController::class.'@index');