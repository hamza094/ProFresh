<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\Api\Auth\VerificationController;

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

//Route::post('/webhooks/paddle', 'PaddleWebhookController@handle');


Route::middleware(['auth'])->group(function () {

//Plan Route Prefix
Route::group(['prefix' => 'plan'], function() {

Route::controller(SubscriptionController::class)->group(function(){
Route::get('create','createPlan');
Route::get('list','listPlan');
Route::get('{id}','showPlan');
Route::get('{id}/active','activePlan');
Route::post('{id}/agreement/create','createAgreement')->name('create-aggreement');
});
});


Route::get('execute-agreement/{status}',[SubscriptionController::class,'executeAgreement']);
});

//SPA Routes
Route::get('{path}', HomeController::class)->where('path', '(.*)');
