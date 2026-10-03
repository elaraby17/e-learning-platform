<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct(
        private EnrollmentService $enrollments,
        private CourseService $courseService,
        private ProfileService $profileService,
    ) {}

    public function index()
    {
        $coursesEnrolled = $this->enrollments->userEnrollments(auth()->user());
        $enrolled_count = $coursesEnrolled->count();

        return view('students.home', compact('enrolled_count', 'coursesEnrolled'));
    }

    public function show()
    {
        return view('profile.profile');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'bio'   => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->profileService->updateProfile(auth()->user(), $data);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $this->profileService->updatePassword(auth()->user(), $request->password);

        return back()->with('status', 'password-updated');
    }

    public function allCourses(?string $category = null)
    {
        $categories = $this->courseService->publishedCategories();
        $courses = $this->courseService->paginatePublished($category);
        $category_slug = $category;

        return view('students.courses.allCourses', compact('courses', 'categories', 'category_slug'));
    }

    public function courses()
    {
        $courses = $this->enrollments->userCourses(auth()->user());

        return view('students.courses.courses', compact('courses'));
    }

    public function store(Course $course)
    {
        $this->enrollments->enroll(auth()->user(), $course);

        return redirect()->route('courses')->with('success', 'تم الاشتراك بنجاح');
    }

    public function courseDetails(Course $course)
    {
        $enrollment = $this->enrollments->getEnrollmentOrFail(auth()->user(), $course);

        $course->load(['sections.lessons', 'instructor']);

        return view('students.courses.courseDetails', compact('course', 'enrollment'));
    }
}
