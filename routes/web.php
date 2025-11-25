<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\HomeController;
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
Route::get('/', fn() => view('welcome.home'));

// SPA session auth endpoints (cookie-based via Sanctum stateful)
Route::prefix('api/v1/session')->group(function (): void {
    // Login establishes a session; guest-only
    Route::post('login', [LoginController::class, 'loginSpa'])
        ->middleware(['guest', 'throttle:auth-login']);

    // Logout destroys the current session; requires authenticated session (use sanctum to treat stateful requests)
    Route::post('logout', [LoginController::class, 'logoutSpa'])->middleware('auth:sanctum');
});

// SPA Routes
Route::get('{path}', HomeController::class)->where('path', '(.*)');
