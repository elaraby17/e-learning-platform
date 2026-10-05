@extends('layouts.app')

@section('title', 'تصفح الكورسات')

@section('content')
    <x-page-header title="مكتبة الكورسات" icon="fa-solid fa-compass"
        description="اكتشف أفضل الدورات التدريبية المخصصة لتطوير مهاراتك مع نخبة من المدربين." />

    {{-- ══ الأقسام ══ --}}
    <nav class="mb-8 flex flex-wrap gap-2" aria-label="تصنيفات الكورسات">
        <a href="{{ route('all-courses') }}"
            @class([
                'rounded-xl px-5 py-2.5 text-sm font-extrabold transition',
                'bg-brand-500 text-white shadow-brand' => is_null($category_slug),
                'border border-separator bg-surface text-slate-600 hover:border-brand-300 hover:text-brand-700 dark:border-navy-border dark:bg-navy-surface dark:text-slate-300' => ! is_null($category_slug),
            ])>
            الكل
        </a>

        @foreach ($categories as $cat)
            <a href="{{ route('all-courses', ['category' => $cat->slug]) }}"
                @class([
                    'rounded-xl px-5 py-2.5 text-sm font-extrabold transition',
                    'bg-brand-500 text-white shadow-brand' => $category_slug == $cat->slug,
                    'border border-separator bg-surface text-slate-600 hover:border-brand-300 hover:text-brand-700 dark:border-navy-border dark:bg-navy-surface dark:text-slate-300' => $category_slug != $cat->slug,
                ])>
                {{ $cat->name }}
            </a>
        @endforeach
    </nav>

    {{-- ══ شبكة الكورسات ══ --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse ($courses as $course)
            @php
                $cover = $course->image
                    ? (filter_var($course->image, FILTER_VALIDATE_URL) ? $course->image : asset('storage/' . $course->image))
                    : null;
                $instructorAvatar = $course->instructor->image
                    ? (filter_var($course->instructor->image, FILTER_VALIDATE_URL)
                        ? $course->instructor->image
                        : Storage::url($course->instructor->image))
                    : null;
            @endphp

            <x-course-card :course="$course" :title="$course->title" :description="$course->description"
                :image="$cover" :categoryName="$course->category->name ?? 'جديد'" :instructorName="$course->instructor->name"
                :instructorImage="$instructorAvatar" :price="$course->price"
                :studentsCount="$course->total_students ?? null"
                :rating="(float) ($course->average_rating ?? 0) > 0 ? (float) $course->average_rating : null" />
        @empty
            <div class="col-span-full">
                <x-empty-state title="لا توجد كورسات حالياً"
                    description="نحن نعمل على إضافة محتوى جديد، انتظرونا قريباً!" icon="fa-solid fa-box-open" />
            </div>
        @endforelse
    </div>

    @if (method_exists($courses, 'hasPages') && $courses->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $courses->links() }}
        </div>
    @endif
@endsection