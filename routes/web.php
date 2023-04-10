<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', config('nova.path') . '/dashboards/main')->name('index');
