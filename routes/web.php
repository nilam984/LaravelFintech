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
use App\Http\Controllers\Admin\UpiServicesController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Reseller\ResellerController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    return response()->json([
        'status'  => 'success',
        'message' => 'Application cache cleared successfully.'
    ]);
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
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

// Admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/all-users', [AdminController::class, 'allusers'])->name('admin.all-users');
    // Route::post('/datatable/{table}', [DataTableController::class, 'index'])->name('datatable');
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

    // Upi Services
    Route::get('upi-initiation', [UpiServicesController::class, 'upiInitiation'])->name('admin.upi.initiation');
    Route::get('upi-collection', [UpiServicesController::class, 'upiCollection'])->name('admin.upi.collection');
    Route::get('all-upi-transaction', [UpiServicesController::class, 'allUpitransaction'])->name('admin.upi.transaction');

    Route::get('user-details/{id}', [AdminController::class, 'userDetails'])->name('user.detail');
    Route::post('user-kyc-verify', [AdminController::class, 'verifyKyc'])->name('user.kyc.verify');


    Route::get('verification-user', [AdminController::class, 'verificationOfficer'])->name('verification.user');

    Route::get('/payout/transactions', [PayoutController::class, 'transactions'])->name('admin.payout.transaction');

    Route::get('/cost-setup', [AdminController::class, 'costSetup'])->name('cost.setup');
    Route::post('/cost-setup/store', [AdminController::class, 'storeCostSetup'])->name('cost.setup.store');
    Route::post('/cost-setup/update/{id}', [AdminController::class, 'updateCostSetup'])->name('cost.setup.update');
    Route::get('bank-update-request', [AdminController::class, 'bankUpdateRequest'])->name('admin.bank.update.request');
    Route::post('bank.request.update', [AdminController::class, 'bankRequestUpdate'])->name('admin.bank.request.update');

    Route::post('/verification/store', [AuthController::class, 'storeVerificationUser'])->name('verification.user.store');
    Route::post('/verification/update/{id}', [AuthController::class, 'updateverificationUser'])->name('verification.user.update');

    Route::get('/menus', [AdminController::class, 'menus'])->name('admin.menus');
    Route::put('/menus', [AdminController::class, 'updateMenu'])->name('admin.menus.update');


    // Reseller User 
    Route::get('reseller-users', [AdminController::class, 'resellerUsers'])->name('admin.reseller.users');
    Route::post('onboard-reseller', [AdminController::class, 'onboardReseller'])->name('admin.onboard.reseller');
    Route::post('updated-reseller', [AdminController::class, 'updateReseller'])->name('admin.reseller.update');
    Route::get('get-reseller/{id}', [AdminController::class, 'getReseller'])->name('get.reseller');
    Route::get('ledger', [AdminController::class, 'ledger'])->name('admin.ledger');
    
    Route::get('/payout/{id}/receipt/download', [PayoutController::class, 'downloadReceipt'])->name('admin.payout.receipt.download');
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
    Route::get('/webhookurl/edit/{id}', [UserController::class, 'edit'])->name('webhookurl.edit');
    Route::post('/webhookurl/update/{id}', [UserController::class, 'update'])->name('webhookurl.update');

    Route::get('load-money', [UserController::class, 'loadMoney'])->name('user.load.money');
    Route::post('/load-money/store', [UserController::class, 'loadmoneystore'])->name('load-money.store');
    Route::post('add-update-ip', [OauthUserController::class, 'saveOrUpdateIpWhitelist'])->name('add.update.ip');
    Route::post('delete-ip', [OauthUserController::class, 'deleteIpWhitelist'])->name('delete.ip');
    Route::get('bank-update-request', [UserController::class, 'bankUpdateRequest'])->name('user.bank.update.request');
    Route::post('raise-request-bank-updation', [UserController::class, 'raiseRequestBankUpdation'])->name('raise.request.bank.updation');
    Route::post('update-user-bank', [UserController::class, 'updateUserBank'])->name('update.user.bank');

    Route::get('upi-initiation', [UserController::class, 'upiInitiation'])->name('user.upi.initiation');
    Route::get('upi-collection', [UserController::class, 'upiCollection'])->name('user.upi.collection');
    Route::get('all-upi-transaction', [UserController::class, 'allUpitransaction'])->name('user.upi.transaction');
    Route::get('payout-orders', [PayoutController::class, 'userpayout'])->name('user.payout');
});


Route::middleware(['auth'])->prefix('reseller')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'resellerDashboard'])->name('reseller.dashboard');
    Route::post('user/validate', [ResellerController::class, 'validateUser'])->name('reseller.user.validate');
    Route::post('payment/create', [ResellerController::class, 'createPayment'])->name('reseller.payment.create');
    Route::get('/reseller/payment/result/{order?}', [ResellerController::class, 'paymentResult'])->name('reseller.payment.result');
    Route::get('/get/service', [ResellerController::class, 'getServices'])->name('get.services');
});

Route::get('reseller-payment-return', [ResellerController::class, 'resellerReturn'])->name('reseller.payment.return');
