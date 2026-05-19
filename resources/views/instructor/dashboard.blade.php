@extends('layouts.master')

@section('title', 'Instructor Dashboard')

@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] transition-colors duration-300 p-4 lg:p-10"
    dir="rtl">

    {{-- HEADER --}}
    <header
        class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-10">

        <div>
            <div class="flex items-center gap-3 mb-2">
                <div
                    class="w-14 h-14 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-white text-xl"></i>
                </div>

                <div>
                    <h1
                        class="text-3xl font-black text-gray-800 dark:text-white">
                        لوحة المحاضر: {{ auth()->user()->name }}
                    </h1>

                    <p
                        class="text-gray-500 dark:text-slate-400 mt-1 text-sm">
                        إليك تقرير سريع عن أداء كورساتك وطلابك.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">

            {{-- Search --}}
            <div
                class="hidden md:flex items-center bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl px-4 h-14 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>

                <input type="text"
                    placeholder="ابحث عن كورس..."
                    class="bg-transparent border-none outline-none px-3 text-sm text-gray-700 dark:text-white placeholder:text-gray-400">
            </div>

            {{-- Create Button --}}
            <a href="{{ route('instructor.courses.create') }}"
                class="h-14 px-7 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-3">

                <i class="fa-solid fa-plus text-sm"></i>

                إنشاء كورس
            </a>
        </div>
    </header>

    {{-- ALERT --}}
    <x-success-component />

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">

        {{-- COURSES --}}
        <div
            class="group bg-white dark:bg-slate-800 rounded-[30px] p-7 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            <div class="flex justify-between items-start mb-6">

                <div>
                    <p
                        class="text-gray-400 dark:text-slate-400 text-xs font-bold tracking-[3px] uppercase mb-3">
                        إجمالي الكورسات
                    </p>

                    <h3
                        class="text-4xl font-black text-gray-800 dark:text-white">
                        {{ $total_courses ?? 0 }}
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center">
                    <i class="fa-solid fa-book text-xl"></i>
                </div>
            </div>

            <div class="h-2 rounded-full bg-blue-100 dark:bg-slate-700 overflow-hidden">
                <div class="h-full w-[70%] bg-blue-500 rounded-full"></div>
            </div>
        </div>

        {{-- STUDENTS --}}
        <div
            class="group bg-white dark:bg-slate-800 rounded-[30px] p-7 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            <div class="flex justify-between items-start mb-6">

                <div>
                    <p
                        class="text-gray-400 dark:text-slate-400 text-xs font-bold tracking-[3px] uppercase mb-3">
                        إجمالي الطلاب
                    </p>

                    <h3
                        class="text-4xl font-black text-gray-800 dark:text-white">
                        {{ $total_students ?? 0 }}
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>

            <div class="h-2 rounded-full bg-orange-100 dark:bg-slate-700 overflow-hidden">
                <div class="h-full w-[60%] bg-orange-500 rounded-full"></div>
            </div>
        </div>

        {{-- RATING --}}
        <div
            class="group bg-white dark:bg-slate-800 rounded-[30px] p-7 border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            <div class="flex justify-between items-start mb-6">

                <div>
                    <p
                        class="text-gray-400 dark:text-slate-400 text-xs font-bold tracking-[3px] uppercase mb-3">
                        متوسط التقييم
                    </p>

                    <h3
                        class="text-4xl font-black text-gray-800 dark:text-white flex items-center gap-2">
                        {{ $avg_rating ?? '0.0' }}

                        <span class="text-yellow-500 text-xl">★</span>
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-yellow-500/10 text-yellow-500 flex items-center justify-center">
                    <i class="fa-solid fa-star text-xl"></i>
                </div>
            </div>

            <div class="h-2 rounded-full bg-yellow-100 dark:bg-slate-700 overflow-hidden">
                <div class="h-full w-[85%] bg-yellow-500 rounded-full"></div>
            </div>
        </div>

    </div>

    {{-- COURSES TABLE --}}
    <div
        class="bg-white dark:bg-slate-800 rounded-[40px] border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">

        {{-- TOP --}}
        <div
            class="p-8 border-b border-gray-100 dark:border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

            <div>
                <h2
                    class="text-2xl font-black text-gray-800 dark:text-white mb-1">
                    إدارة كورساتي
                </h2>

                <p
                    class="text-gray-500 dark:text-slate-400 text-sm">
                    يمكنك تعديل أو حذف الكورسات الخاصة بك.
                </p>
            </div>

            <button
                class="px-5 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-white font-bold hover:scale-105 transition-all">
                <i class="fa-solid fa-filter ml-2"></i>
                فلترة
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-right">

                <thead>

                    <tr
                        class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">

                        <th
                            class="p-6 text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                            الكورس
                        </th>

                        <th
                            class="p-6 text-center text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                            الطلاب
                        </th>

                        <th
                            class="p-6 text-center text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                            السعر
                        </th>

                        <th
                            class="p-6 text-left text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                            الإجراءات
                        </th>
                    </tr>
                </thead>

                <tbody
                    class="divide-y divide-gray-100 dark:divide-slate-700">

                    @forelse ( $courses as $course )
                        <tr>

                            <td class="p-6 flex items-center gap-4 whitespace-nowrap">

                                <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/default-course.jpg') }}"
                                    alt="{{ $course->title }}"
                                    class="w-12 h-12 rounded-lg object-cover">

                                <div>
                                    <p
                                        class="text-sm font-bold text-gray-800 dark:text-white">
                                        {{ $course->title }}
                                    </p>

                                    <p
                                        class="text-xs text-gray-500 dark:text-slate-400">
                                        {{ $course->category->name ?? 'بدون تصنيف' }}
                                    </p>
                                </div>
                            </td>

                            <td class="p-6 text-center">
                                <span
                                    class="text-sm font-bold text-gray-800 dark:text-white">
                                    {{ $course->students_count ?? 0 }}
                                </span>
                            </td>

                            <td class="p-6 text-center">
                                <span
                                    class="text-sm font-bold text-gray-800 dark:text-white">
                                    {{ $course->price > 0 ? $course->price . ' ج.م' : 'مجاناً' }}
                                </span>
                            </td>

                            <td class="p-6 text-left flex items-center gap-3">

                                <a href="#"
                                    class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-bold transition-all">
                                    تعديل
                                </a>

                                <form action="#"
                                    method="POST"
                                    onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الكورس؟');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition-all">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    {{-- EMPTY STATE --}}
                    <tr>

                        <td colspan="4" class="p-16 text-center">

                            <div
                                class="w-24 h-24 rounded-full bg-indigo-500/10 text-indigo-500 flex items-center justify-center mx-auto mb-6">

                                <i class="fa-solid fa-book-open text-4xl"></i>
                            </div>

                            <h3
                                class="text-2xl font-black text-gray-800 dark:text-white mb-2">
                                لا توجد كورسات حالياً
                            </h3>

                            <p
                                class="text-gray-500 dark:text-slate-400 mb-6">
                                ابدأ بإنشاء أول كورس لك وشارك معرفتك مع الطلاب.
                            </p>

                            <a href="#"
                                class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition-all shadow-lg shadow-indigo-500/20">

                                <i class="fa-solid fa-plus"></i>

                                إنشاء كورس جديد
                            </a>
                        </td>
                    </tr>
                    @endforelse


                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
