<?php

namespace App\Services\Instructor;

use App\Models\Section;
use App\Models\User;

class InstructorSectionService
{
    // كل سيكشنات المدرس (with('lessons') عشان منعملش query لكل سيكشن)
    public function forInstructor(User $instructor)
    {
        return Section::whereIn('course_id', $instructor->courses()->pluck('id'))
            ->with('lessons')
            ->orderBy('course_id')
            ->orderBy('order_number')
            ->get();
    }

    public function create(array $data): Section
    {
        // لو الترتيب مش متحدد، حطه آخر سيكشن في الكورس
        if (empty($data['order_number'])) {
            $data['order_number'] = (Section::where('course_id', $data['course_id'])->max('order_number') ?? 0) + 1;
        }

        return Section::create($data);
    }

    // الدروس بتتحذف لوحدها (cascade في الداتابيز)
    public function delete(Section $section): void
    {
        $section->delete();
    }
}
