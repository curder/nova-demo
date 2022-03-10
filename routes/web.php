<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboards/main')->name('index');
