<?php

namespace App\Services\Admin;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// إحصائيات لوحة تحكم الأدمن
class AdminDashboardService
{
    public function stats(): array
    {
        return [
            'users' => User::latest()->take(10)->get(['id', 'name', 'image', 'role', 'created_at']),

            'total_users'       => User::count(),
            'total_courses'     => Course::count(),
            'total_enrollments' => Enrollment::count(),

            // السعر وقت الاشتراك، وللقديم ناخد سعر الكورس
            'total_revenue' => (float) Enrollment::leftJoin('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum(DB::raw('COALESCE(enrollments.price, courses.price, 0)')),

            'recent_enrollments' => Enrollment::with(['student:id,name,image', 'course:id,title,price'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
}
