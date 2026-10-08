<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Services\Instructor\InstructorSectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct(private InstructorSectionService $sectionService) {}

  public function create(Request $request)
{
    $user = auth()->user();

    // الكورسات تظهر فقط في الـ select
    $courses = $user->courses()
        ->select('courses.id', 'courses.title')
        ->get();

    // لا يوجد كورس مختار في البداية
    $selectedCourse = null;

    // لو المستخدم اختار كورس
    if ($request->filled('course')) {
        $selectedCourse = $user->courses()
            ->with(['sections.lessons'])
            ->where('courses.id', $request->course)
            ->firstOrFail();
    }

    return view('instructor.sections.addSection', [
        'courses' => $courses,
        'selectedCourse' => $selectedCourse,
    ]);
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'course_id'    => 'required|exists:courses,id',
            'order_number' => 'nullable|integer|min:1',
        ]);

        // لازم يكون صاحب الكورس (أو أدمن)
        $this->authorize('update', Course::findOrFail($data['course_id']));

        $this->sectionService->create($data);

        return redirect()->route('instructor.dashboard')->with('success', 'تم إضافة السيكشن بنجاح.');
    }

    public function destroy(Section $section)
    {
        $this->authorize('update', $section->course);

        $this->sectionService->delete($section);

        return back()->with('success', 'تم حذف السيكشن بنجاح.');
    }
}
