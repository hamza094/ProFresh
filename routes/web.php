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

Route::post('/api/projects/{project}/mail','ProjectController@mail');




Auth::routes();
Route::patch('/api/project/{project}/stage','ProjectController@stage');
Route::patch('/api/project/{project}/postponed','ProjectController@postponed');
Route::get('/api/projects/{project}/delete','ProjectController@delete');
Route::post('/api/projects/{project}/sms','ProjectController@sms');
Route::resource('api/projects', 'ProjectController');
Route::get('/api/projects/{project}/export','ProjectController@export');
Route::patch('/api/projects/{project}/notes','ProjectController@notes');

//Project Subscribe
Route::post('/api/projects/{project}/subscribe','SubscriptionController@projectSubscribe');
Route::delete('/api/projects/{project}/unsubscribe','SubscriptionController@projectUnSubscribe');

//Activity Feed
Route::get('/projects/{project}/timeline_feeds','ProjectController@activity')->name('activities');

//Task Routes
Route::post('/api/projects/{project}/tasks', 'TaskController@projectstore')->name('projecttask.create');
Route::get('/api/projects/{project}/tasks','TaskController@projectindex');
Route::patch('/api/projects/{project}/tasks/{task}', 'TaskController@projectupdate')->name('task.update');
Route::delete('/api/projects/{project}/tasks/{task}', 'TaskController@projectdelete')->name('task.update');

//Appointment Routes
Route::get('/api/users', 'ProjectController@user');
Route::post('/api/projects/{project}/appointment', 'AppointmentController@store');
Route::get('/api/projects/{project}/appointments', 'AppointmentController@show');
Route::patch('/api/projects/{project}/appointment/{appointment}', 'AppointmentController@update');
Route::delete('/api/projects/{project}/appointment/{appointment}', 'AppointmentController@destroy')->name('task.update');

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


//Group Chat Routes
Route::get('/api/project/{project}/groups', 'GroupController@store');
Route::resource('/api/project/{project}/conversations', 'ConversationController');
Route::get('/api/project/{project}/conversation','ConversationController@conversation');

Route::get('{path}', 'HomeController@index')->where('/path', '([A-z\d-\/_.]+)?');
