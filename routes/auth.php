<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\{
  RegisterController,
  LoginController,
  ResetPasswordController,
  VerificationController,
};
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Auth routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1'], function () {

  Route::group(['middleware' => 'guest:api'], function () {

  Route::post('register', [RegisterController::class, 'register'])->name('auth.register');

  Route::post('login', [LoginController::class, 'login'])->name('auth.login');

  Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])
  ->name('password.email');

  Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
  ->name('password.email');

  Route::post('/email/verify/{id}', [VerificationController::class, 'verify'])
    ->name('verification.verify');
});

Route::group(['middleware' => ['auth:sanctum']], function () {

  Route::post('/email/resend/{id}', [VerificationController::class, 'resend'])
    ->name('verification.resend');

  Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');

});

});
