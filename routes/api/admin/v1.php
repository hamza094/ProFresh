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
  RolesController,
  PermissionsController,
  RolePermissionController
};
use App\Http\Controllers\Api\Admin\Integration\PaddleController;

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

Route::get('dashboard/activities',[DashBoardController::class,'activities']);

Route::get('data',[DashBoardController::class,'data']);

Route::get('subscriptions/list',[PaddleController::class,'subscribedUsers']);

Route::apiResource('/roles', RolesController::class)->except(['show']);

Route::apiResource('/permissions', PermissionsController::class)
       ->except(['show']);

Route::get('/assign/roles/{role}/permissions/{permission}',[RolePermissionController::class,'assignRolePermission']);

Route::get('/unAssign/roles/{role}/permissions/{permission}',[RolePermissionController::class,'unAssignPermission']);

Route::get('assign/users/{user}/roles/{role}',[RolePermissionController::class,'assignUserRole']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

});
});
});

?>