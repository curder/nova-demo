<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', config('nova.path').'/resources/users')->name('index');
