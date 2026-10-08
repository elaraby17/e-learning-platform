<?php

namespace App\Services\Instructor;

use App\Models\Section;
use App\Models\User;

class InstructorSectionService
{

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

        if (empty($data['order_number'])) {
            $data['order_number'] = (Section::where('course_id', $data['course_id'])->max('order_number') ?? 0) + 1;
        }

        return Section::create($data);
    }

    public function update(Section $section, array $data): Section
    {
        $section->update($data);

        return $section;
    }

   
    public function delete(Section $section): void
    {
        $section->delete();
    }
}
