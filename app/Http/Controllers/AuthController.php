<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        return view('students.auth.login');
    }

    public function register()
    {
        return view('students.auth.register');
    }

    public function signup(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->put('profile', $file);
            $data['image'] = $path;
        }
        User::create($data);

        return Auth::attempt($request->only('email', 'password')) ? redirect()->route('student.home')->with('success', 'Registered successfully.') : back()->withErrors(['email' => 'Failed to register. Please try again.']);
    }

public function signin(LoginRequest $request)
{
    $data = $request->validated();
    $remember = $request->has('remember');

    if (Auth::attempt($data, $remember)) {
        $request->session()->regenerate();
        $user = Auth::user();
        return match ($user->role) {
            'admin'      => redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!'),
            'instructor' => redirect()->route('instructor.dashboard')->with('success', 'Welcome Instructor!'),
            default      => redirect()->route('student.home')->with('success', 'Logged in successfully.'),
        };
    }
    return back()->withErrors(['email' => 'Invalid email or password. Please try again.']);
}

    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login')->with('success', 'Logged out successfully.');
    }
}
