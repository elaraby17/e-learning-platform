<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', auth()->id())->get();
        $total_courses = auth()->user()->courses->count();
        $total_students = Enrollment::whereIn('course_id', auth()->user()->courses->pluck('id'))->count();
        $avg_rating = auth()->user()->courses->avg('rating');
        return view('instructor.dashboard', compact('courses', 'total_courses', 'total_students', 'avg_rating'));
    }
}
