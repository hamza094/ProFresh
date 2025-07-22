<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\OAuthController;

use App\Http\Controllers\Api\OAuth\ZoomAuthController;

use App\Http\Controllers\Api\V1\Webhooks\ZoomWebhookController;

use App\Http\Middleware\VerifyZoomWebhook;

use App\Http\Controllers\Api\Auth\TwoFactorController;

use App\Http\Controllers\Api\V1\Zoom\ZoomTokenController;

use App\Http\Controllers\Api\V1\
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
  TokenController,
  UserInvitationsController,
};
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------*/

Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback'])->name('oauth.callback');

// Zoom Webhooks
Route::controller(ZoomWebhookController::class)
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

Route::controller(TwoFactorController::class)
    ->prefix('twofactor')
    ->name('twofactor.')
    ->group(function () {
        Route::post('setup', 'prepareTwoFactor')->name('setup');
        Route::post('confirm', 'confirmTwoFactor')->name('confirm');
        Route::get('fetch-user', 'getUserStatus')->name('fetch-user');
        Route::get('recovery-codes', 'showRecoveryCodes')->middleware('2fa.enabled')->name('recovery-codes');
        Route::delete('disable', 'disableTwoFactorAuth')->name('disable');
        Route::post('login-confirm', 'twoFactorLogin')->name('login-confirm')->withoutMiddleware(['auth:sanctum']);
    });


 Route::get('/user/token',[ZoomTokenController::class,'getUserToken']);

 Route::get('/user/jwt/token',[ZoomTokenController::class,'getJwtToken']);
 
    Route::controller(TokenController::class)
        ->prefix('api-tokens')
        ->name('api-tokens.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{token}', 'destroy')->name('destroy');
        });

    Route::get('/me/invitations', [UserInvitationsController::class, 'myInvitations'])
        ->name('user.invitations');

Route::controller(ProjectDashboardController::class)->group(function(){
 Route::get('/data','data');
 Route::get('/tasksdata','tasksData')->name('tasks.data');
 Route::get('/user/activities','activities');
})->middleware(['can:owner','user']);

//Return All Stages
Route::get('/stages',[StageController::class,'index']);

//Project Api Resource Routes
Route::apiResource('/projects', ProjectController::class)->except(['show']);

//Project Route Prefix
Route::group(['prefix' => 'projects/{project}'], function() {
Route::get('/',[ProjectController::class,'show'])->name('projects.show')->withTrashed();

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


//Chat Conversation Routes
Route::apiResource('/conversations',ConversationController::class)
     ->only(['store','destroy','index'])
    ->middleware('subscription');
});

Route::apiResource('/tasks', TaskController::class)
->except(['destroy'])
->withTrashed()
->middleware('subscription');

Route::controller(TaskFeaturesController::class)
->name('task.')
->prefix('tasks/{task}')
->group(function(){ 

Route::middleware(['can:manage,task'])->group(function () {

Route::patch('assign','assign')
    ->name('assign')
    ->withTrashed();

Route::patch('unassign','unassign')
        ->name('unassign')
        ->withTrashed();

Route::delete('/remove','remove')
   ->name('remove')
   ->withTrashed(); 

});

Route::middleware(['can:access,task'])->group(function () {
Route::delete('archive','archive')
    ->name('archive')
    ->withTrashed();

Route::get('unarchive','unarchive')
      ->name('unarchive')
        ->withTrashed();

  Route::get('member/search')
      ->name('members.search');      
});
})->middleware('subscription');


Route::controller(InvitationController::class)->group(function(){
  Route::post('invitations','invite')
  ->name('send.invitation')
  ->can('manage','project');

  Route::get('accept-invitation','accept')
  ->name('accept.invitation')
  ->can('canAcceptInvitation', 'project');

  Route::get('reject/invitation','reject')
  ->can('canAcceptInvitation', 'project');

  Route::get('cancel/invitation/users/{user}','cancel')
  ->name('projects.cancel-invitation');

  Route::get('remove/member/{user}','remove')
       ->can('manage','project');

  Route::get('pending/invitations','pending')
       ->can('manage','project')
       ->name('project.pending.invitation');
});

Route::apiResource('/meetings',ZoomMeetingController::class);

});

 Route::get('users/search',[InvitationController::class,'search'])->name('users.search');

Route::apiResource('/users',UserController::class)->except(['store']);
Route::delete('/users/{user}/force', [UserController::class, 'forceDestroy'])->name('users.forceDestroy');

//Dashboard Routes
Route::get('/user/projects',[ProjectDashboardController::class,'userprojects']);

Route::group(['prefix' => 'users/{user}'], function() {

Route::patch('/avatar_remove',[AvatarController::class,'removeAvatar']);

Route::post('/avatar', [AvatarController::class,'avatar'])
       ->name('user.avatar');
});

Route::controller(NotificationsController::class)
    ->prefix('notifications')
    ->name('notifications.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/mark-all-read', 'markAllAsRead')->name('markAllAsRead');
        Route::patch('/{notification}/status', 'updateStatus')->name('updateStatus');
        Route::delete('/{notification}', 'destroy')->name('destroy');
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

?>