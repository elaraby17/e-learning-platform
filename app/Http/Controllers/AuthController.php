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
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = Storage::disk('public')->put('profile', $file);
                $data['image'] = $path;
            }
            User::create($data);
            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();

                return redirect()->route('student.home')->with('success', 'Registered successfully.');
            }

            return back()->withErrors(['email' => 'Failed to register. Please try again.']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred during registration. Please try again.']);
        }
    }

    public function signin(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            $remember = $request->has('remember');

            if (Auth::attempt($data, $remember)) {
                $request->session()->regenerate();
                $user = Auth::user();
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!'),
                    'instructor' => redirect()->route('instructor.dashboard')->with('success', 'Welcome Instructor!'),
                    default => redirect()->route('student.home')->with('success', 'Logged in successfully.'),
                };
            }
            return back()->withErrors(['email' => 'Invalid credentials. Please try again.']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'An error occurred during login. Please try again.']);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->last_login_at = now();
                $user->save();
            }
            session()->flush();
            Auth::logout();
            return redirect()->route('auth.login')->with('success', 'Logged out successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred during logout. Please try again.']);
        }
    }
}

