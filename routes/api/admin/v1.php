<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\Admin\
{
  ProjectController,
  TaskController
};
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------*/

Route::group(['prefix'=>'v1/admin'], function () {

Route::middleware(['auth:sanctum'])->group(function () {  

//Project Api Resource Routes
Route::get('/projects', [ProjectController::class,'index']);

Route::get('/tasks', [TaskController::class,'index']);


Route::delete('/projects/bulk-delete', [ProjectController::class,'bulkDelete']);

Route::delete('/tasks/bulk-delete', [TaskController::class,'bulkDelete']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

});
});
});

?>