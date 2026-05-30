@extends('layouts.master')

@section('title', 'تعديل المستخدم')
@section('content')

<div class="p-6 min-h-screen bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-2">
                <span>الرئيسية</span>
                <svg class="w-3 h-3 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span>المستخدمين</span>
                <svg class="w-3 h-3 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-indigo-600 dark:text-indigo-400">تعديل مستخدم</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                تعديل المستخدم: <span class="text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span>
            </h1>
        </div>
    </div>

    <div class="bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden max-w-5xl">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-bold border-b border-gray-100 dark:border-gray-800 pb-3 text-gray-700 dark:text-gray-300">تعديل بيانات مستخدم</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                <div class="flex flex-col items-center justify-center p-4">
                    <div class="relative group cursor-pointer">
                        <div class="w-40 h-40 rounded-full border-4 border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @endif
                        </div>
                        <label for="image-upload" class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer text-white text-xs font-medium">
                            تغيير الصورة
                        </label>
                        <input type="file" id="image-upload" name="image" class="hidden" accept="image/*">
                    </div>
                    @error('image') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror

                    <div class="w-full mt-6">
                        <label for="bio" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">النبذة التعريفية (Bio)</label>
                        <textarea name="bio" id="bio" rows="3" placeholder="نبذة مختصرة..." class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-sm resize-none">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div>
                        <h3 class="text-sm font-bold text-indigo-500 uppercase tracking-wider mb-4">البيانات الأساسية</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">الاسم الكامل</label>
                                <div class="relative">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                </div>
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">رقم الهاتف</label>
                                <div class="relative">
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                </div>
                                @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">البريد الإلكتروني</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full pr-10 pl-24 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-xs font-medium text-emerald-500 flex items-center gap-1">
                                            verified
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                    </div>
                                </div>
                                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-indigo-500 uppercase tracking-wider mb-4">الصلاحيات وحالة الحساب</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">الحالة</label>
                                <select name="status" id="status" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">الجنس</label>
                                <div class="flex items-center gap-6 h-11 bg-gray-50 dark:bg-[#151f32] px-4 rounded-lg border border-gray-300 dark:border-gray-700">
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                        <input type="radio" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <span>ذكر</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                        <input type="radio" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <span>أنثى</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-indigo-500 uppercase tracking-wider mb-4">تغيير كلمة المرور</h3>

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">

                            <div>
                                <label for="password" class="block text-xs font-semibold mb-2 text-gray-500 dark:text-gray-400">كلمة المرور الجديدة</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="كلمة مرور جديدة" class="w-full pr-4 pl-10 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left" />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 cursor-pointer hover:text-gray-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </div>
                                </div>
                                @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pt-6 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-gray-800">
                <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 rounded-xl transition-colors">
                    إلغاء
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-md transition-colors">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
