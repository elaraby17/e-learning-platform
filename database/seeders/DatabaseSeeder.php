<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mohamed Elaraby',
            'email' => 'arab@arab.com',
            'phone' => '01069880640',
            'image' => 'https://avatars.githubusercontent.com/u/3302856777?v=4',
            'bio' => 'I am a full stack developer with experience in Laravel and Vue.js. I have a passion for creating beautiful and functional web applications.',
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' => Hash::make(3302856777),
        ]);

        $this->call([
                CategorySeeder::class,
                CourseSeeder::class,
            ]);
    }
}
