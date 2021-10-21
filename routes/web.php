<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\SubscriptionController;

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
Route::get('/', function () {
    return view('welcome.home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

//Plan Route Prefix
Route::group(['prefix' => 'plan'], function() {
Route::get('/create',[SubscriptionController::class,'createPlan']);
Route::get('/list',[SubscriptionController::class,'listPlan']);
Route::get('/{id}',[SubscriptionController::class,'showPlan']);
Route::get('/{id}/active',[SubscriptionController::class,'activePlan']);
Route::post('/{id}/agreement/create',[SubscriptionController::class,'createAgreement'])->
name('create-aggreement');
});

Route::get('execute-agreement/{status}',[SubscriptionController::class,'executeAgreement']);
});

//SPA Routes
Route::get('{path}', HomeController::class)->where('/path', '([A-z\d-\/_.]+)?');
