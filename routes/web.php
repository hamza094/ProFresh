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
    return view('welcome');
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
Route::patch('/api/project/{project}/stage','FeaturesController@stage');
Route::post('/api/projects/{project}/sms','FeaturesController@sms');
Route::get('/api/projects/{project}/export','FeaturesController@export');
Route::patch('/api/projects/{project}/notes','FeaturesController@notes'); 
Route::patch('/api/project/{project}/postponed','FeaturesController@postponed');

//Appointment Routes
Route::resource('api/project/{project}/appointment', 'AppointmentController');
 

//Project Subscribe Route
Route::post('/api/projects/{project}/subscribe','SubscribeController@projectSubscribe');
Route::delete('/api/projects/{project}/unsubscribe','SubscribeController@projectUnSubscribe'); 

//Task Routes
Route::post('/api/projects/{project}/tasks', 'TaskController@projectstore')->name('projecttask.create');
Route::get('/api/projects/{project}/tasks','TaskController@projectindex');
Route::patch('/api/projects/{project}/tasks/{task}', 'TaskController@projectupdate')->name('task.update');
Route::delete('/api/projects/{project}/tasks/{task}', 'TaskController@projectdelete')->name('task.update');

//Invitation Routes
Route::get('/api/users/search', 'InvitationController@search');
Route::post('/api/projects/{project}/invitations', 'InvitationController@store');
Route::get('project/{project}/member','InvitationController@accept');
Route::get('project/{project}/cancel','InvitationController@ignore');
Route::get('/api/project/{project}/cancel/{user}','InvitationController@cancel');

//Profile Routes
Route::get('users/{user}/profile','ProfileController@show');
Route::post('/api/user/{user}/avatar', 'ProfileController@avatar')->name('avatar');
Route::patch('/api/user/{user}/avatar-delete','ProfileController@avatarDelete');
Route::patch("/api/user/{user}/profile",'ProfileController@update');
Route::delete("/api/user/{user}/profile",'ProfileController@destroy');

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

//Group Chat Routes
Route::get('/api/project/{project}/groups', 'GroupController@store');
Route::resource('/api/project/{project}/conversations', 'ConversationController');
Route::get('/api/project/{project}/conversation','ConversationController@conversation');

//SPA Routes
Route::get('{path}', 'HomeController@index')->where('/path', '([A-z\d-\/_.]+)?');
