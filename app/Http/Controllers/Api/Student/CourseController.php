<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\Student\StudentCourseService;
use App\Services\Student\StudentEnrollmentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

// كورسات الطالب في الـ API: تصفح - تفاصيل - اشتراك - كورساتي - محتوى الكورس
class CourseController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private StudentCourseService $courseService,
        private StudentEnrollmentService $enrollmentService,
    ) {}

    // GET /api/courses?category=php  ← كل الكورسات المنشورة (والفلتر بالقسم اختياري)
    public function index(Request $request)
    {
        $courses = $this->courseService->paginatePublished($request->query('category'));

        return $this->success($courses, 'Courses retrieved successfully');
    }

    // GET /api/courses/{course}  ← تفاصيل كورس منشور
    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            return $this->error('Course not found', 404);
        }

        $course->load(['instructor', 'category']);

        return $this->success($course, 'Course retrieved successfully');
    }

    // POST /api/courses/{course}/enroll  ← اشتراك
    public function enroll(Request $request, Course $course)
    {
        // لو الكورس مش منشور أو مشترك قبل كده، الـ Service بترمي Exception
        // والـ handler في bootstrap/app.php بيحوله لـ JSON لوحده
        $this->enrollmentService->enroll($request->user(), $course);

        return $this->success(null, 'Enrolled successfully', 201);
    }

    // GET /api/student/courses  ← كورساتي
    public function myCourses(Request $request)
    {
        $courses = $this->courseService->myCourses($request->user());

        return $this->success($courses, 'My courses retrieved successfully');
    }

    // GET /api/student/courses/{course}  ← محتوى الكورس (لازم يكون مشترك)
    public function content(Request $request, Course $course)
    {
        if (! $this->enrollmentService->isEnrolled($request->user(), $course)) {
            return $this->error('You are not enrolled in this course', 403);
        }

        $data = $this->courseService->forPlayer($course);

        return $this->success([
            'course'       => $data['course'],  // الكورس بسيكشناته ودروسه
            'first_lesson' => $data['lesson'],
        ], 'Course content retrieved successfully');
    }
}
