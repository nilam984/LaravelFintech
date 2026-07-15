<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login.page');
    Route::post('/login', 'login')->name('login');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
});

// Admin routes
Route::prefix('admin')->middleware('auth')->controller(AuthController::class)->group(function () {
    Route::get('/dashboard', 'adminDashboard')->name('admin.dashboard');
});

// User routes
Route::prefix('user')->middleware('auth')->controller(AuthController::class)->group(function () {
    Route::get('/dashboard', 'userDashboard')->name('user.dashboard');
});
