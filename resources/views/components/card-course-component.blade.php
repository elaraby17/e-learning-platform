@props([
    'course',
    'title',
    'image',
    'description',
    'categoryName' => 'جديد',
    'instructorName',
    'instructorImage',
    'price' => 0,
    'lessonsCount' => null, // اختياري: عدد الدروس
    'rating' => 4.9, // اختياري: التقييم
    'progress' => null, // اختياري: نسبة الإنجاز (0-100) لو الطالب مشترك بالفعل
])

@php
    $isEnrolled = $course->students->contains(auth()->id());
@endphp

{{-- يُحمَّل مرة واحدة بس مهما اتكرر الكارت --}}
@once
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&display=swap" rel="stylesheet">
@endonce

<div
    class="group relative bg-white dark:bg-slate-800 rounded-[1.75rem] border border-slate-200/70 dark:border-slate-700
            overflow-hidden shadow-[0_1px_2px_rgba(15,23,42,0.06)] hover:shadow-[0_18px_40px_-15px_rgba(67,56,202,0.35)]
            hover:-translate-y-1 hover:border-indigo-300 dark:hover:border-indigo-600 transition-all duration-300">

    {{-- شريط تقدّم علوي - يظهر بس لو الطالب مشترك وعنده نسبة إنجاز --}}
    @if ($isEnrolled && !is_null($progress))
        <div class="absolute top-0 inset-x-0 h-1 bg-slate-100 dark:bg-slate-700 z-10">
            <div class="h-full bg-emerald-500" style="width: {{ min(100, max(0, $progress)) }}%"></div>
        </div>
    @endif

    {{-- ══ الصورة + شريط الفئة المطوي ══ --}}
    <div class="relative h-44 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}"
            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/0 to-transparent"></div>

        {{-- شارة الفئة بشكل "علامة مطوية" بدل البادچ التقليدي --}}
        <div class="absolute top-0 {{ auth()->check() ? 'start-0' : 'start-0' }} start-0">
            <div class="relative bg-indigo-600 text-white text-[11px] font-black px-4 py-2 pe-5">
                {{ $categoryName }}
                <span
                    class="absolute -bottom-2 start-0 w-0 h-0
                             border-s-[10px] border-s-transparent
                             border-t-[8px] border-t-indigo-800"></span>
            </div>
        </div>

        {{-- عدد الدروس - أسفل الصورة يمين --}}
        @if ($lessonsCount)
            <div
                class="absolute bottom-3 end-3 flex items-center gap-1.5 bg-white/95 dark:bg-slate-900/90 backdrop-blur
                        text-slate-700 dark:text-slate-200 text-[11px] font-bold px-2.5 py-1.5 rounded-lg">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                {{ $lessonsCount }} درس
            </div>
        @endif
    </div>

    {{-- ══ المحتوى ══ --}}
    <div class="p-5">

        {{-- التقييم --}}
        <div class="flex items-center gap-1.5 mb-2.5">
            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span class="text-slate-700 dark:text-slate-200 text-xs font-black">{{ number_format($rating, 1) }}</span>
        </div>

        {{-- العنوان --}}
        <h3 style="font-family: 'Cairo', sans-serif;"
            class="text-[17px] font-extrabold text-slate-900 dark:text-white mb-3 leading-snug line-clamp-2 min-h-[3rem]
                   group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
            <a href="{{ route('course-details', $course) }}">{{ $title }}</a>
        </h3>

        {{-- الوصف --}}
        <p style="font-family: 'Cairo', sans-serif;" class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3">
            {{ $description }}
        </p>

        {{-- المدرب --}}
        <div class="flex items-center gap-2.5 pb-4 mb-4 mt-4 border-b border-dashed border-slate-200 dark:border-slate-700">
            <img src="{{ $instructorImage }}" alt="{{ $instructorName }}"
                class="w-7 h-7 rounded-full object-cover ring-2 ring-indigo-50 dark:ring-slate-700">
            <span
                class="text-slate-500 dark:text-slate-400 text-xs font-semibold truncate">{{ $instructorName }}</span>
        </div>

        {{-- السعر + الإجراء --}}
        <div class="flex items-center justify-between">

            @if (!$isEnrolled)
                <div class="flex flex-col leading-tight">
                    <span
                        class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">السعر</span>
                    <span class="text-lg font-black text-slate-900 dark:text-white">
                        {{ $price > 0 ? number_format($price) . ' ج.م' : 'مجاناً' }}
                    </span>
                </div>

                <form method="POST" action="{{ route('courses.enroll', $course) }}">
                    @csrf
                    <button
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                   text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-600/20 transition">
                        اشترك الآن
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                </form>
            @else
                <div class="flex flex-col leading-tight">
                    <span
                        class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">مشترك</span>
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                        {{ !is_null($progress) ? 'أنجزت ' . round($progress) . '%' : 'استمر في التعلم' }}
                    </span>
                </div>

                <a href="{{ route('course-details', $course) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 dark:bg-emerald-900/30
                           text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/50
                           rounded-xl font-bold text-xs transition">
                    أكمل التعلم
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>
