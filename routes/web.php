<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get(
    '/', 
    function () {
        return view('home');
    }
);

Route::get(
    '/home',
    function () {
        return view('home');
    }
)->name('home')->middleware('locale');

Route::get(
    '/about',
    function () {
        return view('about');
    }
)->name('about');

Route::get(
    '/contact',
    function () {
        return view('contact_us');
    }
)->name('contact_us');

Route::get(
    '/registered', 
    function () {
        return view('registered');
    }
);

Route::get('create_account_type', 'Auth\RegisterController@createAccountType')
    ->name('register.create_account_type');

Route::resources(['events' => 'EventsController']);
Route::resources(['event_organisers' => 'EventOrganisersController']);
Route::resources(['applicant_lists' => 'ApplicantListsController']);

Route::middleware(['verified'])->group( function () {
    Route::resources(['applicants' => 'ApplicantsController']);
    Route::resources(['slots' => 'SlotsController']);
    Route::resources(['users_profile' => 'UsersProfileController']);
});

Auth::routes(['verify' => true]);