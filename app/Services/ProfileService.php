<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// تعديل البروفايل - مشترك بين كل الأدوار
class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        if (($data['image'] ?? null) instanceof UploadedFile) {
            // امسح الصورة القديمة قبل ما نرفع الجديدة
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $data['image']->store('profiles', 'public');
        } else {
            unset($data['image']);
        }

        $user->update($data);

        return $user;
    }

    public function updatePassword(User $user, string $password): void
    {
        // الـ cast 'hashed' في الـ User بيعمل hash لوحده
        $user->update(['password' => $password]);
    }
}
