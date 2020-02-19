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
Route::redirect('/landing', '/');

Route::name('system.')
    ->middleware('auth')
    ->middleware('verified')
    ->prefix('system')
    ->group(function () {
        Route::get('/', 'ProjectController@getDashboard')->name('home');
        Route::redirect('/home', '/system/');

        Route::middleware('permissions:modify')
            ->group(function () {
                Route::post('/project/rename', 'ProjectController@renameProject')->name('rename-project');
                Route::post('/video/rename', 'VideoController@renameVideo')->name('rename-video');
                Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set');
            });
        Route::middleware('permissions:remove')
            ->group(function () {
                Route::post('/project/delete', 'ProjectController@deleteProject')->name('delete-project');
                Route::post('/video/delete', 'VideoController@deleteVideo')->name('delete-video');
            });
        Route::middleware('permissions:admin')->group(function () {
            Route::post('/project/move', 'ProjectController@moveProject')->name('move-project');
            Route::post('/video/move', 'VideoController@moveVideo')->name('move-video');
        });

        Route::post('/user/check-password', 'UserController@checkUserPassword')->name('user.password.check');
        Route::view('/profile', 'profile')->name('profile');
        Route::post('/profile/edit', 'UserController@editProfile')->name('edit-profile');

        Route::prefix('/project/{id}/report')
            ->middleware('permissions:read')
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
                Route::get('/', 'VideoController@getVideoReport')->name('report-video')->middleware('permissions:read');
                Route::put('/edit/duration', 'VideoController@resetInterval')->name('edit-video-duration')->middleware('permissions:modify');
                Route::get('/download/html', 'ReportController@downloadVideoHTML')->name('layout-file')->middleware('permissions:read');

                Route::name('download-')
                    ->middleware('permissions:read')
                    ->prefix('/download')
                    ->group(function () {
                        Route::get('/pdf', 'ReportController@downloadVideoPDF')->name('pdf');
                        Route::get('/json', 'ReportController@downloadVideoJSON')->name('json');
                        Route::get('/powerpoint', 'ReportController@downloadVideoPPTX')->name('pptx');
                        Route::get('/excel', 'ReportController@downloadVideoExcel')->name('excel');
                    });
            });

        Route::middleware('permissions:add')
            ->group(function () {
                Route::post('/video/upload', 'VideoController@uploadVideo')->name('videoUpload');
                Route::post('/video/realtime-upload', 'VideoController@realtimeUpload')->name('realtimeUpload');
            });
        Route::post('/project/new', 'ProjectController@createProject')->name('newProject');
        Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set')->middleware('permissions:modify');

        Route::get('/project/{id}', 'ProjectController@getProjectDetails')->name('project-details')->middleware('permissions:read');
        Route::prefix('/project/{project_id}/share')
            ->name('permissions.')
            ->middleware('permissions:admin')
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

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('landing');
})->name('logout');

Auth::routes(['verify' => true]);

Route::redirect('/home', '/system');
