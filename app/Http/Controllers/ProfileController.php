<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

// البروفايل نفس الشغل لكل الأدوار (تعديل الاسم والصورة وكلمة المرور)
// عشان كده عملناه مرة واحدة بدل ما نكرر الكود 3 مرات
class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService) {}

    public function show()
    {
        return view('profile.profile');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'bio'   => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->profileService->updateProfile($request->user(), $data);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $this->profileService->updatePassword($request->user(), $request->password);

        return back()->with('status', 'password-updated');
    }
}
