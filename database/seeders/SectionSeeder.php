<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'title' => 'HTML Fundamentals',
                'course_id' => 1,
            ],
            [
                'title' => 'CSS Fundamentals',
                'course_id' => 1,
            ],
            [
                'title' => 'JavaScript Basics',
                'course_id' => 1,
            ],
            [
                'title' => 'DOM Manipulation',
                'course_id' => 1,
            ],
            [
                'title' => 'Final Project',
                'course_id' => 1,
            ],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
