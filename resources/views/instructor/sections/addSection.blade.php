@extends('layouts.app')

@section('title', 'إدارة الكورسات والسيكشنز والدروس')

@php
    /*
         | Expected from the controller:
         |   $courses        -> light list of the instructor's courses (id, title) for the select
     |   $selectedCourse -> the chosen course with sections.lessons loaded, or null
     */
$courses = $courses ?? collect();
$selectedCourse = $selectedCourse ?? null;

// Which modal should be re-opened after a failed validation (hidden "_modal" input).
$activeModal = old('_modal');

$lessonTypes = [
    'video' => ['icon' => 'fa-circle-play', 'class' => 'text-info-500'],
    'quiz' => ['icon' => 'fa-circle-question', 'class' => 'text-brand-500'],
    'article' => ['icon' => 'fa-file-lines', 'class' => 'text-warning-500'],
];

$lessonTypeOptions = [
    'video' => 'فيديو (Video)',
    'article' => 'مقال / نصي (Article)',
    'quiz' => 'اختبار قصير (Quiz)',
    ];
@endphp

@section('content')

    <x-page-header title="إدارة الكورسات والسيكشنز والدروس" icon="fa-solid fa-sitemap"
        description="اختر الكورس أولاً، وبعدها أضف السيكشنز والدروس الخاصة به." />

    <div class="space-y-8">

        @if ($courses->isEmpty())

            {{-- ═══════════════ NO COURSES AT ALL ═══════════════ --}}
            <x-card>
                <x-empty-state title="لا توجد كورسات حتى الآن"
                    description="ابدأ بإنشاء كورس جديد أولاً لتتمكن من إضافة السيكشنز والدروس." icon="fa-solid fa-book-open">
                    <x-slot:actions>
                        <x-button icon="fa-solid fa-plus" :href="route('instructor.courses.create')">
                            إنشاء كورس
                        </x-button>
                    </x-slot:actions>
                </x-empty-state>
            </x-card>
        @else
            {{-- ═══════════════ COURSE PICKER ═══════════════ --}}
            <x-card>

                <form method="GET" action="{{ url()->current() }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">

                    <div class="flex-1">
                        <label for="course_filter" class="mb-2 block text-sm font-bold text-ink dark:text-white">
                            <i class="fa-solid fa-graduation-cap me-1 text-brand-500" aria-hidden="true"></i>
                            الكورس
                        </label>

                        <select id="course_filter" name="course" onchange="this.form.submit()"
                            class="w-full rounded-xl border border-separator bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-navy-border dark:bg-navy/50 dark:text-white">
                            <option value="">— اختر الكورس —</option>

                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected($selectedCourse && $selectedCourse->id === $course->id)>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fallback when JS is disabled --}}
                    <noscript>
                        <x-button type="submit" icon="fa-solid fa-magnifying-glass">عرض</x-button>
                    </noscript>

                </form>

            </x-card>


            @if (!$selectedCourse)

                {{-- ═══════════════ NOTHING SELECTED YET ═══════════════ --}}
                <x-card>
                    <x-empty-state title="اختر كورس للبدء"
                        description="اختر الكورس من القائمة بالأعلى لعرض السيكشنز والدروس الخاصة به وإضافة محتوى جديد."
                        icon="fa-solid fa-hand-pointer" />
                </x-card>
            @else
                @php
                    $lessonsTotal = $selectedCourse->sections->sum(fn($s) => $s->lessons->count());
                @endphp

                {{-- ═══════════════ SELECTED COURSE ═══════════════ --}}
                <x-card :padded="false">

                    {{-- Course header --}}
                    <div
                        class="flex flex-col items-start justify-between gap-4 border-b border-separator bg-canvas p-6 lg:flex-row lg:items-center dark:border-navy-border dark:bg-navy/30">

                        <div class="min-w-0">
                            <h2 class="flex items-center gap-2 text-xl font-extrabold text-ink dark:text-white">
                                <i class="fa-solid fa-graduation-cap text-brand-500" aria-hidden="true"></i>
                                {{ $selectedCourse->title }}
                            </h2>

                            @if ($selectedCourse->description)
                                <p class="mt-1 max-w-2xl text-sm text-muted">{{ $selectedCourse->description }}</p>
                            @endif

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <x-badge variant="brand" icon="fa-solid fa-layer-group">
                                    السيكشنز: {{ $selectedCourse->sections->count() }}
                                </x-badge>

                                <x-badge variant="success" icon="fa-solid fa-book-open">
                                    الدروس: {{ $lessonsTotal }}
                                </x-badge>
                            </div>
                        </div>

                        <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                            <x-button type="button" icon="fa-solid fa-layer-group" data-modal-open="section-modal">
                                إضافة Section
                            </x-button>

                            <x-button type="button" variant="success" icon="fa-solid fa-book-open"
                                data-modal-open="lesson-modal">
                                إضافة Lesson
                            </x-button>
                        </div>

                    </div>


                    {{-- Sections --}}
                    <div class="space-y-5 p-6">

                        @forelse ($selectedCourse->sections as $section)
                            <div class="overflow-hidden rounded-xl border border-separator">

                                {{-- Section header --}}
                                <div
                                    class="flex flex-col items-start justify-between gap-3 bg-canvas px-5 py-4 sm:flex-row sm:items-center dark:bg-navy/30">

                                    <div class="min-w-0">
                                        <h3 class="flex items-center gap-2 text-sm font-extrabold text-ink dark:text-white">
                                            <i class="fa-solid fa-layer-group text-xs text-success-500"
                                                aria-hidden="true"></i>
                                            {{ $section->title }}
                                        </h3>

                                        @if ($section->description)
                                            <p class="mt-1 max-w-xl truncate text-xs text-muted"
                                                title="{{ $section->description }}">
                                                {{ $section->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex shrink-0 flex-wrap items-center gap-2">

                                        <x-badge variant="success">
                                            الدروس: {{ $section->lessons->count() }}
                                        </x-badge>

                                        {{-- Quick add lesson (section pre-selected) --}}
                                        <x-button type="button" variant="ghost" size="sm" icon="fa-solid fa-plus"
                                            data-modal-open="lesson-modal" data-section-id="{{ $section->id }}">
                                            درس
                                        </x-button>

                                        @if (Route::has('instructor.sections.edit'))
                                            <x-button type="button" variant="ghost" size="sm" icon="fa-solid fa-pen"
                                                :href="route('instructor.sections.edit', $section->id)">
                                                تعديل
                                            </x-button>
                                        @endif

                                        @if (Route::has('instructor.sections.destroy'))
                                            <form method="POST"
                                                action="{{ route('instructor.sections.destroy', $section->id) }}"
                                                data-confirm-delete="سيتم حذف هذا السيكشن وكل الدروس بداخله نهائياً ولا يمكن التراجع!">
                                                @csrf
                                                @method('DELETE')

                                                <x-button type="submit" variant="ghost" size="sm"
                                                    icon="fa-solid fa-trash"
                                                    class="text-danger-500 hover:bg-danger-50 dark:hover:bg-danger-500/10">
                                                    حذف
                                                </x-button>
                                            </form>
                                        @endif

                                    </div>

                                </div>


                                {{-- Lessons --}}
                                <div class="divide-y divide-separator">

                                    @forelse ($section->lessons as $lesson)
                                        @php
                                            $meta = $lessonTypes[$lesson->type] ?? $lessonTypes['article'];
                                        @endphp

                                        <div
                                            class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 transition-colors hover:bg-brand-50/40 dark:hover:bg-brand-500/5">

                                            <div class="flex min-w-0 items-center gap-3">

                                                <i class="fa-solid {{ $meta['icon'] }} {{ $meta['class'] }} shrink-0 text-sm"
                                                    aria-hidden="true"></i>

                                                <span
                                                    class="shrink-0 text-xs text-muted">#{{ $lesson->order_number }}</span>

                                                <span class="truncate text-sm font-bold text-ink dark:text-white">
                                                    {{ $lesson->title }}
                                                </span>

                                                @if ($lesson->type === 'video' && $lesson->video_duration)
                                                    <span class="shrink-0 text-[11px] text-muted">
                                                        ({{ $lesson->video_duration }} د)
                                                    </span>
                                                @endif

                                                @if ($lesson->is_free_preview)
                                                    <x-badge variant="warning" class="shrink-0">معاينة مجانية</x-badge>
                                                @endif

                                            </div>

                                            <div class="flex shrink-0 items-center gap-3">

                                                @if (Route::has('instructor.lessons.edit'))
                                                    <x-button type="button" variant="ghost" size="sm"
                                                        icon="fa-solid fa-pen" :href="route('instructor.lessons.edit', $lesson->id)">
                                                        تعديل
                                                    </x-button>
                                                @endif

                                                @if (Route::has('instructor.lessons.destroy'))
                                                    <form method="POST"
                                                        action="{{ route('instructor.lessons.destroy', $lesson->id) }}"
                                                        data-confirm-delete="سيتم حذف هذا الدرس نهائياً ولا يمكن التراجع!">
                                                        @csrf
                                                        @method('DELETE')

                                                        <x-button type="submit" variant="ghost" size="sm"
                                                            icon="fa-solid fa-trash"
                                                            class="text-danger-500 hover:bg-danger-50 dark:hover:bg-danger-500/10">
                                                            حذف
                                                        </x-button>
                                                    </form>
                                                @endif

                                            </div>

                                        </div>

                                    @empty

                                        <p class="px-5 py-4 text-center text-xs font-bold text-muted">
                                            لا توجد دروس في هذا السيكشن بعد.
                                        </p>
                                    @endforelse

                                </div>

                            </div>

                        @empty

                            <p class="py-6 text-center text-sm font-bold text-muted">
                                لا توجد سيكشنز في هذا الكورس بعد. ابدأ بإضافة Section.
                            </p>
                        @endforelse

                    </div>

                </x-card>


                {{-- ═══════════════ SECTION MODAL ═══════════════ --}}
                <div id="section-modal"
                    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
                    aria-hidden="true" data-modal>

                    <div class="w-full max-w-2xl overflow-hidden rounded-2xl border border-separator bg-white shadow-2xl dark:border-navy-border dark:bg-navy"
                        role="dialog" aria-modal="true" aria-labelledby="section-modal-title">

                        <div
                            class="flex items-center justify-between border-b border-separator px-6 py-5 dark:border-navy-border">
                            <div>
                                <h2 id="section-modal-title"
                                    class="flex items-center gap-2 text-lg font-extrabold text-ink dark:text-white">
                                    <i class="fa-solid fa-layer-group text-brand-500" aria-hidden="true"></i>
                                    إضافة Section
                                </h2>
                                <p class="mt-1 text-xs text-muted">
                                    سيتم إضافة السيكشن إلى كورس: <span
                                        class="font-bold text-ink dark:text-white">{{ $selectedCourse->title }}</span>
                                </p>
                            </div>

                            <button type="button" data-modal-close
                                class="flex h-9 w-9 items-center justify-center rounded-lg text-muted transition hover:bg-default hover:text-ink dark:hover:bg-navy-border dark:hover:text-white"
                                aria-label="إغلاق">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>


                        <form action="{{ route('instructor.sections.store') }}" method="POST"
                            data-prevent-double-submit>
                            @csrf
                            <input type="hidden" name="_modal" value="section">
                            <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">

                            <div class="space-y-5 p-6">

                                @if ($errors->any() && $activeModal === 'section')
                                    <div class="rounded-xl border border-danger-500/30 bg-danger-50 p-4 text-sm text-danger-500 dark:bg-danger-500/10"
                                        role="alert">
                                        <p class="mb-2 font-bold">في أخطاء لازم تتصلح:</p>
                                        <ul class="list-inside list-disc space-y-1 text-xs">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <x-input id="section_title" name="title" label="عنوان السيكشن" required
                                    placeholder="مثال: مقدمة في البرمجة" icon="fa-solid fa-heading" :value="$activeModal === 'section' ? old('title') : ''" />

                                <x-input id="section_description" name="description" label="وصف السيكشن (اختياري)"
                                    placeholder="وصف مختصر لمحتوى السيكشن" icon="fa-solid fa-align-start"
                                    :value="$activeModal === 'section' ? old('description') : ''" />

                            </div>

                            <div
                                class="flex justify-end gap-3 border-t border-separator px-6 py-4 dark:border-navy-border">
                                <x-button type="button" variant="secondary" size="sm" icon="fa-solid fa-xmark"
                                    data-modal-close>
                                    إلغاء
                                </x-button>

                                <x-button type="submit" size="sm" icon="fa-solid fa-floppy-disk">
                                    حفظ Section
                                </x-button>
                            </div>

                        </form>

                    </div>

                </div>


                {{-- ═══════════════ LESSON MODAL ═══════════════ --}}
                <div id="lesson-modal"
                    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
                    aria-hidden="true" data-modal>

                    <div class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl border border-separator bg-white shadow-2xl dark:border-navy-border dark:bg-navy"
                        role="dialog" aria-modal="true" aria-labelledby="lesson-modal-title">

                        <div
                            class="flex shrink-0 items-center justify-between border-b border-separator px-6 py-5 dark:border-navy-border">
                            <div>
                                <h2 id="lesson-modal-title"
                                    class="flex items-center gap-2 text-lg font-extrabold text-ink dark:text-white">
                                    <i class="fa-solid fa-book-open text-success-500" aria-hidden="true"></i>
                                    إضافة Lesson
                                </h2>
                                <p class="mt-1 text-xs text-muted">
                                    كورس: <span
                                        class="font-bold text-ink dark:text-white">{{ $selectedCourse->title }}</span>
                                    — اختر الـ Section ثم أضف الدرس.
                                </p>
                            </div>

                            <button type="button" data-modal-close
                                class="flex h-9 w-9 items-center justify-center rounded-lg text-muted transition hover:bg-default hover:text-ink dark:hover:bg-navy-border dark:hover:text-white"
                                aria-label="إغلاق">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>


                        <form id="lesson-form" action="{{ route('instructor.lessons.store') }}" method="POST"
                            class="flex min-h-0 flex-1 flex-col" data-prevent-double-submit>
                            @csrf
                            <input type="hidden" name="_modal" value="lesson">

                            <div class="flex-1 space-y-5 overflow-y-auto p-6">

                                @if ($errors->any() && $activeModal === 'lesson')
                                    <div class="rounded-xl border border-danger-500/30 bg-danger-50 p-4 text-sm text-danger-500 dark:bg-danger-500/10"
                                        role="alert">
                                        <p class="mb-2 font-bold">في أخطاء لازم تتصلح:</p>
                                        <ul class="list-inside list-disc space-y-1 text-xs">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Section (only sections of the selected course) --}}
                                <div>
                                    <label for="lesson_section_id"
                                        class="mb-2 block text-sm font-bold text-ink dark:text-white">
                                        Section <span class="text-danger-500">*</span>
                                    </label>

                                    <select id="lesson_section_id" name="section_id" required @disabled($selectedCourse->sections->isEmpty())
                                        class="w-full rounded-xl border border-separator bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 disabled:cursor-not-allowed disabled:opacity-60 dark:border-navy-border dark:bg-navy/50 dark:text-white">
                                        @if ($selectedCourse->sections->isEmpty())
                                            <option value="">لا توجد Sections في هذا الكورس</option>
                                        @else
                                            <option value="">اختر الـ Section</option>
                                            @foreach ($selectedCourse->sections as $section)
                                                <option value="{{ $section->id }}" @selected($activeModal === 'lesson' && (string) old('section_id') === (string) $section->id)>
                                                    {{ $section->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if ($selectedCourse->sections->isEmpty())
                                        <p class="mt-2 text-xs font-bold text-warning-500">
                                            هذا الكورس لا يحتوي على Sections حتى الآن. أضف Section أولاً.
                                        </p>
                                    @endif
                                </div>

                                {{-- Title / Type / Order --}}
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                                    <x-input id="lesson_title" name="title" label="عنوان الدرس" required
                                        placeholder="مثال: أساسيات المتغيرات" icon="fa-solid fa-heading"
                                        :value="$activeModal === 'lesson' ? old('title') : ''" />

                                    <x-select id="lesson_type" name="type" label="نوع الدرس" required
                                        data-lesson-type>
                                        @foreach ($lessonTypeOptions as $value => $label)
                                            <option value="{{ $value }}" @selected(($activeModal === 'lesson' ? old('type', 'video') : 'video') === $value)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </x-select>

                                    <x-input id="lesson_order_number" name="order_number" label="ترتيب الدرس"
                                        type="number" min="1" inputmode="numeric" :value="$activeModal === 'lesson' ? old('order_number', 1) : 1" />

                                </div>

                                {{-- Video fields (disabled when hidden so they are not submitted) --}}
                                <div data-video-fields class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                    <x-input id="lesson_video_url" name="video_url" label="رابط الفيديو" type="url"
                                        dir="ltr" placeholder="https://youtube.com/..." :value="$activeModal === 'lesson' ? old('video_url') : ''" />

                                    <x-input id="lesson_video_duration" name="video_duration" label="المدة (دقائق)"
                                        type="number" min="1" placeholder="15" inputmode="numeric"
                                        :value="$activeModal === 'lesson' ? old('video_duration') : ''" />

                                </div>

                                {{-- Content --}}
                                <x-textarea id="lesson_content" name="content" label="محتوى الدرس" rows="4"
                                    placeholder="اكتب المقال أو إرشادات الاختبار هنا...">{{ $activeModal === 'lesson' ? old('content') : '' }}</x-textarea>

                                {{-- Free preview --}}
                                <label class="inline-flex cursor-pointer select-none items-center gap-3">

                                    <input type="checkbox" name="is_free_preview" value="1" class="peer sr-only"
                                        @checked($activeModal === 'lesson' && old('is_free_preview'))>

                                    <span
                                        class="relative h-6 w-11 shrink-0 rounded-full bg-default transition peer-checked:bg-success-500 peer-focus-visible:ring-2 peer-focus-visible:ring-brand-500/50 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full dark:bg-navy-border dark:peer-checked:bg-success-500 dark:after:border-navy-border"
                                        aria-hidden="true"></span>

                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                                        إتاحة كمعاينة مجانية (Free Preview)
                                    </span>

                                </label>

                            </div>

                            <div
                                class="flex shrink-0 justify-end gap-3 border-t border-separator bg-white px-6 py-4 dark:border-navy-border dark:bg-navy">
                                <x-button type="button" variant="secondary" size="sm" icon="fa-solid fa-xmark"
                                    data-modal-close>
                                    إلغاء
                                </x-button>

                                <x-button type="submit" size="sm" icon="fa-solid fa-floppy-disk">
                                    حفظ Lesson
                                </x-button>
                            </div>

                        </form>

                    </div>

                </div>

            @endif

        @endif

    </div>

@endsection


@push('scripts')

    @if ($selectedCourse)
        @php

            $sectionsJs = $selectedCourse->sections
                ->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'lessons_count' => $section->lessons->count(),
                    ];
                })
                ->values()
                ->all();

            $hasErrors = $errors->any();
        @endphp

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const sections = @json($sectionsJs);
                const activeOld = @json($activeModal);
                const hasErrors = @json($hasErrors);


                /* ------------------------------------------------------------------
                 | Generic modal manager (scroll lock, focus trap, Esc, backdrop)
                 |------------------------------------------------------------------*/
                const FOCUSABLE = [
                    'a[href]',
                    'button:not([disabled])',
                    'input:not([disabled]):not([type="hidden"])',
                    'select:not([disabled])',
                    'textarea:not([disabled])',
                    '[tabindex]:not([tabindex="-1"])',
                ].join(',');

                let activeModal = null;
                let lastFocused = null;

                function openModal(modal) {
                    if (!modal) return;

                    lastFocused = document.activeElement;
                    activeModal = modal;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');

                    const first = modal.querySelector(
                        'input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea');
                    (first || modal.querySelector(FOCUSABLE))?.focus();
                }

                function closeModal(modal) {
                    if (!modal) return;

                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');

                    activeModal = null;
                    lastFocused?.focus?.();
                }

                document.addEventListener('keydown', (event) => {
                    if (!activeModal) return;

                    if (event.key === 'Escape') {
                        closeModal(activeModal);
                        return;
                    }

                    if (event.key === 'Tab') {
                        const items = [...activeModal.querySelectorAll(FOCUSABLE)]
                            .filter((el) => el.offsetParent !== null);

                        if (!items.length) return;

                        const first = items[0];
                        const last = items[items.length - 1];

                        if (event.shiftKey && document.activeElement === first) {
                            event.preventDefault();
                            last.focus();
                        } else if (!event.shiftKey && document.activeElement === last) {
                            event.preventDefault();
                            first.focus();
                        }
                    }
                });

                document.querySelectorAll('[data-modal]').forEach((modal) => {
                    modal.addEventListener('click', (event) => {
                        if (event.target === modal) closeModal(modal);
                    });

                    modal.querySelectorAll('[data-modal-close]').forEach((btn) => {
                        btn.addEventListener('click', () => closeModal(modal));
                    });
                });


                /* ------------------------------------------------------------------
                 | Prevent double submit
                 |------------------------------------------------------------------*/
                document.querySelectorAll('form[data-prevent-double-submit]').forEach((form) => {
                    form.addEventListener('submit', () => {
                        form.querySelectorAll('button[type="submit"]').forEach((btn) => {
                            btn.disabled = true;
                            btn.classList.add('opacity-60', 'cursor-not-allowed');
                        });
                    });
                });


                /* ------------------------------------------------------------------
                 | Section modal
                 |------------------------------------------------------------------*/
                const sectionModal = document.getElementById('section-modal');

                /* ------------------------------------------------------------------
                 | Lesson modal
                 |------------------------------------------------------------------*/
                const lessonModal = document.getElementById('lesson-modal');
                const lessonForm = document.getElementById('lesson-form');
                const lessonSectionSelect = document.getElementById('lesson_section_id');
                const lessonTypeSelect = lessonForm?.querySelector('[data-lesson-type]');
                const videoFields = lessonForm?.querySelector('[data-video-fields]');
                const orderInput = lessonForm?.querySelector('[name="order_number"]');

                let orderTouched = false;
                orderInput?.addEventListener('input', () => {
                    orderTouched = true;
                });

                // Suggest the next lesson number for the chosen section
                function suggestOrderNumber() {
                    if (!orderInput || orderTouched) return;

                    const section = sections.find((s) => String(s.id) === String(lessonSectionSelect.value));

                    orderInput.value = section ? section.lessons_count + 1 : 1;
                }

                function updateLessonType() {
                    if (!lessonTypeSelect || !videoFields) return;

                    const isVideo = lessonTypeSelect.value === 'video';

                    videoFields.classList.toggle('hidden', !isVideo);

                    // Disabled inputs are not submitted, so stale video data never reaches the server
                    videoFields.querySelectorAll('input').forEach((input) => {
                        input.disabled = !isVideo;
                    });
                }

                lessonSectionSelect?.addEventListener('change', suggestOrderNumber);
                lessonTypeSelect?.addEventListener('change', updateLessonType);

                function prepareLessonModal(sectionId = '') {
                    lessonForm.reset();
                    orderTouched = false;

                    if (sectionId) {
                        lessonSectionSelect.value = String(sectionId);
                    }

                    updateLessonType();
                    suggestOrderNumber();
                }


                /* ------------------------------------------------------------------
                 | Open buttons
                 |------------------------------------------------------------------*/
                document.querySelectorAll('[data-modal-open]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const modal = document.getElementById(button.dataset.modalOpen);

                        if (modal === lessonModal) {
                            prepareLessonModal(button.dataset.sectionId);
                        }

                        if (modal === sectionModal) {
                            sectionModal.querySelector('form')?.reset();
                        }

                        openModal(modal);
                    });
                });


                /* ------------------------------------------------------------------
                 | Initial state / re-open after failed validation
                 |------------------------------------------------------------------*/
                updateLessonType();

                if (hasErrors && activeOld === 'section') {
                    openModal(sectionModal);
                }

                if (hasErrors && activeOld === 'lesson') {
                    orderTouched = true; // keep the user's previous order value
                    openModal(lessonModal);
                }

            });
        </script>
    @endif

@endpush
