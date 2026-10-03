<?php
// app/Http/Controllers/SectionController.php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct(private SectionService $sections) {}

    public function create()
    {
        $courses = auth()->user()->courses()->get();
        $sections = $this->sections->forInstructor(auth()->user());

        return view('instructor.sections.addSection', compact('courses', 'sections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'course_id'    => 'required|exists:courses,id',
            'order_number' => 'nullable|integer|min:1',
        ]);

        $this->authorize('update', Course::findOrFail($data['course_id']));

        $this->sections->create($data);

        return redirect()->route('instructor.dashboard')->with('success', 'تم إضافة السيكشن بنجاح.');
    }
}
