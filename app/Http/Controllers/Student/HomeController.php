<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\StudentEnrollmentService;

class HomeController extends Controller
{
    public function __construct(private StudentEnrollmentService $enrollmentService) {}

    public function index()
    {
        $coursesEnrolled = $this->enrollmentService->myEnrollments(auth()->user());
        $enrolled_count  = $coursesEnrolled->count();

        return view('students.home', compact('enrolled_count', 'coursesEnrolled'));
    }
}
