<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\Admin\AdminCourseService;

class CourseController extends Controller
{
    public function __construct(private AdminCourseService $courseService) {}

    public function index()
    {
        $courses = $this->courseService->paginate();

        return view('admins.courses.index', compact('courses'));
    }

    public function destroy(Course $course)
    {
        $this->courseService->delete($course);

        return redirect()->route('admin.courses.index')->with('success', 'تم حذف الكورس بنجاح.');
    }
}
