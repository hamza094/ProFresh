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
| API V1 Routes
|--------------------------------------------------------------------------*/

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
  Route::post('message','message');
  Route::get('messages/scheduled','scheduled');
  Route::delete('messages/{message}/delete','delete');
});

//Task Routes
Route::apiResource('/task',TaskController::class)->except(['index','show']);
Route::patch('/task/{task}/status',[TaskController::class,'status']);

//Chat Conversation Routes
Route::apiResource('/conversations',ConversationController::class)->only(['store','destroy']);
});

Route::controller(InvitationController::class)->group(function(){
  Route::post('invitations','store')->name('send.invitation')->can('manage','project');
  Route::get('remove/{user}','remove')->can('manage','project');
  Route::get('/accept-invitation','accept')->name('accept.invitation');
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

?>