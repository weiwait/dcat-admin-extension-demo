<?php

use Weiwait\DcatFormSelect\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-form-select', Controllers\DcatFormSelectController::class.'@index');