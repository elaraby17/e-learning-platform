@extends('layouts.app')

@section('title', 'إدارة الكورسات والسيكشنز والدروس')

@section('content')
    <x-page-header title="إدارة الكورسات والسيكشنز والدروس" icon="fa-solid fa-sitemap"
        description="كل كورس بيظهر في كارت لوحده، وجوه سيكشناته، وجوه كل سيكشن دروسه. تقدر تضيف سيكشن أو درس مباشرة من نفس الكارت." />

    <div class="space-y-8">
        @forelse ($courses ?? [] as $course)
            <x-card :padded="false">
                {{-- ══ رأس الكورس ══ --}}
                <div
                    class="flex flex-col items-start justify-between gap-4 border-b border-separator bg-canvas p-6 sm:flex-row sm:items-center dark:border-navy-border dark:bg-navy/30">
                    <div class="min-w-0">
                        <h2 class="flex items-center gap-2 text-xl font-extrabold text-ink dark:text-white">
                            <i class="fa-solid fa-graduation-cap text-brand-500" aria-hidden="true"></i>
                            {{ $course->title }}
                        </h2>
                        @if ($course->description)
                            <p class="mt-1 max-w-2xl text-sm text-muted">
                                {{ $course->description }}
                            </p>
                        @endif
                    </div>

                    <div class="flex shrink-0 items-center gap-3">
                        <x-badge variant="brand" icon="fa-solid fa-layer-group">
                            السيكشنز: {{ $course->sections->count() }}
                        </x-badge>

                        <x-button size="sm" icon="fa-solid fa-plus" type="button"
                            data-toggle-section="{{ $course->id }}" aria-controls="section-form-{{ $course->id }}"
                            aria-expanded="false">سيكشن جديد</x-button>
                    </div>
                </div>

                {{-- ══ فورم إضافة سيكشن (مخفي) ══ --}}
                <div id="section-form-{{ $course->id }}" class="hidden border-b border-separator bg-canvas p-6 dark:border-navy-border dark:bg-navy/20"
                    data-lesson-scope>
                    <form action="{{ route('instructor.sections.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <x-input name="title" label="عنوان السيكشن" required
                                placeholder="مثال: مقدمة في البرمجة" icon="fa-solid fa-heading" />

                            <x-input name="description" label="وصف السيكشن" required
                                placeholder="وصف مختصر لمحتوى السيكشن" icon="fa-solid fa-align-start" />
                        </div>

                        <div class="mt-4 flex justify-end gap-3">
                            <x-button type="button" variant="secondary" size="sm" icon="fa-solid fa-xmark"
                                data-cancel-section="{{ $course->id }}">إلغاء</x-button>

                            <x-button type="submit" size="sm" icon="fa-solid fa-floppy-disk">حفظ السيكشن</x-button>
                        </div>
                    </form>
                </div>

                {{-- ══ سيكشنز الكورس ══ --}}
                <div class="space-y-5 p-6">
                    @forelse ($course->sections as $section)
                        <div class="overflow-hidden rounded-xl border border-separator">
                            {{-- رأس السيكشن --}}
                            <div
                                class="flex flex-col items-start justify-between gap-3 bg-canvas px-5 py-4 sm:flex-row sm:items-center dark:bg-navy/30">
                                <div class="min-w-0">
                                    <h3 class="flex items-center gap-2 text-sm font-extrabold text-ink dark:text-white">
                                        <i class="fa-solid fa-layer-group text-xs text-success-500" aria-hidden="true"></i>
                                        {{ $section->title }}
                                    </h3>
                                    @if ($section->description)
                                        <p class="mt-1 max-w-xl truncate text-xs text-muted">
                                            {{ $section->description }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex shrink-0 flex-wrap items-center gap-2">
                                    <x-badge variant="success">الدروس: {{ $section->lessons->count() }}</x-badge>

                                    <x-button type="button" variant="success" size="sm" icon="fa-solid fa-plus"
                                        data-toggle-lesson="{{ $section->id }}"
                                        aria-controls="lesson-row-{{ $section->id }}"
                                        aria-expanded="false">إضافة درس</x-button>

                                    @if (Route::has('instructor.sections.edit'))
                                        <x-button type="button" variant="ghost" size="sm" icon="fa-solid fa-pen"
                                            :href="route('instructor.sections.edit', $section->id)">تعديل</x-button>
                                    @endif

                                    @if (Route::has('instructor.sections.destroy'))
                                        <form method="POST" action="{{ route('instructor.sections.destroy', $section->id) }}"
                                            data-confirm-delete="سيتم حذف هذا السيكشن وجميع دروسه نهائياً ولا يمكن التراجع!">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="ghost" size="sm" icon="fa-solid fa-trash"
                                                class="text-danger-500 hover:bg-danger-50 dark:hover:bg-danger-500/10">
                                                حذف
                                            </x-button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- فورم إضافة درس (مخفي) --}}
                            <div id="lesson-row-{{ $section->id }}"
                                class="hidden border-t border-separator bg-canvas/60 dark:border-navy-border dark:bg-navy/10"
                                data-lesson-scope>
                                <div class="p-5">
                                    <div class="mb-4 flex items-center gap-2">
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span
                                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-success-400 opacity-75"></span>
                                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-success-500"></span>
                                        </span>
                                        <h4 class="text-xs font-extrabold text-ink dark:text-white">
                                            إضافة درس إلى: <span class="text-brand-600 dark:text-brand-400">{{ $section->title }}</span>
                                        </h4>
                                    </div>

                                    <form action="{{ route('instructor.lessons.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="section_id" value="{{ $section->id }}">

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                            <x-input name="title" label="عنوان الدرس" required
                                                placeholder="مثال: أساسيات المتغيرات" icon="fa-solid fa-heading" />

                                            <x-select name="type" label="نوع الدرس" required data-lesson-type>
                                                <option value="video" selected>فيديو (Video)</option>
                                                <option value="article">مقال / نصي (Article)</option>
                                                <option value="quiz">اختبار قصير (Quiz)</option>
                                            </x-select>

                                            <x-input name="order_number" label="ترتيب الدرس" type="number"
                                                :value="$section->lessons->count() + 1" inputmode="numeric" />
                                        </div>

                                        <div data-video-fields
                                            class="grid grid-cols-1 gap-4 transition-all duration-300 md:grid-cols-2">
                                            <x-input name="video_url" label="رابط الفيديو" type="url" dir="ltr"
                                                placeholder="https://youtube.com/..." />

                                            <x-input name="video_duration" label="المدة (دقائق)" type="number"
                                                placeholder="15" inputmode="numeric" />
                                        </div>

                                        <x-textarea name="content" label="محتوى الدرس" rows="4"
                                            placeholder="اكتب المقال أو إرشادات الاختبار هنا..."
                                            wrapperClass="mt-4" data-content-fields />

                                        <label class="mt-4 inline-flex cursor-pointer select-none items-center gap-3">
                                            <input type="checkbox" name="is_free_preview" value="1" class="peer sr-only">

                                            <span
                                                class="relative h-6 w-11 shrink-0 rounded-full bg-default transition peer-checked:bg-success-500 dark:bg-navy-border dark:peer-checked:bg-success-500 peer-focus-visible:ring-2 peer-focus-visible:ring-brand-500/50 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full dark:after:border-navy-border"></span>

                                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                                                إتاحة كمعاينة مجانية (Free Preview)
                                            </span>
                                        </label>

                                        <div class="mt-6 flex justify-end gap-3">
                                            <x-button type="button" variant="secondary" size="sm" icon="fa-solid fa-xmark"
                                                data-cancel-lesson="{{ $section->id }}">إلغاء</x-button>

                                            <x-button type="submit" size="sm" icon="fa-solid fa-floppy-disk">حفظ الدرس</x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- قائمة دروس السيكشن --}}
                            <div class="divide-y divide-separator">
                                @forelse ($section->lessons as $lesson)
                                    @php
                                        [$typeIcon, $typeClass] = match ($lesson->type) {
                                            'video' => ['fa-circle-play', 'text-info-500'],
                                            'quiz' => ['fa-circle-question', 'text-brand-500'],
                                            default => ['fa-file-lines', 'text-warning-500'],
                                        };
                                    @endphp

                                    <div
                                        class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 transition-colors hover:bg-brand-50/40 dark:hover:bg-brand-500/5">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <i class="{{ $typeIcon }} shrink-0 text-sm {{ $typeClass }}" aria-hidden="true"></i>
                                            <span class="shrink-0 text-xs text-muted">#{{ $lesson->order_number }}</span>
                                            <span class="truncate text-sm font-bold text-ink dark:text-white">{{ $lesson->title }}</span>

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
                                                <x-button type="button" variant="ghost" size="sm" icon="fa-solid fa-pen"
                                                    :href="route('instructor.lessons.edit', $lesson->id)">تعديل</x-button>
                                            @endif

                                            @if (Route::has('instructor.lessons.destroy'))
                                                <form method="POST" action="{{ route('instructor.lessons.destroy', $lesson->id) }}"
                                                    data-confirm-delete="سيتم حذف هذا الدرس نهائياً ولا يمكن التراجع!">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" variant="ghost" size="sm" icon="fa-solid fa-trash"
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
                            لا توجد سيكشنز في هذا الكورس بعد. اضغط "سيكشن جديد" فوق عشان تضيف أول سيكشن.
                        </p>
                    @endforelse
                </div>
            </x-card>
        @empty
            <x-card>
                <x-empty-state title="لا توجد كورسات حتى الآن" description="ابدأ بإنشاء كورس جديد أولاً لتتمكن من إضافة السيكشنز."
                    icon="fa-solid fa-book-open">
                    <x-slot:actions>
                        <x-button icon="fa-solid fa-plus" :href="route('instructor.courses.create')">إنشاء كورس</x-button>
                    </x-slot:actions>
                </x-empty-state>
            </x-card>
        @endforelse
    </div>
@endsection