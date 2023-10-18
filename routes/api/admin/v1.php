<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\Admin\
{
  ProjectController
};
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------*/

Route::group(['prefix'=>'v1/admin'], function () {

Route::middleware(['auth:sanctum'])->group(function () {  

//Project Api Resource Routes
Route::get('/projects', [ProjectController::class,'index']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

});
});
});

?>