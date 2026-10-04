<?php

namespace App\Services;

use App\Exceptions\AccountDisabledException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidRoleException;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

// منطق التسجيل وتسجيل الدخول - مشترك بين كل الأدوار
class AuthService
{
    // التسجيل من الموقع دايماً بيعمل طالب (مفيش حد يسجل نفسه أدمن)
    public function register(array $data): User
    {
        $data['role'] = 'student';

        if (($data['image'] ?? null) instanceof UploadedFile) {
            $data['image'] = $data['image']->store('profiles', 'public');
        } else {
            unset($data['image']);
        }

        return User::create($data);
    }

    public function authenticate(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        // الحساب المعطل ميدخلش
        if ($user->status !== 'active') {
            throw new AccountDisabledException();
        }

        if (! in_array($user->role, ['admin', 'instructor', 'student'], true)) {
            throw new InvalidRoleException();
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return $user;
    }
}
