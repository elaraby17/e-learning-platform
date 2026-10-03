<?php
// app/Services/DashboardService.php
namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function instructorStats(User $instructor): array
    {
        $courses = $instructor->courses()->get();

        return [
            'courses'        => $courses,
            'total_courses'  => $courses->count(),
            'total_students' => Enrollment::whereIn('course_id', $courses->pluck('id'))->count(),
            'avg_rating'     => $courses->avg('rating'),
        ];
    }

public function adminStats(): array
{
    return [
        'users' => User::query()
            ->latest()
            ->take(10)
            ->get(['id', 'name', 'image', 'role', 'created_at']),

        'total_users'       => User::count(),
        'total_courses'     => Course::count(),
        'total_enrollments' => Enrollment::count(),

        // السعر وقت الاشتراك، وللقديم ناخد سعر الكورس
        'total_revenue' => (float) Enrollment::query()
            ->leftJoin('courses', 'enrollments.course_id', '=', 'courses.id')
            ->sum(DB::raw('COALESCE(enrollments.price, courses.price, 0)')),

        'recent_enrollments' => Enrollment::query()
    ->with([
        'student:id,name,image',
        'course:id,title,price',
    ])
    ->latest()
    ->take(10)
    ->get(),
    ];
}
}
