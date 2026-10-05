@extends('layouts.app')

@section('title', $course->title ?? 'عرض الكورس')

@section('content')
    <div id="course-player" data-autoplay="{{ $lesson ? 'true' : 'false' }}">
        {{-- ══ ترويسة المشغّل ══ --}}
        <div
            class="surface-card sticky top-20 z-20 mb-6 flex flex-col items-start gap-4 p-4 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <a href="{{ url()->previous() }}"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-brand-600 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-brand-300"
                    aria-label="رجوع">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>

                <div class="min-w-0">
                    <span class="text-[10px] font-extrabold tracking-wider text-brand-600 uppercase dark:text-brand-400">
                        صفحة الطالب
                    </span>
                    <h1 class="line-clamp-1 text-lg font-extrabold text-ink dark:text-white">{{ $course->title }}</h1>
                </div>
            </div>

            <div class="flex w-full items-center gap-3 md:w-auto md:min-w-[250px]">
                <div class="h-2.5 w-full overflow-hidden rounded-full bg-default">
                    <div id="progress-bar"
                        class="h-2.5 rounded-full bg-success-500 transition-all duration-500"
                        style="width: 0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                        aria-label="نسبة إكمال الدروس"></div>
                </div>
                <span id="progress-label" class="text-xs font-extrabold whitespace-nowrap text-slate-600 dark:text-slate-400"
                    dir="ltr">0%</span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- ══ منطقة المشغّل ══ --}}
            <div class="space-y-6 lg:col-span-2">
                <div id="main-viewer-card" class="surface-card overflow-hidden">
                    {{-- 1. مشغل الفيديو: iframe --}}
                    <div id="video-iframe-wrapper" class="hidden aspect-video w-full overflow-hidden bg-black">
                        <iframe id="video-player-iframe" class="h-full w-full" frameborder="0"
                            allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                            allowfullscreen src="" title="مشغل الفيديو"></iframe>
                    </div>

                    {{-- 2. مشغل فيديو محلي --}}
                    <div id="video-native-wrapper" class="hidden">
                        <video id="video-player-native" controls class="max-h-[450px] w-full bg-black">
                            <source src="" type="video/mp4">
                            المتصفح لا يدعم تشغيل الفيديو.
                        </video>
                    </div>

                    {{-- 3. شاشة ترحيب --}}
                    <div id="welcome-placeholder"
                        class="flex flex-col items-center justify-center px-8 py-20 text-center @if ($lesson && $lesson->type === 'video') hidden @endif">
                        <span class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                            <i class="fa-solid fa-play-circle text-4xl text-brand-500" aria-hidden="true"></i>
                        </span>
                        <h3 class="mb-2 text-lg font-extrabold text-ink dark:text-white">ابدأ رحلتك التعليمية</h3>
                        <p class="text-sm text-muted">
                            اختر درساً من القائمة الجانبية للبدء في المشاهدة.
                        </p>
                    </div>

                    {{-- 4. حاوية المقالات --}}
                    <div id="article-container" class="hidden p-8">
                        <div class="mb-4 flex items-center gap-3 text-success-600 dark:text-success-400">
                            <i class="fa-solid fa-file-lines text-2xl" aria-hidden="true"></i>
                            <span class="text-sm font-extrabold tracking-wider uppercase">درس قراءة ومطالعة</span>
                        </div>
                        <h2 id="article-title" class="mb-4 text-2xl font-extrabold text-ink dark:text-white"></h2>
                        <div id="article-content"
                            class="leading-relaxed whitespace-pre-line text-slate-600 dark:text-slate-300"></div>
                    </div>

                    {{-- 5. حاوية الاختبار --}}
                    <div id="quiz-container" class="mx-auto hidden max-w-lg p-8 py-12 text-center">
                        <span class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                            <i class="fa-solid fa-lightbulb text-3xl text-brand-600 dark:text-brand-400" aria-hidden="true"></i>
                        </span>
                        <h2 id="quiz-title" class="mb-3 text-2xl font-extrabold text-ink dark:text-white"></h2>
                        <p class="mb-6 text-sm text-muted">
                            هذا الاختبار مصمم لقياس استيعابك للمفاهيم التي تم تغطيتها في هذا القسم.
                        </p>
                        <div id="quiz-content-preview"
                            class="surface-muted mb-8 p-4 text-start text-sm"></div>
                        <x-button data-quiz-start icon="fa-solid fa-play">بدء الاختبار الآن</x-button>
                    </div>

                    {{-- معلومات الدرس الحالي --}}
                    <div class="border-t border-separator bg-canvas p-6 dark:border-navy-border dark:bg-navy/30">
                        <div
                            class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                            <div class="min-w-0">
                                <h3 id="active-lesson-title" class="text-lg font-extrabold text-ink dark:text-white">
                                    @if ($lesson)
                                        {{ $lesson->title }}
                                    @else
                                        مرحباً بك في لوحة التعلم
                                    @endif
                                </h3>
                                <p id="active-lesson-meta" class="mt-1 text-xs text-muted">
                                    @if ($lesson)
                                        نوع المحتوى:
                                        {{ $lesson->type === 'video' ? 'فيديو شروحات' : ($lesson->type === 'article' ? 'قراءة ومقالة' : 'اختبار قصير') }}
                                    @else
                                        يرجى تحديد درس للبدء في المتابعة
                                    @endif
                                </p>
                            </div>

                            <button type="button" id="btn-complete-lesson" data-complete-lesson
                                @class([
                                    'inline-flex items-center gap-2 rounded-xl bg-success-50 px-4 py-2 text-sm font-extrabold text-success-600 transition hover:bg-success-100 dark:bg-success-500/10 dark:text-success-400 dark:hover:bg-success-500/20',
                                    'hidden' => ! $lesson,
                                ])>
                                <i class="fa-solid fa-check-double" aria-hidden="true"></i>
                                تحديد كمكتمل
                            </button>
                        </div>
                    </div>
                </div>

                <x-card title="عن هذا الكورس" icon="fa-solid fa-circle-info">
                    <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                        {{ $course->description ?? 'لا يوجد وصف متاح لهذا الكورس حالياً.' }}
                    </p>
                </x-card>
            </div>

            {{-- ══ منهج الكورس ══ --}}
            <div class="space-y-6">
                <x-card :padded="false" class="overflow-hidden">
                    <x-slot:title>منهج ومحتويات الكورس</x-slot:title>
                    <x-slot:description>إجمالي الأقسام: {{ $course->sections->count() }} سيكشن</x-slot:description>

                    <div class="max-h-[600px] divide-y divide-slate-100 overflow-y-auto dark:divide-navy-border/70">
                        @forelse ($course->sections as $sectionIndex => $section)
                            <div class="section-block">
                                <button type="button" data-toggle-section="sec-{{ $section->id }}"
                                    aria-expanded="true" aria-controls="sec-{{ $section->id }}"
                                    class="flex w-full items-center justify-between gap-3 bg-canvas/60 p-4 text-start transition hover:bg-brand-50/50 dark:bg-navy/20 dark:hover:bg-brand-500/5">
                                    <div class="min-w-0">
                                        <span class="text-xs font-bold text-muted">
                                            قسم {{ $sectionIndex + 1 }}
                                        </span>
                                        <h4 class="truncate text-sm font-extrabold text-ink dark:text-white">
                                            {{ $section->title }}
                                        </h4>
                                    </div>
                                    <i id="icon-sec-{{ $section->id }}" class="fa-solid fa-chevron-down shrink-0 text-xs text-slate-400 transition-transform duration-200"
                                        aria-hidden="true"></i>
                                </button>

                                <div id="sec-{{ $section->id }}" class="transition-all duration-300">
                                    <div class="space-y-1 p-2">
                                        @forelse ($section->lessons->sortBy('order_number') as $lessonItem)
                                            @php
                                                $lessonIcons = [
                                                    'video' => 'fa-play',
                                                    'article' => 'fa-file-lines',
                                                    'quiz' => 'fa-circle-question',
                                                ];
                                            @endphp

                                            <button type="button" data-lesson-trigger data-id="{{ $lessonItem->id }}"
                                                data-title="{{ $lessonItem->title }}" data-type="{{ $lessonItem->type }}"
                                                data-video-url="{{ $lessonItem->video_url }}"
                                                data-video-duration="{{ $lessonItem->video_duration }}"
                                                data-is-free="{{ $lessonItem->is_free_preview ? '1' : '0' }}"
                                                data-content="{{ e($lessonItem->content) }}"
                                                aria-current="{{ $lesson && $lesson->id === $lessonItem->id ? 'true' : 'false' }}"
                                                @class([
                                                    'group flex w-full items-center justify-between gap-3 rounded-xl p-3 text-start text-xs transition duration-150 hover:bg-brand-50/70 dark:hover:bg-brand-500/10',
                                                    'bg-brand-50 border-s-4 border-brand-500 dark:bg-brand-500/10' => $lesson && $lesson->id === $lessonItem->id,
                                                ])>
                                                <span class="flex min-w-0 items-center gap-3">
                                                    <span
                                                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-default text-slate-500 transition group-hover:bg-brand-100 group-hover:text-brand-600 dark:bg-navy dark:text-slate-400">
                                                        <i class="fa-solid {{ $lessonIcons[$lessonItem->type] ?? 'fa-file-lines' }} text-[10px]"
                                                            aria-hidden="true"></i>
                                                    </span>
                                                    <span class="min-w-0">
                                                        <span
                                                            class="block truncate font-bold text-ink transition group-hover:text-brand-700 dark:text-white dark:group-hover:text-brand-300">
                                                            {{ $lessonItem->title }}
                                                        </span>
                                                        <span class="mt-0.5 block text-[10px] text-muted">
                                                            @if ($lessonItem->type === 'video')
                                                                فيديو • {{ $lessonItem->video_duration ?? 0 }} دقيقة
                                                            @elseif ($lessonItem->type === 'article')
                                                                قراءة ومقالة
                                                            @elseif ($lessonItem->type === 'quiz')
                                                                اختبار تقييمي
                                                            @endif
                                                        </span>
                                                    </span>
                                                </span>

                                                <span class="flex shrink-0 items-center gap-2">
                                                    @if ($lessonItem->is_free_preview)
                                                        <x-badge variant="success">مجاني</x-badge>
                                                    @endif
                                                    <span class="lesson-status-{{ $lessonItem->id }} text-slate-300 dark:text-slate-600">
                                                        <i class="fa-regular fa-circle text-xs" aria-hidden="true"></i>
                                                    </span>
                                                </span>
                                            </button>
                                        @empty
                                            <p class="py-4 text-center text-[11px] font-bold text-muted">
                                                لا توجد دروس في هذا السيكشن حالياً.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <x-empty-state title="لا توجد محتويات" description="لا توجد محتويات مضافة لهذا الكورس حتى الآن."
                                icon="fa-solid fa-list-ol" />
                        @endforelse
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection