<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Services\Instructor\InstructorCourseService;

// المدرس بيدير كورساته (والأدمن يقدر يستخدم نفس الصفحات)
class CourseController extends Controller
{
    public function __construct(private InstructorCourseService $courseService) {}



    public function create()
    {
        $this->authorize('create', Course::class);

        return view('instructor.courses.addCourse', [
            'categories'  => $this->courseService->categories(),
            'instructors' => $this->courseService->instructorsFor(auth()->user()),
        ]);
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

        return view('instructor.courses.edit', [
            'course'      => $course,
            'categories'  => $this->courseService->categories(),
            'instructors' => $this->courseService->instructorsFor(auth()->user()),
        ]);
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
