<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all()->where('role', 'user')->take(10);

        $total_users = $users->count();
        $total_courses = Course::count();
        $total_enrollments = Enrollment::count();
        $total_revenue = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->sum('courses.price');

        $recent_enrollments = Enrollment::with('student', 'course')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admins.dashboard', compact('users', 'recent_enrollments', 'total_users', 'total_courses', 'total_enrollments', 'total_revenue'));
    }

    public function users()
    {

    }
}
