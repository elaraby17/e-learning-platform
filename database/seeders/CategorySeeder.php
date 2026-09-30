<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Data Science',
            'Graphic Design',
            'Digital Marketing',
            'Cybersecurity',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => \Str::slug($category),
                'instructor_id' => 1
            ]);
        }
    }
}
