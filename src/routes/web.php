<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TODO: Remove
Route::view('/test-webcam', 'test-webcam')->name('webcam');

Route::view('/', 'landing')->name('landing');

Route::name('system.')->prefix('system')->group(function () {
    Route::get('/', 'ProjectController@getDashboard')->name('home');
    Route::redirect('/home', '/system/');

    Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details');
});
