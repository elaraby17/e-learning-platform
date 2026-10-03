<?php
// app/Http/Controllers/CoursesController.php
namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use App\Services\CourseService;

class CoursesController extends Controller
{
    public function __construct(private CourseService $courseService) {}



    public function show(Course $course)
    {
        $course->load('sections.lessons');
        $lesson = $course->sections->flatMap->lessons->first();

        return view('students.courses.courseDetails', compact('course', 'lesson'));
    }

public function create()
{
    $this->authorize('create', Course::class);

    $categories = Category::all();

    $instructors = auth()->user()->role === 'admin'
        ? User::where('role', 'instructor')->get()
        : collect();

    return view(
        'instructor.courses.addCourse',
        compact('categories', 'instructors')
    );
}

    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $this->courseService->create($request->validated(), auth()->user());

        return redirect()->route('instructor.dashboard')->with('success', 'تم إنشاء الكورس بنجاح.');
    }

public function edit(Course $course)
{
    $this->authorize('update', $course);

    $categories = Category::all();

    $instructors = auth()->user()->role === 'admin'
        ? User::where('role', 'instructor')->get()
        : collect();

    return view(
        'instructor.courses.edit',
        compact('course', 'categories', 'instructors')
    );
}

    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $this->courseService->update($course, $request->validated(), auth()->user());

        return redirect()->route('instructor.dashboard')->with('success', 'تم تحديث الكورس بنجاح.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course);

        return redirect()->route('instructor.dashboard')->with('success', 'تم حذف الكورس بنجاح.');
    }
}
