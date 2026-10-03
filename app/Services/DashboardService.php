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
            'users'              => User::where('role', 'student')->latest()->take(10)->get(),
            'total_users'        => User::count(),
            'total_courses'      => Course::count(),
            'total_enrollments'  => Enrollment::count(),
            // لو الـ price فاضي في الاشتراكات القديمة ناخد سعر الكورس
            'total_revenue'      => Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->sum(DB::raw('COALESCE(enrollments.price, courses.price)')),
            'recent_enrollments' => Enrollment::with('student', 'course')->latest()->take(10)->get(),
        ];
    }
}
