<?php

use Weiwait\DcatIcon\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-icon', Controllers\DcatIconController::class.'@index');