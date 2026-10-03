<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [

            // Section 1
            [
                'section_id' => 1,
                'title' => 'Introduction to HTML',
                'type' => 'video',
                'content' => 'In this lesson, you will learn what HTML is, how web pages are structured, and the role of HTML in web development.',
                'video_url' => 'https://www.youtube.com/watch?v=qz0aGYrrlhU',
                'video_duration' => 600,
                'video_thumbnail' => null,
                'is_free_preview' => true,
                'order_number' => 1,
            ],

            [
                'section_id' => 1,
                'title' => 'HTML Document Structure',
                'type' => 'article',
                'content' => '
                    <h2>HTML Document Structure</h2>

                    <p>
                        Every HTML document has a basic structure that tells the browser
                        how to interpret the page.
                    </p>

                    <h3>Basic Structure</h3>

                    <pre>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;My Website&lt;/title&gt;
&lt;/head&gt;

&lt;body&gt;
    &lt;h1&gt;Hello World&lt;/h1&gt;
&lt;/body&gt;

&lt;/html&gt;
                    </pre>

                    <p>
                        The head contains information about the document, while the body
                        contains the visible content.
                    </p>
                ',
                'video_url' => null,
                'video_duration' => null,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 2,
            ],

            [
                'section_id' => 1,
                'title' => 'HTML Forms',
                'type' => 'video',
                'content' => 'Learn how to create forms using input fields, labels, buttons, and form elements.',
                'video_url' => 'https://www.youtube.com/watch?v=fNcJuPIZ2WE',
                'video_duration' => 720,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 3,
            ],

            // Section 2
            [
                'section_id' => 2,
                'title' => 'Introduction to CSS',
                'type' => 'video',
                'content' => 'Learn how CSS works and how it is used to style HTML elements.',
                'video_url' => 'https://www.youtube.com/watch?v=1Rs2ND1ryYc',
                'video_duration' => 780,
                'video_thumbnail' => null,
                'is_free_preview' => true,
                'order_number' => 1,
            ],

            [
                'section_id' => 2,
                'title' => 'Selectors and Properties',
                'type' => 'article',
                'content' => '
                    <h2>CSS Selectors</h2>

                    <p>
                        CSS selectors are used to select HTML elements that you want
                        to style.
                    </p>

                    <h3>Example</h3>

                    <pre>
.title {
    font-size: 32px;
    font-weight: bold;
}

.button {
    padding: 12px 20px;
    border-radius: 8px;
}
                    </pre>
                ',
                'video_url' => null,
                'video_duration' => null,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 2,
            ],

            [
                'section_id' => 2,
                'title' => 'Flexbox Layout',
                'type' => 'video',
                'content' => 'Learn how to build flexible layouts using CSS Flexbox.',
                'video_url' => 'https://www.youtube.com/watch?v=fYq5PXgSsbE',
                'video_duration' => 900,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 3,
            ],

            // Section 3
            [
                'section_id' => 3,
                'title' => 'Introduction to JavaScript',
                'type' => 'video',
                'content' => 'Learn the basics of JavaScript and how it adds interactivity to web pages.',
                'video_url' => 'https://www.youtube.com/watch?v=W6NZfCO5SIk',
                'video_duration' => 1200,
                'video_thumbnail' => null,
                'is_free_preview' => true,
                'order_number' => 1,
            ],

            [
                'section_id' => 3,
                'title' => 'Variables and Data Types',
                'type' => 'article',
                'content' => '
                    <h2>JavaScript Variables</h2>

                    <p>
                        Variables allow you to store and work with data inside your program.
                    </p>

                    <pre>
let name = "Ahmed";
let age = 22;
let isStudent = true;
                    </pre>

                    <p>
                        JavaScript supports different data types including strings,
                        numbers, booleans, objects, arrays, null and undefined.
                    </p>
                ',
                'video_url' => null,
                'video_duration' => null,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 2,
            ],

            [
                'section_id' => 3,
                'title' => 'Functions in JavaScript',
                'type' => 'video',
                'content' => 'Learn how to create reusable functions and pass parameters and return values.',
                'video_url' => 'https://www.youtube.com/watch?v=N8ap4k_1QEQ',
                'video_duration' => 1000,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 3,
            ],

            // Section 4
            [
                'section_id' => 4,
                'title' => 'Understanding the DOM',
                'type' => 'video',
                'content' => 'Learn how JavaScript interacts with HTML through the Document Object Model.',
                'video_url' => 'https://www.youtube.com/watch?v=5fb2aPlgoys',
                'video_duration' => 1100,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 1,
            ],

            [
                'section_id' => 4,
                'title' => 'Selecting HTML Elements',
                'type' => 'article',
                'content' => '
                    <h2>Selecting Elements</h2>

                    <p>
                        JavaScript provides several methods for selecting elements
                        from the page.
                    </p>

                    <pre>
const title = document.querySelector("h1");

const buttons = document.querySelectorAll("button");
                    </pre>
                ',
                'video_url' => null,
                'video_duration' => null,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 2,
            ],

            // Section 5
            [
                'section_id' => 5,
                'title' => 'Building the Final Project',
                'type' => 'video',
                'content' => 'Build a complete responsive website using HTML, CSS, and JavaScript.',
                'video_url' => 'https://www.youtube.com/watch?v=3PHXvlpOkf4',
                'video_duration' => 1800,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 1,
            ],

            [
                'section_id' => 5,
                'title' => 'Project Requirements',
                'type' => 'article',
                'content' => '
                    <h2>Final Project</h2>

                    <p>
                        Create a responsive website containing:
                    </p>

                    <ul>
                        <li>Responsive navigation</li>
                        <li>Hero section</li>
                        <li>Products or services section</li>
                        <li>Contact form</li>
                        <li>Responsive mobile layout</li>
                        <li>JavaScript interactions</li>
                    </ul>
                ',
                'video_url' => null,
                'video_duration' => null,
                'video_thumbnail' => null,
                'is_free_preview' => false,
                'order_number' => 2,
            ],

        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
