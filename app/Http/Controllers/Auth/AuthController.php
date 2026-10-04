<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// تسجيل الدخول والخروج والتسجيل - مشترك بين كل الأدوار
class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

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
        $user = $this->authService->register($request->validated());

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('student.home')->with('success', 'تم التسجيل بنجاح.');
    }

    public function signin(LoginRequest $request)
    {
        $data = $request->validated();

        try {
            $user = $this->authService->authenticate($data['email'], $data['password']);
        } catch (BusinessException $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput($request->only('email'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // كل دور يروح للوحته
        $route = match ($user->role) {
            'admin'      => 'admin.dashboard',
            'instructor' => 'instructor.dashboard',
            default      => 'student.home',
        };

        return redirect()->route($route)->with('success', 'تم تسجيل الدخول بنجاح.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'تم تسجيل الخروج.');
    }
}
