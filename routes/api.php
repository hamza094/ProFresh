<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;

use App\Http\Controllers\Api\
{
  AppointmentController,
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

Route::get('/welcome',[WelcomeController::class,'index']); 

//Return All Users
Route::get('/users',[UserController::class,'index']);	

//Project Api Resource Routes  
Route::apiResource('/projects', ProjectController::class);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {

Route::get('/delete',[ProjectController::class,'delete']);

//Project Activity Feed
Route::get('/timeline_feeds',[ProjectController::class,'activity'])
->name('activities'); 

Route::middleware(['can:access,project'])->group(function () {

//Project Feature Routes 
Route::post('/mail',[FeaturesController::class,'mail']);
Route::post('/sms',[FeaturesController::class,'sms']);
Route::get('/export',[FeaturesController::class,'export']);  
Route::patch('/stage',[FeaturesController::class,'stage']);
Route::patch('/notes',[FeaturesController::class,'notes']);
Route::patch('/postponed',[FeaturesController::class,'postponed']);

//Appointment and Task Routes
Route::apiResources([
    '/appointment' => AppointmentController::class,
    '/task' => TaskController::class,
]);

});

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
Route::get('/profile/{user}/notifications', [NotificationsController::class,'index']);
Route::delete('/profile/{user}/notifications/{notification}', [NotificationsController::class,
	'destroy']);

//Profile Routes
Route::group(['prefix' => 'profile'], function() {
  
Route::get('/user/{user}',[ProfileController::class,'show']);

Route::apiResource('/user',ProfileController::class)->only('update','delete')->
middleware('can:owner,user');

Route::post('/{user}/avatar', [ProfileController::class,'avatar'])->name('avatar');
Route::patch('/{user}/avatar-delete',[ProfileController::class,'avatarDelete']);
});

Route::get('/projectoverview', [ProjectController::class,'projectoverview']);

//Dashboard Routes
Route::get('/projectcount',[DashboardController::class,'projectcount']);
Route::get('/userproject',[DashboardController::class,'userprojects']);
});



