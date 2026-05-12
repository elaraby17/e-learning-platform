<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('students.home');
    }

    public function show()
    {
        return view('profile.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('profile', 'public');

            $validatedData['image'] = $path;
        }

        $user->update($validatedData);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
{
    $user = auth()->user();


    $request->validate([
        'current_password' => 'required|current_password',
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('status', 'password-updated');
}
}
