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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

});

Route::prefix('students')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update.custom');

    Route::post('/courses/{course}/enroll', [ProfileController::class, 'store'])->name('courses.enroll');
    Route::get('all-courses', [ProfileController::class, 'allCourses'])->name('all-courses');
    Route::get('courses', [ProfileController::class, 'courses'])->name('courses');
    Route::get('courses/{course}', [CoursesController::class, 'show'])->name('course-details');
});

Route::middleware('auth', 'role:user')->prefix('student')->name('student.')->group(function () {
    Route::get('/home', [ProfileController::class, 'index'])->name('home');
});

Route::middleware('auth', 'role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');

    Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CoursesController::class, 'store'])->name('courses.store');

    Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}/update', [CoursesController::class, 'update'])->name('courses.update');

    Route::delete('/courses/{course}/destroy', [CoursesController::class, 'destroy'])->name('courses.destroy');

    Route::resource('/sections', SectionController::class);
    Route::resource('/lessons', LessonController::class);

});

Route::middleware('auth', 'role:admin')->prefix('admin')->group(function () {
    Route::name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('/users', UserController::class);
        Route::resource('/categories', CategoryController::class);
    });
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
