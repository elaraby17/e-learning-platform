<?php

use App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {

    /* ---------- Public ---------- */
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');

    /* ---------- Authenticated ---------- */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Admin
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::apiResource('users', Admin\UserController::class)->except(['show']);
        });

        // TODO: باقي الـ API (Instructor / Student) - هنعملها بنفس الـ Services
    });
});
