<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DataTableController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login.page');
    Route::post('/login', 'login')->name('login');
    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
    Route::post('/forgot-password',  'forgotPassword')->name('forgot.password');
    Route::post('/reset-password',  'resetPassword')->name('reset.password');
    Route::post('/logout',  'logout')->name('logout')->middleware('auth');
});

// Admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/all-users', [AdminController::class, 'allusers'])->name('admin.all-users');
    Route::post('/datatable/{table}', [DataTableController::class, 'index'])->name('datatable');
    Route::post('/users/change-status', [AdminController::class, 'changeUserStatus'])->name('users.change-status');
});

// User routes
Route::prefix('user')->middleware('auth')->controller(AuthController::class)->group(function () {
    Route::get('/dashboard', 'userDashboard')->name('user.dashboard');
});
