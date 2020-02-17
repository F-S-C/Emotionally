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
        Route::get('/project/{id}/report', 'ProjectController@getProjectReport')->name('report-project');

        Route::prefix('/video/{id}')
            ->group(function () {
                Route::get('/', 'VideoController@getVideoReport')->name('report-video');
                Route::put('/edit/duration', 'VideoController@resetInterval')->name('edit-video-duration');
                    Route::get('/file', 'ReportController@getReportFile')->name('layout-file');
                Route::name('download-')
                    ->group(function () {
                    Route::get('/downloadPDF', 'ReportController@downloadPDF')->name('pdf');
                    Route::get('/downloadJSON', 'ReportController@downloadJSON')->name('json');
                    Route::get('/downloadPPTX', 'ReportController@downloadPPTX')->name('pptx');
                    Route::get('/downloadExcel', 'ReportController@downloadExcel')->name('excel');
                });
            });

        Route::middleware('permissions:read')
            ->group(function () {
                Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details');
                Route::prefix('/project/{project_id}/share')
                    ->name('permissions.')
                    ->group(function () {
                        Route::get('/', 'PermissionsController@getProjectPermissions')
                            ->name('index');
                        Route::delete('/delete/{user_id}', 'PermissionsController@deletePermission')
                            ->name('delete');

                        Route::put('/add', 'PermissionsController@addPermission')
                            ->name('add');

                        Route::any('/edit', 'PermissionsController@editPermission')
                            ->name('edit');
                    });
            });
    });

Auth::routes(/*['verify' => true]*/);

Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('landing');
})->name('logout');

// TODO: Implement a 'not logged in' notice
Route::name('verification.notice')->get('/not-logged', function () {
    return 'not logged';
});

Route::redirect('/home', '/system');
