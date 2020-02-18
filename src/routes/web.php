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

//TODO: Controllare i middleware dei permessi

Route::view('/', 'landing')->name('landing');

Route::name('system.')
    ->middleware('auth')
    ->middleware('verified')
    ->prefix('system')
    ->group(function () {
        Route::get('/', 'ProjectController@getDashboard')->name('home');
        Route::redirect('/home', '/system/');

        Route::prefix('/project/{id}/report')
            ->group(function () {
                Route::get('/', 'ProjectController@getProjectReport')->name('report-project');
                Route::get('/download/html', 'ReportController@downloadProjectHTML')->name('layout-file-project');

                Route::name('project.download-')
                    ->prefix('/download')
                    ->group(function () {
                        Route::get('/pdf', 'ReportController@downloadProjectPDF')->name('pdf');
                        Route::get('/json', 'ReportController@downloadProjectJSON')->name('json');
                        Route::get('/powerpoint', 'ReportController@downloadProjectPPTX')->name('pptx');
                        Route::get('/excel', 'ReportController@downloadProjectExcel')->name('excel');
                    });
            });

        Route::prefix('/video/{id}')
            ->group(function () {
                Route::get('/', 'VideoController@getVideoReport')->name('report-video');
                Route::put('/edit/duration', 'VideoController@resetInterval')->name('edit-video-duration');
                Route::get('/download/html', 'ReportController@downloadVideoHTML')->name('layout-file');
                Route::name('download-')
                    ->prefix('/download')
                    ->group(function () {
                        Route::get('/pdf', 'ReportController@downloadVideoPDF')->name('pdf');
                        Route::get('/json', 'ReportController@downloadVideoJSON')->name('json');
                        Route::get('/powerpoint', 'ReportController@downloadVideoPPTX')->name('pptx');
                        Route::get('/excel', 'ReportController@downloadVideoExcel')->name('excel');
                    });
            });

        Route::middleware('permissions:read')
            ->group(function () {
                Route::post('/videoUpload', 'VideoController@uploadVideo')->name('videoUpload');
                Route::post('/newProject', 'ProjectController@createProject')->name('newProject');
                Route::post('/realtimeUpload', 'VideoController@realtimeUpload')->name('realtimeUpload');
                Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set');
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

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('landing');
})->name('logout');

Auth::routes(['verify' => true]);

Route::redirect('/home', '/system');
