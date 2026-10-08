<?php

namespace App\Services\Instructor;

use App\Models\Enrollment;
use App\Models\User;


class InstructorDashboardService
{
    public function stats(User $instructor): array
    {
        $courses = $instructor->courses()->with('category')->latest()->get();

        return [
            'courses'        => $courses,
            'total_courses'  => $courses->count(),
            'total_students' => Enrollment::whereIn('course_id', $courses->pluck('id'))->count(),
            
            'avg_rating'     => $courses->avg('average_rating'),
        ];
    }
}
