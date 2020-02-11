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

// Route to test Affectiva
//Route::view('/test-webcam', 'test-webcam')->name('webcam');

Route::view('/', 'landing')->name('landing');

Route::name('system.')
    ->middleware('auth')
    ->middleware('verified')
    ->prefix('system')
    ->group(function () {
        Route::get('/', 'ProjectController@getDashboard')->name('home');
        Route::redirect('/home', '/system/');

    Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details');

    Route::get('/project/{id}/report', 'ProjectController@getProjectReport')->name('report-project');

    Route::get('report-video/{id}', 'VideoController@getVideoReport')->name('report-video');
});

Auth::routes(/*['verify' => true]*/);

Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('landing');
})->name('logout');

Route::redirect('/home', '/system');
