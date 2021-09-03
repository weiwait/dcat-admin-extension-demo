<?php

use Weiwait\DcatSmtp\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-smtp', Controllers\DcatSmtpController::class.'@index');