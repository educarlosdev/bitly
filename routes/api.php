<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HitController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard/metrics', DashboardController::class);
    Route::delete('links/all', [LinkController::class, 'destroyAll']);

    Route::apiResource('avatar', AvatarController::class)->except(['index', 'show', 'update']);
    Route::apiResource('hits', HitController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('links', LinkController::class);
    Route::apiResource('user', UserController::class)->except(['index', 'store', 'show']);
});
