<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChildDetailsController;
use App\Http\Controllers\Api\ChildMasterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('trigger-otp', 'triggerOtp');
    Route::post('otp-login', 'otpLogin');
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::middleware(['role:user'])->group(function () {
        Route::apiResource('user', UserController::class)->only(['index']);
        Route::post('user/update', [UserController::class, 'update']);

        Route::prefix('child')->group(function () {
            Route::apiResource('master', ChildMasterController::class)->except(['show', 'update']);
            Route::post('master/update/{id}', [ChildMasterController::class, 'update']);
        });

        Route::prefix('child/{id}')->group(function () {
            Route::apiResource('details', ChildDetailsController::class)->except(['show']);
        });
    });
});
