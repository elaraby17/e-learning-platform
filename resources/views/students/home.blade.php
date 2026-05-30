@extends('layouts.master')
@section('title', 'الرئيسية')
@section('content')

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300 p-6 lg:p-10" dir="rtl">

        {{-- ══ HEADER ══ --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <p class="text-xs font-bold text-indigo-500 dark:text-indigo-400 tracking-widest mb-1">
                    {{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
                </p>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">
                    أهلاً بك، {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-slate-400 dark:text-slate-500 mt-1 text-sm">
                    سعيد برؤيتك مرة أخرى، لنكمل رحلة التعلم اليوم.
                </p>
            </div>
            <a href="{{ route('all-courses') }}"
                class="flex items-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:-translate-y-0.5 transform transition-all duration-200 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                تصفح الكورسات
            </a>
        </div>

        {{-- ══ STATS CARDS ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

            {{-- كورسات مسجلة --}}
            <div
                class="bg-white dark:bg-slate-800 p-7 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-5 hover:shadow-md hover:-translate-y-0.5 transform transition-all duration-200">
                <div
                    class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">كورسات
                        مسجلة</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white">{{ $enrolled_count ?? 0 }}</h3>
                </div>
            </div>

            {{-- كورسات مكتملة --}}
            <div
                class="bg-white dark:bg-slate-800 p-7 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-5 hover:shadow-md hover:-translate-y-0.5 transform transition-all duration-200">
                <div
                    class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">كورسات
                        مكتملة</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white">{{ $completed_count ?? 0 }}</h3>
                </div>
            </div>

            {{-- شهادات --}}
            <div
                class="bg-white dark:bg-slate-800 p-7 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-5 hover:shadow-md hover:-translate-y-0.5 transform transition-all duration-200">
                <div
                    class="w-14 h-14 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-400 dark:text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">شهادات
                        محصلة</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white">{{ $certificates_count ?? 0 }}</h3>
                </div>
            </div>

        </div>

        {{-- ══ COURSES IN PROGRESS ══ --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 transition-colors duration-300">

            <h2 class="text-xl font-black text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                <span class="w-1.5 h-7 bg-indigo-600 rounded-full"></span>
                تابع التعلم
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse($coursesEnrolled as $enrollment)
                    @php
                        $course = $enrollment->course;
                    @endphp


                    <x-card-course-component :course="$course" :title="$course->title" :image="$course->image ? asset('storage/' . $course->image) : asset('assets/default-course.jpg')" :categoryName="$course->category->name ?? 'جديد'"
                        :instructorName="$course->instructor->name" :instructorImage="$course->instructor->image
                            ? Storage::url($course->instructor->image)
                            : asset('assets/default-avatar.png')" :price="$course->price" />

                @empty
                    {{-- Empty state --}}
                    <div class="col-span-full py-20 text-center">
                        <div
                            class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-3xl flex items-center justify-center mx-auto mb-5">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-600 dark:text-slate-300 mb-2">لا توجد كورسات قيد الدراسة</h3>
                        <p class="text-slate-400 dark:text-slate-500 text-sm mb-6">ابدأ رحلتك التعليمية الآن واختر أول كورس!
                        </p>
                        <a href="{{ route('all-courses') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            تصفح الكورسات
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    </div>

@endsection
