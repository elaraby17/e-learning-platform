<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\Student\StudentEnrollmentService;

class EnrollmentController extends Controller
{
    public function __construct(private StudentEnrollmentService $enrollmentService) {}

    public function store(Course $course)
    {
        $this->enrollmentService->enroll(auth()->user(), $course);

        return redirect()->route('courses')->with('success', 'تم الاشتراك بنجاح');
    }
}
