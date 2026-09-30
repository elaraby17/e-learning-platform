@extends('layouts.master')
@section('title', 'تصفح الكورسات')
@section('content')

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-12 px-4 lg:p-12" dir="rtl">
        <div class="max-w-7xl mx-auto">

            {{-- ══ Header Section ══ --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-3">
                        مكتبة <span class="text-indigo-600">الكورسات</span>
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 max-w-md">
                        اكتشف أفضل الدورات التدريبية المخصصة لتطوير مهاراتك مع نخبة من المدربين.
                    </p>
                </div>
            </div>

            <x-success-component />

            {{-- ══ Filters & Categories ══ --}}
            <div class="flex flex-wrap gap-3 mb-10">
                <!-- زر الكل -->
                <a href="{{ route('all-courses') }}"
                    class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg {{ is_null($category_slug) ? 'bg-indigo-600 text-white shadow-indigo-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-500' }}">
                    الكل
                </a>

                <!-- تكرار الأقسام ديناميكياً -->
                @foreach ($categories as $cat)
                    <a href="{{ route('all-courses', ['category' => $cat->slug]) }}"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all {{ $category_slug == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-500' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- ══ Courses Grid ══ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">

                @forelse($courses as $course)
                    <x-card-course-component :course="$course" :title="$course->title" :description="$course->description" :image="$course->image ? asset('storage/' . $course->image) : asset('assets/default-course.jpg')"
                        :categoryName="$course->category->name ?? 'جديد'" :instructorName="$course->instructor->name" :instructorImage="$course->instructor->image
                            ? Storage::url($course->instructor->image)
                            : asset('assets/default-avatar.png')" :price="$course->price" />

                @empty
                    {{-- Empty State --}}
                    <div
                        class="col-span-full py-32 text-center bg-white dark:bg-slate-800 rounded-[3rem] border-2 border-dashed border-slate-200 dark:border-slate-700">
                        <div
                            class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">لا توجد كورسات حالياً</h2>
                        <p class="text-slate-500 dark:text-slate-400">نحن نعمل على إضافة محتوى جديد، انتظرونا قريباً!</p>
                    </div>
                @endforelse

            </div>

            {{-- ══ Pagination ══ --}}
            @if ($courses->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $courses->links() }}
                </div>
            @endif

        </div>
    </div>

    <style>
        /* تحسين شكل الترقيم ليتناسب مع التصميم */
        .pagination {
            @apply flex gap-2;
        }

        .page-item {
            @apply rounded-xl overflow-hidden border-none shadow-sm;
        }

        .page-link {
            @apply bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-4 py-2 border-none font-bold;
        }

        .page-item.active .page-link {
            @apply bg-indigo-600 text-white;
        }
    </style>

@endsection
