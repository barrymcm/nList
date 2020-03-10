<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
)->name('about')->middleware('verified');

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

Route::get('select_account_type', 'Auth\RegisterController@selectAccountType')
    ->name('register.select_account_type');

Auth::routes(['verify' => true]);

Route::resources(['events' => 'EventsController']);
Route::resources(['event_organisers' => 'EventOrganisersController']);
Route::resources(['applicant_lists' => 'ApplicantListsController']);
Route::resources(['applicants' => 'ApplicantsController']);
Route::resources(['slots' => 'SlotsController']);
Route::resources(['customers' => 'CustomersController'])->middleware('verified');
