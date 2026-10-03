<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

/* ---------- Auth ---------- */
Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/signin', [AuthController::class, 'signin'])->middleware('throttle:login')->name('signin');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/* ---------- Student ---------- */
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/home', [ProfileController::class, 'index'])->name('student.home');

    Route::prefix('students')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update.custom');

        Route::get('/all-courses/{category?}', [ProfileController::class, 'allCourses'])->name('all-courses');
        Route::get('/courses', [ProfileController::class, 'courses'])->name('courses');
        Route::post('/courses/{course}/enroll', [ProfileController::class, 'store'])->name('courses.enroll');
        Route::get('/courses/{course}', [CoursesController::class, 'show'])
            ->middleware('check_enrollment')
            ->name('course-details');
    });
});

/* ---------- Instructor / Admin ---------- */
Route::middleware(['auth', 'role:instructor,admin'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');

    Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CoursesController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}/update', [CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}/destroy', [CoursesController::class, 'destroy'])->name('courses.destroy');

    Route::resource('sections', SectionController::class)->only(['create', 'store']);
    Route::resource('lessons', LessonController::class)->only(['store']);
});

/* ---------- Admin ---------- */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class)->except(['create', 'show']);
});
