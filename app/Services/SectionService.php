<?php
// app/Services/SectionService.php
namespace App\Services;

use App\Models\Section;
use App\Models\User;

class SectionService
{
    public function forInstructor(User $instructor)
    {
        return Section::whereIn('course_id', $instructor->courses()->pluck('id'))->get();
    }

    public function create(array $data): Section
    {
        $data['order_number'] ??= (Section::where('course_id', $data['course_id'])->max('order_number') ?? 0) + 1;

        return Section::create($data);
    }
}
