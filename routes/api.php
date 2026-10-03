<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {

    /* ---------- Public ---------- */
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    });

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/courses', [CourseController::class, 'index']);

    /* ---------- Authenticated ---------- */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/me', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

        // Student
        Route::middleware('role:student')->group(function () {
            Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store']);
            Route::get('/my-courses', [EnrollmentController::class, 'index']);
            Route::get('/my-courses/{course}', [EnrollmentController::class, 'show']);
        });

        // Instructor / Admin
        Route::middleware('role:instructor,admin')->prefix('instructor')->group(function () {
            Route::get('/dashboard', [InstructorController::class, 'index']);
            Route::apiResource('courses', CourseController::class)->except(['index']);
            Route::apiResource('sections', SectionController::class)->only(['store']);
            Route::apiResource('lessons', LessonController::class)->only(['store']);
        });

        // Admin
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index']);
            Route::apiResource('users', UserController::class);
            Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        });
    });
});
