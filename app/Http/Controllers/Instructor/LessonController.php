<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use App\Services\Instructor\InstructorLessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(private InstructorLessonService $lessonService) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'section_id'     => 'required|exists:sections,id',
            'type'           => 'required|in:video,article,quiz',
            'content'        => 'required_if:type,article|nullable|string',
            'video_url'      => 'required_if:type,video|nullable|url|max:255',
            'video_duration' => 'nullable|integer|min:0',
            'order_number'   => 'nullable|integer|min:1',
        ]);

        $section = Section::with('course')->findOrFail($data['section_id']);
        $this->authorize('update', $section->course);

        $data['is_free_preview'] = $request->boolean('is_free_preview');

        $this->lessonService->create($data);

        return redirect()->route('instructor.dashboard')->with('success', 'تم إضافة الدرس بنجاح.');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorize('update', $lesson->section->course);

        $this->lessonService->delete($lesson);

        return back()->with('success', 'تم حذف الدرس بنجاح.');
    }
}
