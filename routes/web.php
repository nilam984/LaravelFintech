<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SchemeController;
use App\Http\Controllers\Admin\StatusChangeController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\OauthUserController;

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

// Fetch Data Using Datatable
Route::middleware('auth')->group(function () {
    Route::post('/datatable/{table}', [DataTableController::class, 'index'])->name('datatable');
    Route::post('/profile', [ProfileController::class, 'businessinfo'])->name('businessinfo.profile');
});

// Admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/all-users', [AdminController::class, 'allusers'])->name('admin.all-users');
    Route::post('/datatable/{table}', [DataTableController::class, 'index'])->name('datatable');
    Route::post('/users/change-status', [StatusChangeController::class, 'changeUserStatus'])->name('users.change-status');
    Route::post('/global/service/change-status', [StatusChangeController::class, 'changeGlobalServiceStatus'])->name('global.service.change.status');
    Route::get('/global/services', [AdminController::class, 'globalServices'])->name('admin.global.services');
    Route::get('/service-request', [AdminController::class, 'serviceRequest'])->name('admin.service-request');
    Route::get('/profile-details', [AdminController::class, 'adminprofile'])->name('admin.profile');
    Route::post('/service-requests/change-status', [StatusChangeController::class, 'changeServiceRequest'])->name('service-requests.change-status');
    Route::get('/get-products/{service_id}', [AdminController::class, 'getProducts'])->name('get.products');
    Route::post('/add-products', [AdminController::class, 'addProduct'])->name('add.products');
    Route::post('/global-service/store', [AdminController::class, 'store'])->name('global.service.store');
    Route::post('/global-service/update', [AdminController::class, 'update'])->name('global.service.update');

    // Scheme 
    Route::get('scheme', [SchemeController::class, 'scheme'])->name('scheme');
    Route::post('/scheme/save',  [SchemeController::class, 'storeOrUpdate'])->name('scheme.save');
    Route::get('/scheme/{id}', [SchemeController::class, 'edit'])->name('scheme.edit');
    Route::post('/scheme/change-status', [StatusChangeController::class, 'changeSchemeStatus'])->name('scheme.change.status');
    Route::post('/assign-scheme', [SchemeController::class, 'assignScheme'])->name('assign.scheme');
    Route::get('gateway-routing', [AdminController::class, 'gatewayRouting'])->name('gateway.routing');
    Route::post('switch-gateway-routing', [AdminController::class, 'switchGatewayRoute'])->name('switch.gateway.routing');

    Route::get('load-money', [AdminController::class, 'loadMoney'])->name('admin.load.money');
    Route::post('load-money', [AdminController::class, 'loadMoneyAction'])->name('action.load.money');
    
});

// User routes
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/service-request', [UserController::class, 'serviceRequest'])->name('user.service-request');
    Route::post('/request-service', [UserController::class, 'userServiceRequest'])->name('user.request-service');
    Route::get('/profile-details', [UserController::class, 'userprofile'])->name('user.user-profile');
    Route::get('/oauth-user', [OauthUserController::class, 'index'])->name('user.oauthuser');
    Route::post('/oauth-user/store', [OauthUserController::class, 'generateClientCredentials'])->name('generate.client.credentials');
    Route::post('/webhookurl/store', [UserController::class, 'store'])->name('webhookurl.store');
    Route::get('/webhookurl/edit/{id}', [UserController::class,'edit'])->name('webhookurl.edit');
    Route::post('/webhookurl/update/{id}', [UserController::class,'update'])->name('webhookurl.update');

    Route::get('load-money', [UserController::class, 'loadMoney'])->name('user.load.money');
});
