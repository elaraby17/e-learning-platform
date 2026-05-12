@extends('layouts.master')

@section('title', 'Home')

@section('content')

<header class="bg-white border-b border-gray-100 px-8 py-5 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h1 class="text-xl font-bold text-gray-800">لوحة التحكم</h1>
                <p class="text-xs text-gray-400 mt-1">مرحباً بك مجدداً، {{ auth()->user()->name }} 👋</p>
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:bg-gray-50 rounded-xl relative">
                    <span class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <img src="{{ asset('storage/'.auth()->user()->image) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-100">
            </div>
        </header>

        <div class="p-8">
                        <x-success-component />
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">08</p>
                        <p class="text-sm text-gray-400 font-medium">كورس مسجل</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">14</p>
                        <p class="text-sm text-gray-400 font-medium">ساعة تعليمية</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">03</p>
                        <p class="text-sm text-gray-400 font-medium">شهادات منجزة</p>
                    </div>
                </div>
            </div>

            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">تابع التعلم</h2>
                <a href="#" class="text-indigo-600 text-sm font-bold hover:underline">مشاهدة الكل</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-5 rounded-[2.5rem] border border-gray-100 shadow-sm flex gap-6 items-center">
                    <img src="https://placehold.co/600x400/6366f1/ffffff?text=Laravel" class="w-32 h-32 rounded-[2rem] object-cover shadow-md">
                    <div class="flex-1">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase">Backend</span>
                        <h3 class="font-bold text-gray-800 mt-2">احتراف Laravel 10 من الصفر</h3>

                        <div class="mt-4">
                            <div class="flex justify-between text-[10px] mb-1">
                                <span class="text-gray-400">نسبة الإنجاز</span>
                                <span class="text-indigo-600 font-bold">65%</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-full rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                    <button class="p-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    </button>
                </div>

                <div class="bg-white p-5 rounded-[2.5rem] border border-gray-100 shadow-sm flex gap-6 items-center">
                    <img src="https://placehold.co/600x400/8b5cf6/ffffff?text=UI/UX" class="w-32 h-32 rounded-[2rem] object-cover shadow-md">
                    <div class="flex-1">
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-full uppercase">Design</span>
                        <h3 class="font-bold text-gray-800 mt-2">أساسيات تصميم واجهة المستخدم</h3>

                        <div class="mt-4">
                            <div class="flex justify-between text-[10px] mb-1">
                                <span class="text-gray-400">نسبة الإنجاز</span>
                                <span class="text-purple-600 font-bold">30%</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-purple-600 h-full rounded-full" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>
                    <button class="p-3 bg-purple-600 text-white rounded-2xl hover:bg-purple-700 shadow-lg shadow-purple-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-indigo-900 rounded-[3rem] p-8 text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2">اختبار تقييم المستوى</h3>
                        <p class="text-indigo-200 text-sm mb-6 max-w-sm">لديك اختبار في مسار Laravel متاح الآن، سيساعدك على قياس مدى تطورك في الدورة.</p>
                        <button class="bg-white text-indigo-900 px-8 py-3 rounded-2xl font-black text-sm hover:bg-indigo-50 transition">ابدأ الاختبار الآن</button>
                    </div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-400 rounded-full opacity-10 blur-3xl"></div>
                </div>

                <div class="bg-white rounded-[3rem] p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-6">الجدول الأسبوعي</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex flex-col items-center justify-center text-indigo-600">
                                <span class="text-xs font-bold uppercase">الأحد</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">بث مباشر - مراجعة</p>
                                <p class="text-[10px] text-gray-400">08:00 مساءً</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
