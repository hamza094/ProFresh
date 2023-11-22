<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\Admin\
{
  ProjectController,
  TaskController,
  UserController,
  StageController,
  StatusController,
  DashBoardController,
};
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------*/

Route::group(['prefix'=>'v1/admin'], function () {

Route::middleware(['auth:sanctum',\App\Http\Middleware\TrackLastActiveAt::class])->group(function () {  

//Project Api Resource Routes
Route::get('/projects', [ProjectController::class,'index']);

Route::get('/tasks', [TaskController::class,'index']);

Route::get('/users', [UserController::class,'index']);

Route::get('/backup/database', [DashBoardController::class,'backup']);

Route::apiResource('/stages', StageController::class);

Route::apiResource('/statuses', StatusController::class);


Route::delete('/projects/bulk-delete', [ProjectController::class,'bulkDelete']);

Route::delete('/tasks/bulk-delete', [TaskController::class,'bulkDelete']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

});
});
});

?>