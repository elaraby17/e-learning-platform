<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getAllUsers()
    {
        return User::where('role', 'user')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function createUser($request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $validatedData['image'] = $path;
        }
        $validatedData['password'] = Hash::make($request->password);

        return User::create($validatedData);
    }

    public function updateUser($request, $user)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('users', 'public');
            $validatedData['image'] = $path;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        return $user->update($validatedData);
    }
}
