<?php

namespace App\Services\Student;

use App\Models\Category;
use App\Models\Course;

// كل اللي الطالب بيشوفه من الكورسات
class StudentCourseService
{
    // الأقسام اللي فيها كورسات منشورة بس
    public function categories()
    {
        return Category::whereHas('courses', fn ($q) => $q->where('status', 'published'))->get();
    }

    public function paginatePublished(?string $categorySlug = null, int $perPage = 10)
    {
        return Course::with(['instructor', 'category'])
            ->where('status', 'published')
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', fn ($c) => $c->where('slug', $categorySlug));
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    // الكورسات اللي الطالب مشترك فيها
    public function myCourses($student, int $perPage = 10)
    {
        return Course::whereHas('enrollments', fn ($q) => $q->where('student_id', $student->id))
            ->with(['instructor', 'category'])
            ->paginate($perPage);
    }

    // بيانات صفحة المشغل: الكورس بسيكشناته ودروسه + أول درس
    public function forPlayer(Course $course): array
    {
        $course->load(['sections.lessons', 'instructor']);

        return [
            'course' => $course,
            'lesson' => $course->sections->flatMap->lessons->first(),
        ];
    }
}
