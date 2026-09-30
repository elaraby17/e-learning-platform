<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
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


    if (!empty($validated['video_url'])) {
        $url = $validated['video_url'];


        if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[2];
            $validated['video_url'] = "https://www.youtube.com/embed/" . $videoId;
        }
    }

    $validated['is_free_preview'] = $request->has('is_free_preview');

    if (!$request->filled('order_number')) {
        $validated['order_number'] = Lesson::where('section_id', $request->section_id)->max('order_number') + 1;
    }

    Lesson::create($validated);

    return redirect()->route('instructor.dashboard')->with('success', 'تم إضافة الدرس بنجاح.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
