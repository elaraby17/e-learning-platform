<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\Student\StudentCourseService;

// الطالب بيتصفح الكورسات ويشوف كورساته ويفتح الكورس
class CourseController extends Controller
{
    public function __construct(private StudentCourseService $courseService) {}

    // كل الكورسات المنشورة (ممكن تتفلتر بالقسم)
    public function index(?string $category = null)
    {
        $categories    = $this->courseService->categories();
        $courses       = $this->courseService->paginatePublished($category);
        $category_slug = $category;

        return view('students.courses.allCourses', compact('courses', 'categories', 'category_slug'));
    }

    // كورساتي (اللي اشتركت فيها)
    public function myCourses()
    {
        $courses = $this->courseService->myCourses(auth()->user());

        return view('students.courses.courses', compact('courses'));
    }

    // صفحة الكورس (middleware check_enrollment بيتأكد إنه مشترك)
    public function show(Course $course)
    {
        $data = $this->courseService->forPlayer($course);

        return view('students.courses.courseDetails', $data);
    }
}
