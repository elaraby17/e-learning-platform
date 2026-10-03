<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{


public function __construct(private UserService $userService) {}

public function index()
{
    $users = $this->userService->getAllUsers();

    return view('admins.users.index', compact('users'));
}

public function create()
{
    return view('admins.users.create');
}

public function edit(User $user)
{
    return view('admins.users.edit', compact('user'));
}


public function store(StoreUserRequest $request)
{
    $this->userService->createUser($request);

    return redirect()->route('admin.users.index')->with('success', 'تم إنشاء حساب المستخدم بنجاح.');
}

public function update(UpdateUserRequest $request, User $user)
{
    $this->userService->updateUser($request, $user);

    return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
}

public function destroy(User $user)
{
    $this->userService->deleteUser($user);

    return back()->with('status', 'user-deleted');
}
}
