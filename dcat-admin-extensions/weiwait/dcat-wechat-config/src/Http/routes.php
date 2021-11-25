<?php

use Weiwait\Wechat\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-wechat-config', Controllers\DcatWechatConfigController::class.'@index');
