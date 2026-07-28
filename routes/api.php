<?php

use App\Http\Controllers\API\PayinController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('payin')->group(function () {
    Route::post('create', [PayinController::class, 'payin']);
});
