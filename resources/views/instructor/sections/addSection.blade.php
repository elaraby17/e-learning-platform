@extends('layouts.master')

@section('title', 'إدارة الكورسات والسيكشنز والدروس')

@section('content')
    {{-- ======================================================
         SweetAlert2 + FontAwesome
    ====================================================== --}}


    {{-- Flash messages via SweetAlert2 --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'تمّ بنجاح!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#4f46e5',
                    timer: 3500,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#4f46e5',
                });
            });
        </script>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'يوجد أخطاء في البيانات',
                    html: `<ul class="text-right text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>`,
                    confirmButtonText: 'تصحيح الأخطاء',
                    confirmButtonColor: '#4f46e5',
                });
            });
        </script>
    @endif

    <div class="container mx-auto px-4 py-12 max-w-6xl text-right" dir="rtl">

        {{-- العنوان --}}
        <div class="mb-8 text-center sm:text-right">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                إدارة الكورسات والسيكشنز والدروس
            </h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                كل كورس بيظهر في كارت لوحده، وجوه سيكشناته، وجوه كل سيكشن دروسه. تقدر تضيف سيكشن أو درس مباشرة من نفس
                الكارت.
            </p>
        </div>

        {{-- ─── قائمة الكورسات ─── --}}
        <div class="space-y-8">
            @forelse ($courses ?? [] as $course)
                {{-- ============ كارت الكورس ============ --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                    {{-- رأس كارت الكورس --}}
                    <div
                        class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/60 dark:bg-gray-900/30">
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fas fa-graduation-cap text-indigo-500"></i>
                                {{ $course->title }}
                            </h2>
                            @if ($course->description)
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-2xl">
                                    {{ $course->description }}
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span
                                class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold px-3 py-1.5 rounded-full">
                                السيكشنز: {{ $course->sections->count() }}
                            </span>
                            <button onclick="toggleSectionForm('{{ $course->id }}')"
                                class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                                       text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg shadow-indigo-200 dark:shadow-none
                                       transform hover:-translate-y-0.5 transition duration-200">
                                <i class="fas fa-plus"></i> سيكشن جديد
                            </button>
                        </div>
                    </div>

                    {{-- فورم إضافة سيكشن جديد لهذا الكورس (مخفي) --}}
                    <div id="section-form-{{ $course->id }}"
                        class="hidden p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                        <form action="{{ route('instructor.sections.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">
                                        عنوان السيكشن *
                                    </label>
                                    <input type="text" name="title" required placeholder="مثال: مقدمة في البرمجة"
                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">
                                        وصف السيكشن *
                                    </label>
                                    <input type="text" name="description" required placeholder="وصف مختصر لمحتوى السيكشن"
                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="toggleSectionForm('{{ $course->id }}')"
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                                           text-gray-700 dark:text-gray-200 text-xs font-bold py-2 px-4 rounded-lg transition">
                                    إلغاء
                                </button>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                                           text-white text-xs font-bold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-save ml-1"></i> حفظ السيكشن
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- ============ سيكشنز الكورس ============ --}}
                    <div class="p-6 space-y-5">
                        @forelse ($course->sections as $section)
                            <div class="rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                                {{-- رأس السيكشن --}}
                                <div
                                    class="px-5 py-4 bg-gray-50 dark:bg-gray-900/40 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                            <i class="fas fa-layer-group text-emerald-500 text-xs"></i>
                                            {{ $section->title }}
                                        </h3>
                                        @if ($section->description)
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 max-w-xl truncate">
                                                {{ $section->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        <span
                                            class="bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                            الدروس: {{ $section->lessons->count() }}
                                        </span>

                                        <button onclick="toggleLessonForm('{{ $section->id }}')"
                                            class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/40
                                                   text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100
                                                   dark:hover:bg-emerald-950/60 px-3 py-1.5 rounded-lg text-xs font-bold transition duration-200">
                                            <i class="fas fa-plus text-xs"></i> إضافة درس
                                        </button>

                                        <a href="{{ route('instructor.sections.edit', $section->id) }}"
                                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs font-bold transition">
                                            تعديل
                                        </a>

                                        <button type="button"
                                            onclick="confirmDelete('{{ route('instructor.sections.destroy', $section->id) }}', 'section')"
                                            class="text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 text-xs font-bold transition">
                                            حذف
                                        </button>
                                    </div>
                                </div>

                                {{-- فورم إضافة درس (مخفي) --}}
                                <div id="lesson-row-{{ $section->id }}"
                                    class="hidden bg-gray-50/50 dark:bg-gray-900/10 border-t border-gray-100 dark:border-gray-800 transition-all duration-300">
                                    <div class="p-5">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="flex h-2.5 w-2.5 relative">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                            </span>
                                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">
                                                إضافة درس إلى: <span
                                                    class="text-indigo-600 dark:text-indigo-400">{{ $section->title }}</span>
                                            </h4>
                                        </div>

                                        <form action="{{ route('instructor.lessons.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="section_id" value="{{ $section->id }}">

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">عنوان
                                                        الدرس *</label>
                                                    <input type="text" name="title" required
                                                        placeholder="مثال: أساسيات المتغيرات"
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>

                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">نوع
                                                        الدرس *</label>
                                                    <select name="type" required
                                                        onchange="handleLessonTypeChange(this, '{{ $section->id }}')"
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none cursor-pointer">
                                                        <option value="video" selected>فيديو (Video)</option>
                                                        <option value="article">مقال / نصي (Article)</option>
                                                        <option value="quiz">اختبار قصير (Quiz)</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">ترتيب
                                                        الدرس</label>
                                                    <input type="number" name="order_number" min="1"
                                                        value="{{ $section->lessons->count() + 1 }}" required
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>
                                            </div>

                                            <div id="video-fields-{{ $section->id }}"
                                                class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 transition-all duration-300">
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">رابط
                                                        الفيديو</label>
                                                    <input type="url" name="video_url"
                                                        placeholder="https://youtube.com/..."
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">المدة
                                                        (دقائق)</label>
                                                    <input type="number" name="video_duration" min="0"
                                                        placeholder="15"
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>
                                            </div>

                                            <div id="content-fields-{{ $section->id }}"
                                                class="mb-4 hidden transition-all duration-300">
                                                <label
                                                    class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">محتوى
                                                    الدرس</label>
                                                <textarea name="content" rows="4" placeholder="اكتب المقال أو إرشادات الاختبار هنا..."
                                                    class="w-full px-3 py-3 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                           text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-none"></textarea>
                                            </div>

                                            <div class="mb-6 flex items-center">
                                                <label class="inline-flex items-center cursor-pointer select-none">
                                                    <input type="checkbox" name="is_free_preview" value="1"
                                                        class="sr-only peer">
                                                    <div
                                                        class="relative w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full
                                                               peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                                                               peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                                                               after:start-[2px] after:bg-white after:border after:rounded-full after:h-5
                                                               after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                                    </div>
                                                    <span class="mr-3 text-xs font-bold text-gray-700 dark:text-gray-300">
                                                        إتاحة كمعاينة مجانية (Free Preview)
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button" onclick="toggleLessonForm('{{ $section->id }}')"
                                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                                                           text-gray-700 dark:text-gray-200 text-xs font-bold py-2 px-4 rounded-lg transition">
                                                    إلغاء
                                                </button>
                                                <button type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                                                           text-white text-xs font-bold py-2 px-4 rounded-lg transition">
                                                    <i class="fas fa-save ml-1"></i> حفظ الدرس
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- ============ قائمة دروس السيكشن ============ --}}
                                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse ($section->lessons as $lesson)
                                        <div
                                            class="px-5 py-3 flex items-center justify-between gap-3 hover:bg-gray-50/50 dark:hover:bg-gray-900/30 transition">
                                            <div class="flex items-center gap-3 min-w-0">
                                                @php
                                                    $typeIcon = match ($lesson->type) {
                                                        'video' => 'fa-circle-play text-blue-500',
                                                        'quiz' => 'fa-circle-question text-purple-500',
                                                        default => 'fa-file-lines text-amber-500',
                                                    };
                                                @endphp
                                                <i class="fas {{ $typeIcon }} text-sm shrink-0"></i>
                                                <span class="text-xs text-gray-400 dark:text-gray-500 shrink-0">
                                                    #{{ $lesson->order_number }}
                                                </span>
                                                <span
                                                    class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                                                    {{ $lesson->title }}
                                                </span>
                                                @if ($lesson->type === 'video' && $lesson->video_duration)
                                                    <span class="text-[11px] text-gray-400 dark:text-gray-500 shrink-0">
                                                        ({{ $lesson->video_duration }} د)
                                                    </span>
                                                @endif
                                                @if ($lesson->is_free_preview)
                                                    <span
                                                        class="bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0">
                                                        معاينة مجانية
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-3 shrink-0 text-xs">
                                                <a href="{{ route('instructor.lessons.edit', $lesson->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold transition">
                                                    تعديل
                                                </a>
                                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ route('instructor.lessons.destroy', $lesson->id) }}', 'lesson')"
                                                    class="text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 font-semibold transition">
                                                    حذف
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="px-5 py-4 text-xs text-gray-400 dark:text-gray-500 text-center">
                                            لا توجد دروس في هذا السيكشن بعد.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-6">
                                لا توجد سيكشنز في هذا الكورس بعد. اضغط "سيكشن جديد" فوق عشان تضيف أول سيكشن.
                            </p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    لا توجد كورسات حتى الآن.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Hidden form used for DELETE requests --}}
    <form id="delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        /* ─── Toggle فورم السيكشن ─── */
        function toggleSectionForm(courseId) {
            const box = document.getElementById('section-form-' + courseId);
            if (!box) return;
            box.classList.toggle('hidden');
            if (!box.classList.contains('hidden')) {
                const titleInput = box.querySelector('input[name="title"]');
                if (titleInput) titleInput.focus();
            }
        }

        /* ─── Toggle فورم الدرس ─── */
        function toggleLessonForm(sectionId) {
            const row = document.getElementById('lesson-row-' + sectionId);
            if (!row) return;
            row.classList.toggle('hidden');
            if (!row.classList.contains('hidden')) {
                const titleInput = row.querySelector('input[name="title"]');
                if (titleInput) titleInput.focus();
            }
        }

        /* ─── تغيير نوع الدرس ─── */
        function handleLessonTypeChange(select, sectionId) {
            const type = select.value;
            const videoFields = document.getElementById('video-fields-' + sectionId);
            const contentFields = document.getElementById('content-fields-' + sectionId);

            if (type === 'video') {
                videoFields.classList.remove('hidden');
                contentFields.classList.add('hidden');
            } else {
                videoFields.classList.add('hidden');
                contentFields.classList.remove('hidden');
            }
        }

        /* ─── حذف سيكشن أو درس بـ SweetAlert2 ─── */
        function confirmDelete(actionUrl, kind) {
            const isSection = kind === 'section';
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: isSection ?
                    'سيتم حذف هذا السيكشن وجميع دروسه نهائياً ولا يمكن التراجع!' :
                    'سيتم حذف هذا الدرس نهائياً ولا يمكن التراجع!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = actionUrl;
                    form.submit();
                }
            });
        }
    </script>
@endsection
