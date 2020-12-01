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

    Route::post('/api/leads/{lead}/mail','LeadController@mail');




Auth::routes();
Route::post('/api/lead/{lead}/avatar', 'LeadController@avatar')->name('avatar');
Route::patch('/api/lead/{lead}/stage','LeadController@stage');
Route::patch('/api/lead/{lead}/unqualifed','LeadController@unqualifed');
Route::get('/api/leads/{lead}/delete','LeadController@delete');
Route::patch('/api/leads/{lead}/avatar-delete','LeadController@avatarDelete');
Route::post('/api/leads/{lead}/sms','LeadController@sms');
Route::resource('api/leads', 'LeadController');
Route::get('/api/leads/{lead}/export','LeadController@export');

//Lead Subscribe
Route::post('/api/leads/{lead}/subscribe','SubscriptionController@leadSubscribe');
Route::delete('/api/leads/{lead}/unsubscribe','SubscriptionController@leadUnSubscribe');

//Activity Feed
Route::get('/leads/{lead}/timeline_feeds','LeadController@activity');

//Account Routes
Route::post('/api/lead/{lead}/account', 'AccountController@leadaccount');

//Task Routes
Route::post('/api/leads/{lead}/tasks', 'TaskController@leadstore')->name('leadtask.create');
Route::get('/api/leads/{lead}/tasks','TaskController@leadindex');
Route::patch('/api/leads/{lead}/tasks/{task}', 'TaskController@leadupdate')->name('task.update');
Route::delete('/api/leads/{lead}/tasks/{task}', 'TaskController@leaddelete')->name('task.update');

//Appointment Routes
Route::get('/api/users', 'LeadController@user');
Route::post('/api/leads/{lead}/appointment', 'AppointmentController@store');
Route::get('/api/leads/{lead}/appointments', 'AppointmentController@show');
Route::patch('/api/leads/{lead}/appointment/{appointment}', 'AppointmentController@update');
Route::delete('/api/leads/{lead}/appointment/{appointment}', 'AppointmentController@destroy')->name('task.update');


Route::get('{path}', 'HomeController@index')->where('/path', '([A-z\d-\/_.]+)?');
