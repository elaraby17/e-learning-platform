<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\AdminUserService;

// الأدمن بيدير المستخدمين (طلاب - مدرسين)
class UserController extends Controller
{
    public function __construct(private AdminUserService $userService) {}

    public function index()
    {
        $users = $this->userService->paginate();

        return view('admins.users.index', compact('users'));
    }

    public function create()
    {
        return view('admins.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء حساب المستخدم بنجاح.');
    }

    public function edit(User $user)
    {
        return view('admins.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy(User $user)
    {
        // بنبعت المستخدم الحالي عشان نمنع الأدمن يحذف نفسه
        $this->userService->delete($user, auth()->user());

        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
