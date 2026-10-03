<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Mohamed Elaraby',
                'email' => 'arab@arab.com',
                'phone' => '01069880640',
                'bio' => 'i am a web developer',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
                'gender' => 'male',
                'role' => 'student',
                'status' => 'active',
                'password' => Hash::make('3302856777'),
            ],
            [
                'name' => 'Mohamed essam',
                'email' => 'essam@arab.com',
                'phone' => '01069880641',
                'bio' => 'i am a backend developer',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
                'gender'=> 'male',
                'role' => 'instructor',
                'status'=> 'active',
                'password'=> Hash::make('3302856777'),
            ],
            [
                'name' => 'Mohamed mohamed',
                'email' => 'mohamed@arab.com',
                'phone' => '01069880642',
                'bio' => 'i am a frontend developer',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
                'gender' => 'male',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('3302856777'),
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
