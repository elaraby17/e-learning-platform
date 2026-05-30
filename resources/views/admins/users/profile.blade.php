@extends('layouts.master')

@section('title', 'الملف الشخصي')
@section('content')

    <div
        class="p-6 min-h-screen bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 transition-colors duration-300">

        <div class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                الملف الشخصي والحساب
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة معلوماتك الشخصية، تعديل الأمان، ومتابعة
                الاشتراكات النشطة.</p>
        </div>

        <x-success-component />


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start max-w-7xl">

            <div class="space-y-6 lg:col-span-1">

                <div
                    class="bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm text-center">
                    <div
                        class="relative w-32 h-32 mx-auto rounded-full border-4 border-indigo-500/20 overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                        @if ($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="User Image"
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold mt-4">{{ $user->name }}</h2>

                    <span
                        class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-400">
                        @if ($user->role == 'admin')
                            مدير النظام
                        @elseif($user->role == 'instructor')
                            مدرس
                        @else
                            طالب
                        @endif
                    </span>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4 text-center px-2 line-clamp-3">
                        {{ $user->bio ?? 'لا توجد نبذة تعريفية مكتوبة حالياً.' }}
                    </p>

                    <div
                        class="border-t border-gray-100 dark:border-gray-800 mt-6 pt-4 text-right space-y-2 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex justify-between"><span>حالة الحساب:</span> <span
                                class="font-bold text-emerald-500">نشط</span></div>
                        <div class="flex justify-between"><span>تاريخ الإنضمام:</span> <span
                                class="dir-ltr">{{ $user->created_at->format('Y-m-d') }}</span></div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-md font-bold mb-4 flex items-center gap-2 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        الاشتراكات والكورسات النشطة
                    </h3>

                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                        @if (isset($user->courses) && $user->courses->count() > 0)
                            @foreach ($user->courses as $course)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-[#151f32] rounded-xl border border-gray-100 dark:border-gray-800">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 line-clamp-1">
                                            {{ $course->title }}</h4>
                                        <span class="text-[10px] text-gray-400">اشترك في:
                                            {{ $course->pivot->created_at->format('Y-m-d') }}</span>
                                    </div>
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-medium bg-emerald-500/10 text-emerald-500 rounded">نشط</span>
                                </div>
                            @endforeach
                        @else
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-[#151f32] rounded-xl border border-gray-100 dark:border-gray-800">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-200">كيمياء الصف الثالث الثانوي</h4>
                                    <span class="text-[10px] text-gray-400">تاريخ الاشتراك: 2026-05-10</span>
                                </div>
                                <span
                                    class="px-2 py-0.5 text-[10px] font-medium bg-emerald-500/10 text-emerald-500 rounded">نشط</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-[#151f32] rounded-xl border border-gray-100 dark:border-gray-800">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-200">مراجعة الباب الأول والثاني</h4>
                                    <span class="text-[10px] text-gray-400">تاريخ الاشتراك: 2026-05-18</span>
                                </div>
                                <span
                                    class="px-2 py-0.5 text-[10px] font-medium bg-emerald-500/10 text-emerald-500 rounded">نشط</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">تعديل بيانات الحساب الشخصي</h2>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
                        class="p-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <input type="hidden" name="status" value="{{ $user->status }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold mb-2 text-gray-400">الاسم
                                    الكامل</label>
                                <div class="relative">
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" required
                                        class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors" />
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg></div>
                                </div>
                                @error('name')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-semibold mb-2 text-gray-400">رقم
                                    الهاتف</label>
                                <div class="relative">
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone) }}" required
                                        class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg></div>
                                </div>
                                @error('phone')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="block text-xs font-semibold mb-2 text-gray-400">البريد
                                    الإلكتروني</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" required
                                        class="w-full pr-10 pl-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left dir-ltr" />
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg></div>
                                </div>
                                @error('email')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold mb-2 text-gray-400">الجنس</label>
                                <div
                                    class="flex items-center gap-6 h-11 bg-gray-50 dark:bg-[#151f32] px-4 rounded-lg border border-gray-300 dark:border-gray-700">
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                        <input type="radio" name="gender" value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <span>ذكر</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                        <input type="radio" name="gender" value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <span>أنثى</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="image" class="block text-xs font-semibold mb-2 text-gray-400">تحديث الصورة
                                    الشخصية</label>
                                <input type="file" name="image" id="image"
                                    class="block w-full text-xs text-gray-500 bg-gray-50 dark:bg-[#151f32] rounded-lg border border-gray-300 dark:border-gray-700 p-2 cursor-pointer focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700"
                                    accept="image/*" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="bio" class="block text-xs font-semibold mb-2 text-gray-400">النبذة
                                    التعريفية (Bio)</label>
                                <textarea name="bio" id="bio" rows="3" placeholder="تعديل النبذة الشخصية المكتوبة..."
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-sm resize-none">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                            <h3 class="text-sm font-bold text-indigo-500 uppercase tracking-wider mb-4">تغيير كلمة المرور
                                الشخصية</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-xs font-semibold mb-2 text-gray-400">كلمة
                                        المرور الجديدة</label>
                                    <input type="password" name="password" id="password"
                                        placeholder="اكتب كلمة مرور جديدة"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left" />
                                    @error('password')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-xs font-semibold mb-2 text-gray-400">تأكيد كلمة المرور
                                        الجديدة</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="أعد كتابة كلمة المرور"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#151f32] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-left" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end border-t border-gray-100 dark:border-gray-800">
                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-md transition-colors">
                                حفظ كافة التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
