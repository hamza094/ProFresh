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
  TaskStatusController,
  TaskFeaturesController
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
Route::get('export','export')->middleware('subscription');
Route::patch('stage','stage');
});


Route::controller(MessageController::class)->group(function(){
  Route::post('message','message');
  Route::get('messages/scheduled','scheduled');
  Route::delete('messages/{message}/delete','delete');
})->middleware('subscription');


//Task Routes

Route::middleware(['can:manage,project'])->group(function () {
Route::apiResource('/tasks', TaskController::class)->except(['show']);
});
//->middleware('subscription');

Route::get('/member/search', [TaskFeaturesController::class,'search']);

Route::controller(TaskFeaturesController::class)
->name('task.')
->prefix('tasks/{task}')
->group(function(){
Route::patch('assign','assign')->name('assign');

Route::patch('unassign','unassign')->name('unassign');

Route::delete('archive','archive')->name('archive');

Route::get('unarchive','unarchive')->name('unarchive')
                                    ->withTrashed();

Route::delete('delete','delete')->name('delete')
                                ->withTrashed();
});


//->middleware('subscription');


//Chat Conversation Routes
Route::apiResource('/conversations',ConversationController::class)
        ->only(['store','destroy'])
        ->middleware('subscription');
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
});
});

?>