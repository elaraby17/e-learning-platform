<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update.custom');
});

Route::middleware('auth', 'role:user')->prefix('student')->name('student.')->group(function () {
    Route::get('/home', [ProfileController::class, 'index'])->name('home');
});

Route::middleware('auth', 'role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');

});

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
