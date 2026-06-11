<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/check-auth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show'])->where('user');
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/', [UserController::class, 'store'])->middleware('auth:sanctum', 'admin');
        Route::put('/{user}', [UserController::class, 'update'])->where('user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->where('user');
    });
});
