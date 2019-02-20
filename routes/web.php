<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get(
    '/',
    function () {
        return view('home');
    }
)->name('home');

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

Route::resources(['events' => 'EventsController']);
Route::resources(['applicants' => 'ApplicantsController']);
Route::resources(['applicant_lists' => 'ApplicantListsController']);
Route::resources(['slots' => 'SlotsController']);
Route::resources(['event_organisers' => 'EventOrganisersController']);

Auth::routes(['verify' => true]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');