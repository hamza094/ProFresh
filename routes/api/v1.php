<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\
{
  ProjectController,
  TaskController,
  FeaturesController,
  InvitationController,
  NotificationsController,
  AvatarController,
  ConversationController,
  DashboardController,
  UserController,
  WelcomeController,
  StageController,
  MessageController,
  ActivityController,
  SubscriptionController,

};
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------*/

Route::group(['prefix'=>'v1'], function () {

Route::controller(OAuthController::class)->group(function () {
    Route::get('/auth/redirect/{provider}', 'redirect')->name('oauth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('oauth.callback');
});  

Route::middleware(['auth:sanctum'])->group(function () {  

Route::get('/welcome',[WelcomeController::class,'index']);

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
Route::apiResource('/conversations',ConversationController::class)
                 ->only(['store','destroy']);
});

Route::controller(InvitationController::class)->group(function(){
  Route::post('invitations','store')->name('send.invitation')->can('manage','project');
  Route::get('remove/{user}','remove')->can('manage','project');
  Route::get('/accept-invitation','accept')->name('accept.invitation');
  Route::get('/ignore','ignore');
});
});

Route::apiResource('/users',UserController::class);

Route::get('users/search', [InvitationController::class,'search']);

//Dashboard Routes
Route::get('/user/projects',[DashboardController::class,'userprojects']);

Route::group(['prefix' => 'users/{user}'], function() {

Route::get('/notifications', [NotificationsController::class,'index']);

Route::delete('/notifications/{notification}', [NotificationsController::class,'destroy']);

Route::patch('/avatar_remove',[AvatarController::class,'removeAvatar']);

Route::post('/avatar', [AvatarController::class,'avatar'])
       ->name('user.avatar');
});

Route::get('/user/subscribe', [SubscriptionController::class,'subscribe'])->name('user.subscribe');   

 Route::get('user/subscriptions', [SubscriptionController::class,'subscriptions'])->name('user.subscription');

Route::get('user/subscription/swap/{plan}', [SubscriptionController::class,'swap'])->name('subscription.swap');

Route::get('user/subscription/{plan}/cancel', [SubscriptionController::class,'cancel'])->name('subscription.cancel');               

});
});

?>