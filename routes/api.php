<?php

use App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Student\CourseController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {

    // Public
    Route::post('/auth/register', [AuthController::class, 'register'])
        ->middleware('throttle:login');

    Route::post('/auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);

    // Authenticated
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/auth/user', [AuthController::class, 'user']);

        Route::put('/auth/profile', [AuthController::class, 'updateProfile']);

        Route::put('/auth/password', [AuthController::class, 'updatePassword']);

        Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll']);

        // Student
        Route::middleware('role:student')
            ->prefix('student')
            ->group(function () {

                Route::get('/courses', [CourseController::class, 'myCourses']);

                Route::get('/courses/{course}', [CourseController::class, 'content']);
            });

        // Admin
        Route::middleware('role:admin')
            ->prefix('admin')
            ->group(function () {

                Route::apiResource(
                    'users',
                    Admin\UserController::class
                )->except(['show']);
            });
    });
});
