@extends('layouts.app')

@section('title', 'كورساتي')

@section('content')
    <x-page-header title="مكتبة كورساتي" icon="fa-solid fa-book-bookmark"
        description="تابع جميع الكورسات التي اشتركت بها في مكان واحد، وابدأ رحلتك التعليمية الآن!" />

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
                    description="لم تشترك في أي كورس حتى الآن — تصفح المكتبة وابدأ الآن!" icon="fa-solid fa-box-open">
                    <x-slot:actions>
                        @if (Route::has('all-courses'))
                            <x-button icon="fa-solid fa-compass" :href="route('all-courses')">تصفح الكورسات</x-button>
                        @endif
                    </x-slot:actions>
                </x-empty-state>
            </div>
        @endforelse
    </div>

    @if (method_exists($courses, 'hasPages') && $courses->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $courses->links() }}
        </div>
    @endif
@endsection