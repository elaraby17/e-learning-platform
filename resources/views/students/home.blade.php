@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    {{-- ══ Hero تدرّج بلون دور الطالب (brand → sky) ══ --}}
    <x-page-hero icon="fa-solid fa-hand-sparkles" eyebrow="رحلتك التعليمية" greeting="أهلاً بك"
        :name="auth()->user()->name"
        message="سعيد برؤيتك مرة أخرى، لنكمل رحلة التعلم اليوم خطوة بخطوة.">
        <x-slot:actions>
            <x-button size="lg" class="bg-white! text-ink! shadow-card hover:bg-white/90" icon="fa-solid fa-compass"
                :href="route('all-courses')">تصفح الكورسات</x-button>
        </x-slot:actions>

        <x-slot:footer>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm font-bold text-white/85">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-book text-sky-200" aria-hidden="true"></i>
                    {{ $enrolled_count ?? 0 }} كورس مسجّل
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-sky-200" aria-hidden="true"></i>
                    {{ $completed_count ?? 0 }} كورس مكتمل
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-sky-200" aria-hidden="true"></i>
                    {{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
                </span>
            </div>
        </x-slot:footer>
    </x-page-hero>

    {{-- ══ الإحصائيات ══ --}}
    <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-3">
        <x-stat-card title="كورسات مسجلة" icon="fa-solid fa-book" tone="brand" trend="+2"
            trend-note="هذا الشهر" :sparkline="[30, 38, 44, 42, 58, 66, 80]">
            {{ $enrolled_count ?? 0 }}
        </x-stat-card>

        <x-stat-card title="كورسات مكتملة" icon="fa-solid fa-circle-check" tone="emerald" trend="+1"
            trend-note="خطوة جديدة" :sparkline="[12, 18, 22, 30, 38, 48, 58]">
            {{ $completed_count ?? 0 }}
        </x-stat-card>

        <x-stat-card title="شهادات محصلة" icon="fa-solid fa-certificate" tone="sky" description="توثّق إنجازاتك"
            :sparkline="[8, 12, 14, 20, 26, 32, 40]">
            {{ $certificates_count ?? 0 }}
        </x-stat-card>
    </div>

    {{-- ══ الكورسات قيد الدراسة ══ --}}
    <x-card title="تابع التعلم" icon="fa-solid fa-play-circle" class="mt-8"
        description="استكمل من حيث توقفت في آخر جلسة.">
        <x-slot:actions>
            @if (Route::has('all-courses'))
                <x-button variant="secondary" size="sm" icon="fa-solid fa-compass" :href="route('all-courses')">
                    كل الكورسات
                </x-button>
            @endif
        </x-slot:actions>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($coursesEnrolled as $enrollment)
                @php
                    $course = $enrollment->course;
                    $cover = $course->image
                        ? (filter_var($course->image, FILTER_VALIDATE_URL) ? $course->image : asset('storage/' . $course->image))
                        : null;
                    $instructorAvatar = $course->instructor->image
                        ? (filter_var($course->instructor->image, FILTER_VALIDATE_URL)
                            ? $course->instructor->image
                            : Storage::url($course->instructor->image))
                        : null;
                @endphp

                <x-course-card :course="$course" :title="$course->title"
                    :description="$course->description" :image="$cover"
                    :categoryName="$course->category->name ?? 'جديد'" :instructorName="$course->instructor->name"
                    :instructorImage="$instructorAvatar" :price="$course->price"
                    :lessonsCount="$course->sections_count ?? null"
                    :studentsCount="$course->total_students ?? null"
                    :rating="(float) ($course->average_rating ?? 0) > 0 ? (float) $course->average_rating : null"
                    :progress="$enrollment->progress ?? null" />
            @empty
                <div class="col-span-full py-10">
                    <x-empty-state title="لا توجد كورسات قيد الدراسة"
                        description="ابدأ رحلتك التعليمية الآن واختر أول كورس!" icon="fa-solid fa-book-open">
                        <x-slot:actions>
                            <x-button icon="fa-solid fa-compass" :href="route('all-courses')">تصفح الكورسات</x-button>
                        </x-slot:actions>
                    </x-empty-state>
                </div>
            @endforelse
        </div>
    </x-card>
@endsection
