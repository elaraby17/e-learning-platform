<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $courses = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the basics of web development, including HTML, CSS, and JavaScript.',
                'image' => 'https://example.com/images/web-development.jpg',
                'slug' => 'introduction-to-web-development',
                'short_description' => 'Learn the basics of web development.',
                'status' => 'published',
                'price' => '49.99',
                'category_id' => 1,
                'instructor_id' => 1,
            ],
            [
                'title' => 'Data Science with Python',
                'description' => 'Master data science techniques using Python, including data analysis and machine learning.',
                'image' => 'https://example.com/images/data-science.jpg',
                'slug' => 'data-science-with-python',
                'short_description' => 'Master data science techniques using Python.',
                'status' => 'published',
                'price' => '99.99',
                'category_id' => 2,
                'instructor_id' => 1,
            ],
            [
                'title' => 'Graphic Design Fundamentals',
                'description' => 'Learn the principles of graphic design and how to create stunning visuals.',
                'image' => 'https://example.com/images/graphic-design.jpg',
                'slug' => 'graphic-design-fundamentals',
                'short_description' => 'Learn the principles of graphic design.',
                'status' => 'published',
                'price' => '59.99',
                'category_id' => 3,
                'instructor_id' => 1,
            ],
            [
                'title' => 'Digital Marketing Strategies',
                'description' => 'Discover effective digital marketing strategies to grow your business online.',
                'image' => 'https://example.com/images/digital-marketing.jpg',
                'slug' => 'digital-marketing-strategies',
                'short_description' => 'Discover effective digital marketing strategies.',
                'status' => 'published',
                'price' => '79.99',
                'category_id' => 4,
                'instructor_id' => 1,
            ],
            [
                'title' => 'Cybersecurity Essentials',
                'description' => 'Learn the fundamentals of cybersecurity and how to protect your digital assets.',
                'image' => 'https://example.com/images/cybersecurity.jpg',
                'slug' => 'cybersecurity-essentials',
                'short_description' => 'Learn the fundamentals of cybersecurity.',
                'status' => 'published',
                'price' => '89.99',
                'category_id' => 5,
                'instructor_id' => 1,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }

    }
}
