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
        Route::post('/project/delete', 'ProjectController@deleteProject')->name('delete-project');
        Route::post('/project/rename', 'ProjectController@renameProject')->name('rename-project');
        Route::post('/video/rename', 'VideoController@renameVideo')->name('rename-video');

        Route::post('/videoUpload', 'VideoController@uploadVideo')->name('videoUpload');
        Route::post('/project/new', 'ProjectController@createProject')->name('newProject');
        Route::post('/realtimeUpload', 'VideoController@realtimeUpload')->name('realtimeUpload');
        Route::put('/video/report/set', 'VideoController@setReport')->name('video.report.set');

        /*Route::middleware('permissions:read') //TODO RIMUOVERE DOPO LA CORREZIONE DEL MIDDLEWARE
            ->group(function () {*/
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
            //});
    });


Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('landing');
})->name('logout');

// TODO: Reactivate 'verify' and remove the route verification.notice
Auth::routes(/*['verify' => true]*/);
Route::name('verification.notice')->get('/not-logged', function () {
    return 'not logged';
});

Route::redirect('/home', '/system');
