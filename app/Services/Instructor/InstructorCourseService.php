<?php

namespace App\Services\Instructor;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// المدرس بيدير كورساته (الأدمن بيستخدمها كمان)
class InstructorCourseService
{
    public function categories()
    {
        return Category::all();
    }

    // قايمة المدربين اللي تظهر في الفورم:
    // الأدمن يختار أي مدرس - المدرس يشوف نفسه بس
    public function instructorsFor(User $actor)
    {
        if ($actor->role === 'admin') {
            return User::where('role', 'instructor')->get()->push($actor);
        }

        return collect([$actor]);
    }

    public function create(array $data, User $actor): Course
    {
        $data = $this->handleImage($data);

        // الأدمن يقدر يختار المدرس، المدرس دايماً الكورس بتاعه
        $data['instructor_id'] = $actor->role === 'admin'
            ? ($data['instructor_id'] ?? $actor->id)
            : $actor->id;

        return Course::create($data);
    }

    public function update(Course $course, array $data, User $actor): Course
    {
        $data = $this->handleImage($data, $course->image);

        // المدرس مينفعش يغير صاحب الكورس
        if ($actor->role !== 'admin') {
            unset($data['instructor_id']);
        }

        $course->update($data);

        return $course;
    }

    public function delete(Course $course): void
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();
    }

    // رفع الصورة: لو في صورة جديدة نمسح القديمة ونحفظ الجديدة، غير كده نسيب القديمة
    private function handleImage(array $data, ?string $oldPath = null): array
    {
        if (($data['image'] ?? null) instanceof UploadedFile) {
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['image'] = $data['image']->store('course_images', 'public');
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
