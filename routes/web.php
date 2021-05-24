<?php

use Illuminate\Support\Facades\Route;

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
    return view('main.home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

//Return All Users
Route::get('/api/users', 'HomeController@users');	

//Project Routes	
Route::resource('api/projects', 'ProjectController');
Route::get('/api/projects/{project}/delete','ProjectController@delete');

//Project Activity Feed
Route::get('/projects/{project}/timeline_feeds','ProjectController@activity')->name('activities'); 

//Project Feature Routes	
Route::post('/api/projects/{project}/mail','FeaturesController@mail');

Route::patch('/api/project/{project}/stage','FeaturesController@stage')->
middleware('can:access,project');

Route::post('/api/projects/{project}/sms','FeaturesController@sms');
Route::get('/api/projects/{project}/export','FeaturesController@export');

Route::patch('/api/projects/{project}/notes','FeaturesController@notes')->
middleware('can:access,project');

Route::patch('/api/project/{project}/postponed','FeaturesController@postponed')->middleware('can:access,project');

//Appointment Routes
Route::resource('api/project/{project}/appointment', 'AppointmentController')->middleware('can:access,project');

//Task Routes
Route::resource('api/project/{project}/task', 'TaskController')->middleware('can:access,project');

//Project Subscribe Route
Route::post('/api/projects/{project}/subscribe','SubscribeController@projectSubscribe');
Route::delete('/api/projects/{project}/unsubscribe','SubscribeController@projectUnSubscribe'); 

//Invitation Routes
Route::get('/api/users/search', 'InvitationController@search');

Route::post('/api/projects/{project}/invitations', 'InvitationController@store')->middleware('can:manage,project');

Route::get('project/{project}/member','InvitationController@accept');
Route::get('project/{project}/cancel','InvitationController@ignore');

Route::get('/api/project/{project}/cancel/{user}','InvitationController@cancel')->middleware('can:manage,project');

//Profile Routes
Route::resource('/api/profile/user','ProfileController');
Route::post('/api/user/{user}/avatar', 'ProfileController@avatar')->name('avatar');
Route::patch('/api/user/{user}/avatar-delete','ProfileController@avatarDelete');

//Notifications Routes 
Route::get('/profile/{user}/notifications', 'NotificationsController@index');
Route::delete('/profile/{user}/notifications/{notification}', 'NotificationsController@destroy');

//Subscription Routes
Route::post('subscribe','SubscriptionController@subscribe')->name('subscribe');
Route::get('plan/create','SubscriptionController@createPlan');
Route::get('plan/list','SubscriptionController@listPlan');
Route::get('plan/{id}','SubscriptionController@showPlan');
Route::get('plan/{id}/active','SubscriptionController@activePlan');
Route::post('plan/{id}/agreement/create','SubscriptionController@createAgreement')->
name('create-aggreement');
Route::get('execute-agreement/{status}','SubscriptionController@executeAgreement');
});

//Group Chat Conversation Routes
Route::post('/api/project/{project}/conversations', 'ConversationController@store');
Route::get('/api/project/{project}/conversation','ConversationController@conversation');

//SPA Routes
Route::get('{path}', 'HomeController@index')->where('/path', '([A-z\d-\/_.]+)?');
