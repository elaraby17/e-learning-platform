<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = [
            [
                'student_id' => 1,
                'course_id' => 1,
                'enrolled_at' => now(),
                'status' => 'active',
            ],
            [
                'student_id' => 2,
                'course_id' => 2,
                'enrolled_at' => now(),
                'status' => 'active',
            ],
            [
                'student_id' => 3,
                'course_id' => 3,
                'enrolled_at' => now(),
                'status' => 'active',
            ],
        ];

        foreach ($enrollments as $enrollment) {
            Enrollment::create($enrollment);
        }
    }
}
