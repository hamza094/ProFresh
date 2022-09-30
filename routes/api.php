<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\
{
  ProjectController,
  TaskController,
  FeaturesController,
  InvitationController,
  NotificationsController,
  ProfileController,
  ConversationController,
  DashboardController,
  UserController,
  WelcomeController,
  StageController,
  MessageController,
  ActivityController,
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

Route::controller(UserController::class)->group(function(){
  //Return All Users
  Route::get('/users','index');
  Route::get('/user','show');
});

//Return All Stages
Route::get('/stages',[StageController::class,'index']);

//Project Api Resource Routes
Route::apiResource('/projects', ProjectController::class)->except(['show']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {
Route::get('/',[ProjectController::class,'show'])->withTrashed();


Route::get('/delete',[ProjectController::class,'delete'])->can('manage','project');
Route::get('/restore',[ProjectController::class,'restore'])->withTrashed()->can('manage','project');


Route::middleware(['can:access,project'])->group(function () {

Route::get('/activities',[ActivityController::class,'index']);

//Project Feature Routes
Route::controller(FeaturesController::class)->group(function(){
Route::get('export','export');
Route::patch('stage','stage');
});


Route::controller(MessageController::class)->group(function(){
  Route::post('message','message')->can('access','project');
  Route::get('messages/scheduled','scheduled')->can('access','project');
  Route::delete('messages/{message}/delete','delete')->can('access','project');
});

//Task Routes
Route::apiResource('/task',TaskController::class)->except(['index','show']);
Route::patch('/task/{task}/status',[TaskController::class,'status']);

//Group Chat Conversation Routes
Route::post('/conversations', [ConversationController::class,'store']);
Route::get('/conversation',[ConversationController::class,'conversation']);

});

Route::controller(InvitationController::class)->group(function(){
  Route::post('invitations','store')->can('manage','project');
  Route::get('remove/{user}','remove')->can('manage','project');
  Route::get('/member','accept');
  Route::get('/ignore','ignore');
});
});

//Invitation Search Routes
Route::get('/users/search', [InvitationController::class,'search']);

//Notifications Routes
Route::get('/user/{user}/notifications', [NotificationsController::class,'index']);
Route::delete('/user/{user}/notifications/{notification}', [NotificationsController::class,
	'destroy']);

//Profile Routes
Route::group(['prefix' => 'profile'], function() {

Route::apiResource('/user',ProfileController::class)->only('show','update','delete');
//->middleware('can:owner,user');

Route::post('/{user}/avatar', [ProfileController::class,'avatar'])->name('avatar');
Route::patch('/{user}/avatar-delete',[ProfileController::class,'avatarDelete']);
});

Route::get('/projectoverview', [ProjectController::class,'projectoverview']);

//Dashboard Routes
Route::get('/user/projects',[DashboardController::class,'userprojects']);

});

Route::fallback(function() {
    return response()->json(['message' => 'Not Found.'], 404);
});
