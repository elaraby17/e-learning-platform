@extends('layouts.master')

@section('title', 'إنشاء مستخدم جديد')
@section('content')
<div class="p-6 min-h-screen bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">إضافة مستخدم جديد</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إنشاء حساب جديد وتعيين الصلاحيات الخاصة به في المنصة.</p>
        </div>
        <div>
            <a href="#" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                إلغاء والعودة
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <h2 class="text-lg font-semibold">الصورة الشخصية والوظيفة</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ارفع صورة المستخدم وحدد النبذة التعريفية الخاصة به (Bio).</p>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">الصورة الشخصية</label>
                        <div class="mt-1 flex items-center gap-4">
                            <div class="h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-indigo-950/40 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-950/60 transition-colors" />
                        </div>
                        @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium mb-2">النبذة التعريفية (Bio)</label>
                        <textarea name="bio" id="bio" rows="3" placeholder="اكتب نبذة مختصرة عن المستخدم أو المدرس..." class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors resize-none">{{ old('bio') }}</textarea>
                        @error('bio') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-gray-800" />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <h2 class="text-lg font-semibold">البيانات الأساسية</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">المعلومات الشخصية التي سيتم استخدامها للتواصل والتعريف بالفرد.</p>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="محمد العربي" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" />
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="example@domain.com" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium mb-2">رقم الهاتف <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="01xxxxxxxxx" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium mb-2">الجنس</label>
                        <select name="gender" id="gender" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                            <option value="" disabled selected>اختر الجنس</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>أخرى</option>
                        </select>
                        @error('gender') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-gray-800" />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <h2 class="text-lg font-semibold">الصلاحيات والأمان</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">تحديد مستوى الوصول للنظام وإنشاء كلمة مرور قوية.</p>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="block text-sm font-medium mb-2">الصلاحية (Role) <span class="text-red-500">*</span></label>
                        <select name="role" id="role" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>طالب (User)</option>
                            <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>مدرس (Instructor)</option>
                            <option value="admin" {{ old('role', 'admin') == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">حالة الحساب <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط (Active)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط (Inactive)</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2">كلمة المرور <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left" />
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium mb-2">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left" />
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-lg shadow-sm transition-colors">
                    حفظ الحساب الجديد
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
