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

Route::view('/', 'landing')->name('landing');

Route::name('system.')->middleware('auth')->middleware('verified')->prefix('system')->group(function () {
    Route::get('/', 'ProjectController@getDashboard')->name('home');
    Route::redirect('/home', '/system/');

    Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details');
});

Auth::routes(/*['verify' => true]*/);

Route::get('/logout', function(){
    Auth::logout();

    return redirect()->route('landing');
})->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
