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
Route::post('/api/leads/{lead}/subscribe','SubscriptionController@leadSubscribe');
Route::delete('/api/leads/{lead}/unsubscribe','SubscriptionController@leadUnSubscribe');
Route::get('/leads/{lead}/timeline_feeds','LeadController@activity');
Route::get('{path}', 'HomeController@index')->where('/path', '([A-z\d-\/_.]+)?');
