<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\Request;

class CoursesController extends Controller
{
    // public function index()
    // {
    //     return view('courses.index');
    // }

    public function show(Course $course)
    {

        $course->load(['sections.lessons' => function ($q) {
            $q->orderBy('order_number');
        }]);

        $lesson = $course->sections
            ->flatMap->lessons
            ->sortBy('order_number')
            ->first();

        return view('students.courses.courseDetails', compact('course', 'lesson'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'type' => 'required|in:video,article,quiz',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
            'video_duration' => 'nullable|integer|min:0',
            'is_free_preview' => 'boolean',
            'order_number' => 'nullable|integer|min:1',
        ]);

        if (! empty($validated['video_url'])) {
            $url = $validated['video_url'];
            if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
                $validated['video_url'] = 'https://www.youtube.com/embed/'.$matches[2];
            }
        }

        $validated['is_free_preview'] = $request->has('is_free_preview');

        if (! $request->filled('order_number')) {
            $validated['order_number'] = Lesson::where('section_id', $request->section_id)
                ->max('order_number') + 1;
        }

        try {
            Lesson::create($validated);

            return redirect()
                ->route('instructor.sections.index')        // ← غيّره للـ route المناسب
                ->with('success', 'تم إضافة الدرس "'.$validated['title'].'" بنجاح!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء حفظ الدرس، يرجى المحاولة مرة أخرى.');
        }
    }

    public function destroy(Section $section)
    {
        try {
            $title = $section->title;
            $section->delete(); // cascadeOnDelete يحذف الدروس تلقائياً

            return redirect()
                ->route('instructor.sections.index')
                ->with('success', 'تم حذف السيكشن "'.$title.'" وجميع دروسه بنجاح.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء الحذف، يرجى المحاولة مرة أخرى.');
        }
    }
}
