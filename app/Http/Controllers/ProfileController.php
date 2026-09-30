<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $enrolled_count = auth()->user()->enrollments()->with('course')->get()->count();

        $coursesEnrolled = auth()->user()->enrollments()->with('course')->get();

        return view('students.home', compact('enrolled_count', 'coursesEnrolled'));
    }

    public function show()
    {
        return view('profile.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('profile', 'public');

            $validatedData['image'] = $path;
        }

        $user->update($validatedData);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function allCourses($category_slug = null)
    {
        $user = auth()->user();

        // جلب الأقسام التي تمتلك كورسات منشورة فقط (بإمكانك جلبها جميعا إذا أردت Category::all())
        $categoryIds = Course::where('status', 'published')->pluck('category_id')->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();

        // تجهيز استعلام الكورسات
        $query = Course::with(['instructor', 'category'])->where('status', 'published');

        // تصفية الكورسات إذا تم اختيار قسم
        if ($category_slug = request()->route('category')) {
            $category = Category::where('slug', $category_slug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $courses = $query->paginate(10);

        return view('students.courses.allCourses', compact('courses', 'categories', 'category_slug'));
    }

    public function courses()
    {
        $user = auth()->user();
        $courses = Course::whereHas('enrollments', function ($query) use ($user) {
            $query->where('student_id', $user->id);
        })->with(['instructor', 'category'])->paginate(10);

        return view('students.courses.courses', compact('courses'));
    }

    public function store(Course $course)
    {
        try {
            $user = auth()->user();
            $exists = Enrollment::where('student_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();

            if ($exists) {
                return back()->with('error', 'أنت مشترك بالفعل');
            }

            Enrollment::create([
                'student_id' => $user->id,
                'course_id' => $course->id,
                'progress_percentage' => 0,
                'status' => 'active',
                'enrolled_at' => now(),
            ]);

            return redirect()->route('courses')->with('success', 'تم الاشتراك بنجاح');
        } catch (\Throwable $th) {
            Log::info('Error enrolling in course: '.$th->getMessage());
        }
    }

    public function courseDetails(Course $course)
    {
        try {
            $course = Course::with(

            )->findOrFail($id);

            if (! $enrollment) {
                return back()->with('error', 'أنت غير مشترك في هذا الكورس');
            }

            return view('students.courses.courseDetails', compact('course', 'enrollment'));
        } catch (\Throwable $th) {
            Log::info('Error fetching course details: '.$th->getMessage());
        }
    }
}
