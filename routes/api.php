<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\
{
  ProjectController,
  TaskController,
  FeaturesController,
  SubscribeController,
  InvitationController,
  NotificationsController,
  ProfileController,
  ConversationController,
  DashboardController,
  UserController,
  WelcomeController,
  StageController,
};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1'], function () {

Route::get('/welcome',[WelcomeController::class,'index']);
//Return All Users
Route::get('/users',[UserController::class,'index']);

Route::get('/user',[UserController::class,'show']);

//Return All Stages
Route::get('/stages',[StageController::class,'index']);

//Project Api Resource Routes
Route::apiResource('/projects', ProjectController::class);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

Route::get('/delete',[ProjectController::class,'delete']);

//Project Activity Feed
Route::get('/timeline_feeds',[ProjectController::class,'activity'])
->name('activities');

//Route::middleware(['can:access,project'])->group(function () {
//Project Feature Routes
Route::post('/mail',[FeaturesController::class,'mail']);
Route::post('/sms',[FeaturesController::class,'sms']);
Route::get('/export',[FeaturesController::class,'export']);
Route::patch('/stage',[FeaturesController::class,'stage']);
Route::patch('/postponed',[FeaturesController::class,'postponed']);

//Task Routes
Route::patch('/task/{task}/status',[TaskController::class,'status']);
Route::apiResource('/task',TaskController::class)->except(['index','show']);

//Project Subscribe Route
Route::post('/subscribe',[SubscribeController::class,'projectSubscribe']);
Route::delete('/unsubscribe', [SubscribeController::class,'projectUnSubscribe']);

//Project Invitation With Middleware Route
Route::middleware(['can:manage,project'])->group(function () {
Route::post('/invitations', [InvitationController::class,'store']);
Route::get('/cancel/{user}',[InvitationController::class,'cancel']);
});

//Project Invitation User Side
Route::get('/member',[InvitationController::class,'accept']);
Route::get('/cancel',[InvitationController::class,'ignore']);

//Group Chat Conversation Routes
Route::post('/conversations', [ConversationController::class,'store']);
Route::get('/conversation',[ConversationController::class,'conversation']);

});

//Invitation Search Routes
Route::get('/users/search', [InvitationController::class,'search']);

//Notifications Routes
Route::get('/user/{user}/notifications', [NotificationsController::class,'index']);
Route::delete('/user/{user}/notifications/{notification}', [NotificationsController::class,
	'destroy']);

//Profile Routes
Route::group(['prefix' => 'profile'], function() {

Route::get('/user/{user}',[ProfileController::class,'show']);

Route::apiResource('/user',ProfileController::class)->only('update','delete')
->middleware('can:owner,user');

Route::post('/{user}/avatar', [ProfileController::class,'avatar'])->name('avatar');
Route::patch('/{user}/avatar-delete',[ProfileController::class,'avatarDelete']);
});

Route::get('/projectoverview', [ProjectController::class,'projectoverview']);

//Dashboard Routes
Route::get('/projectcount',[DashboardController::class,'projectcount']);
Route::get('/userprojects',[DashboardController::class,'userprojects']);

});

Route::fallback(function() {
    return response()->json(['message' => 'Not Found.'], 404);
});
