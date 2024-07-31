<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\OAuth\ZoomAuthController;

use App\Http\Controllers\Api\Webhooks\ZoomController;

use App\Http\Middleware\VerifyZoomWebhook;

use App\Http\Controllers\Api\Zoom\ZoomTokenController;


use App\Http\Controllers\Api\
{
  ProjectController,
  TaskController,
  FeaturesController,
  InvitationController,
  NotificationsController,
  AvatarController,
  ConversationController,
  ProjectDashboardController,
  UserController,
  WelcomeController,
  StageController,
  MessageController,
  ActivityController,
  SubscriptionController,
  TaskStatusController,
  TaskFeaturesController,
  ZoomMeetingController,
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

// Zoom Webhooks
Route::controller(ZoomController::class)
->middleware(VerifyZoomWebhook::class)
->prefix('webhooks/zoom/meetings')
->as('webhooks.meetings.')
->group(function(){
Route::post('update','update')->name('update');

Route::post('delete','delete')->name('delete');

Route::post('start','start')->name('start');

Route::post('ended','ended')->name('ended');
});
  
Route::middleware(['auth:sanctum'/*,\App\Http\Middleware\TrackLastActiveAt::class*/])->group(function () {

 Route::get('/user/token',[ZoomTokenController::class,'getUserToken']);

 Route::get('/user/jwt/token',[ZoomTokenController::class,'getJwtToken']);   

Route::controller(ProjectDashboardController::class)->group(function(){
 Route::get('/data','data');
 Route::get('/tasksdata','tasksData');
 Route::get('/user/activities','activities');
})->middleware(['can:owner','user']);

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
Route::get('export','export')->middleware('subscription');
Route::patch('stage','stage');
});


Route::controller(MessageController::class)->group(function(){
  Route::post('message','message');
  Route::get('messages/scheduled','scheduled');
  Route::delete('messages/{message}/delete','delete');
})->middleware('subscription');

Route::apiResource('/tasks', TaskController::class)
->withTrashed()
->except(['show'])
->middleware('subscription');

Route::controller(TaskFeaturesController::class)
->name('task.')
->prefix('tasks/{task}')
->group(function(){

Route::middleware(['can:taskallow,task'])->group(function () {    
Route::patch('assign','assign')->name('assign')->withTrashed();
Route::patch('unassign','unassign')->name('unassign')->withTrashed();
});

Route::middleware(['can:taskaccess,task'])->group(function () {
Route::delete('archive','archive')->name('archive')
    ->withTrashed();
Route::get('unarchive','unarchive')->name('unarchive')
        ->withTrashed();
  Route::get('member/search', [TaskFeaturesController::class,'search'])->name('members.search');      
});


})->middleware('subscription');

//Chat Conversation Routes
Route::apiResource('/conversations',ConversationController::class)->only(['store','destroy'])
    ->middleware('subscription');
});

Route::controller(InvitationController::class)->group(function(){
  Route::post('invitations','store')->name('send.invitation')->can('manage','project');
  Route::get('remove/{user}','remove')->can('manage','project');
  Route::get('/accept-invitation','accept')->name('accept.invitation');
  Route::get('/ignore','ignore');
});

Route::apiResource('/meetings',ZoomMeetingController::class);

});



Route::apiResource('/users',UserController::class);

Route::get('users/search', [InvitationController::class,'search']);

//Dashboard Routes
Route::get('/user/projects',[ProjectDashboardController::class,'userprojects']);

Route::group(['prefix' => 'users/{user}'], function() {

Route::get('/notifications', [NotificationsController::class,'index']);

Route::delete('/notifications/{notification}', [NotificationsController::class,'destroy']);

Route::patch('/avatar_remove',[AvatarController::class,'removeAvatar']);

Route::post('/avatar', [AvatarController::class,'avatar'])
       ->name('user.avatar');
});

Route::controller(SubscriptionController::class)
->prefix('user')
->group(function () {

Route::get('subscribe/{plan}','subscribe')
      ->name('user.subscribe');   

 Route::get('subscriptions','subscriptions')
      ->name('user.subscription');

Route::middleware(['subscription'])->group(function () {

Route::get('subscription/swap/{plan}','swap')
    ->name('subscription.swap');

Route::get('subscription/{plan}/cancel','cancel')
    ->name('subscription.cancel');  
});

});

Route::get('task/statuses',TaskStatusController::class)
           ->name('task.status'); 
           
   
Route::controller(ZoomAuthController::class)
 ->as('oauth.zoom.')
 ->group(function () {
 Route::get('oauth/zoom/redirect', 'redirect')->name('redirect');
 Route::get('oauth/zoom/callback', 'callback')->name('callback');
 });    
                      
});
});

?>