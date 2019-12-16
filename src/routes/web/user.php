<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return 'This is a test user route!!';
})->name('user.test');
