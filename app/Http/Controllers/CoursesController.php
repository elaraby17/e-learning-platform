<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CoursesController extends Controller
{
    // public function index()
    // {
    //     return view('courses.index');
    // }

    // public function show($id)
    // {
    //     return view('courses.show', ['courseId' => $id]);
    // }

    public function create()
    {
        $categories = Category::all(); // Assuming you have a Category model
        $instructors = User::where('role', 'instructor')->get(); // Assuming you have a User model with a role field

        return view('instructor.courses.addCourse', compact('categories', 'instructors'));
    }

    public function store(CourseRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        // Handle image upload if an image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('course_images', 'public');
            $data['image'] = $imagePath;
        }

        Course::create($data);

        return redirect()->route('instructor.dashboard')->with('success', 'Course created successfully.');

    }


        public function edit(Course $course)
        {
            $categories = Category::all();
            $instructors = User::where('role', 'instructor')->get();

            return view('instructor.courses.edit', compact('course', 'categories', 'instructors'));
        }

        public function update(CourseRequest $request, Course $course)
        {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('course_images', 'public');
                $data['image'] = $imagePath;
            }

            $course->update($data);

            return redirect()->route('instructor.dashboard')->with('success', 'Course updated successfully.');
        }

        public function destroy(Course $course)
        {
            $course->delete();

            return redirect()->route('instructor.dashboard')->with('success', 'Course deleted successfully.');
        }
}
