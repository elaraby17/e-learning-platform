@extends('instructor.layouts.master')

@section('title', 'profile')

@section('content-instructor')
<div class="min-h-screen bg-gray-50/50" dir="rtl">
    @if(@session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
    <nav class="bg-white border-b border-gray-100 px-8 py-4 flex justify-between items-center">
        <div class="text-xl font-bold text-indigo-600">لوحة التحكم</div>
        <div class="flex items-center gap-4">
            <span class="text-gray-600 text-sm">مرحبا، {{ auth()->user()->name }}</span>
            <img src="{{ Storage::url(auth()->user()->image) }}" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-100">
        </div>
    </nav>

    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

                    <div class="relative z-10">
                        <div class="relative inline-block mt-4">
                            <img src="{{ Storage::url(auth()->user()->image) }}" alt="Profile Picture"
                                 class="w-32 h-32 rounded-3xl object-cover border-4 border-white shadow-lg mx-auto">
                            <label class="absolute bottom-2 -left-2 bg-white p-2 rounded-xl shadow-md cursor-pointer hover:bg-gray-50 transition border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" class="hidden">
                            </label>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mt-4">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
                        <p class="text-gray-400 text-sm">{{ auth()->user()->phone }}</p>
                        <p class="text-gray-400 text-sm">{{ auth()->user()->created_at->format('Y-m-d') }}</p>

                        <div class="mt-6 flex justify-center gap-3">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-medium rounded-full">طالب مميز</span>
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-medium rounded-full">حساب نشط</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-50 flex justify-around">
                        <div>
                            <p class="text-lg font-bold text-gray-800">12</p>
                            <p class="text-xs text-gray-400 font-medium">كورس مسجل</p>
                        </div>
                        <div class="border-r border-gray-100"></div>
                        <div>
                            <p class="text-lg font-bold text-gray-800">5</p>
                            <p class="text-xs text-gray-400 font-medium">شهادات</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800">إعدادات الحساب</h3>
                        <p class="text-gray-400 text-sm mt-1">تستطيع تعديل بياناتك الشخصية من هنا</p>
                    </div>

                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">الاسم بالكامل</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة (اتركها فارغة إذا لم ترد التغيير)</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none"
                                placeholder="••••••••">
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-4">
                            <button type="button" class="text-gray-400 hover:text-gray-600 font-medium transition">إلغاء</button>
                            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-8 bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">آخر النشاطات</h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-50">
                            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="flex-1 text-right">
                                <p class="text-sm font-bold text-gray-800">أكملت الدرس الأول في كورس Laravel</p>
                                <p class="text-xs text-gray-400">منذ ساعتين</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
