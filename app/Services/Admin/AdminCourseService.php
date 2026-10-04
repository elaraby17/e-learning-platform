<?php

namespace App\Services\Admin;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;

// الأدمن بيشوف كل الكورسات في المنصة
class AdminCourseService
{
    public function paginate(int $perPage = 10)
    {
        return Course::with(['instructor', 'category'])
            ->withCount('enrollments')
            ->latest()
            ->paginate($perPage);
    }

    public function delete(Course $course): void
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();
    }
}
