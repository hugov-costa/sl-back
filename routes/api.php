<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/check-auth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show'])->where('user', '[0-9]+');
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::put('/{user}', [UserController::class, 'update'])->where('user', '[0-9]+');
        Route::delete('/{user}', [UserController::class, 'destroy'])->where('user', '[0-9]+');
    });
});
