<?php

namespace App\Services\Admin;

use App\Exceptions\CannotDeleteSelfException;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// الأدمن بيدير المستخدمين
// ملاحظة: الـ Service بتاخد array عادي (مش Request) عشان تفضل بسيطة وتتجرب لوحدها
class AdminUserService
{
    public function paginate(int $perPage = 10)
    {
        return User::whereIn('role', ['student', 'instructor'])
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        $data['image'] = $this->saveImage($data['image'] ?? null);

        // مفيش Hash::make هنا: الـ User model فيه cast 'hashed' بيعملها لوحده
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        // لو رفع صورة جديدة امسح القديمة
        if (($data['image'] ?? null) instanceof UploadedFile) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $this->saveImage($data['image']);
        } else {
            unset($data['image']);
        }

        // لو كلمة المرور فاضية متغيرهاش
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function delete(User $user, User $actor): void
    {
        if ($user->id === $actor->id) {
            throw new CannotDeleteSelfException();
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
    }

    private function saveImage($image): ?string
    {
        return $image instanceof UploadedFile
            ? $image->store('profiles', 'public')
            : null;
    }
}
