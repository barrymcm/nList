<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return 'This is a test admin route!';
})->name('admin.test');
