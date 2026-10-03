<?php

namespace Database\Seeders;


use Database\Seeders\CategorySeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\EnrollmentSeeder;
use Database\Seeders\LessonSeeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            SectionSeeder::class,
            LessonSeeder::class,
        ]);
    }
}
