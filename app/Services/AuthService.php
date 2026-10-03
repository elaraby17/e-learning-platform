<?php
// app/Services/AuthService.php
namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\InvalidRoleException;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  // app/Services/AuthService.php
public function register(array $data): User
{
    $data['role'] = 'student';

    if (($data['image'] ?? null) instanceof UploadedFile) {
        $data['image'] = $data['image']->store('profiles', 'public');
    } else {
        unset($data['image']);
    }

    return User::create($data); // من غير Auth::login
}

public function authenticate(string $email, string $password): User
{
    $user = User::where('email', $email)->first();

    if (! $user || ! Hash::check($password, $user->password)) {
        throw new InvalidCredentialsException();
    }

    if (! in_array($user->role, ['admin', 'instructor', 'student'], true)) {
        throw new InvalidRoleException();
    }

    $user->forceFill(['last_login_at' => now()])->save();

    return $user;
}

}
