<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Instructor;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

/* ---------- تسجيل الدخول والتسجيل (للزوار بس) ---------- */
Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/signin', [AuthController::class, 'signin'])->middleware('throttle:login')->name('signin');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/* ---------- البروفايل (مشترك لكل المستخدمين المسجلين) ---------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update.custom');
});

/* ---------- الطالب ---------- */
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/home', [Student\HomeController::class, 'index'])->name('student.home');

    Route::prefix('students')->group(function () {
        Route::get('/all-courses/{category?}', [Student\CourseController::class, 'index'])->name('all-courses');
        Route::get('/courses', [Student\CourseController::class, 'myCourses'])->name('courses');
        Route::get('/courses/{course}', [Student\CourseController::class, 'show'])
            ->middleware('check_enrollment')
            ->name('course-details');

        Route::post('/courses/{course}/enroll', [Student\EnrollmentController::class, 'store'])->name('courses.enroll');
    });
});

/* ---------- المدرس (والأدمن كمان يقدر يدخل) ---------- */
Route::middleware(['auth', 'role:instructor,admin'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [Instructor\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('courses', Instructor\CourseController::class)->except(['index', 'show']);
    Route::resource('sections', Instructor\SectionController::class)->only(['create', 'store', 'destroy']);
    Route::resource('lessons', Instructor\LessonController::class)->only(['store', 'destroy']);

    // نفس صفحة البروفايل المشتركة (موجود عشان القايمة الجانبية)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

/* ---------- الأدمن ---------- */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', Admin\UserController::class)->except(['show']);
    Route::resource('categories', Admin\CategoryController::class)->except(['create', 'show']);
    Route::resource('courses', Admin\CourseController::class)->only(['index', 'destroy']);

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});
