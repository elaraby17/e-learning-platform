@extends('layouts.master')

@section('title', 'إدارة السيكشنز والدروس')

@section('content')
    {{-- ======================================================
         SweetAlert2 + FontAwesome
    ====================================================== --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

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

    <div class="container mx-auto px-4 py-12 max-w-5xl text-right" dir="rtl">

        {{-- العنوان --}}
        <div class="mb-8 text-center sm:text-right">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                إدارة السيكشنز والدروس
            </h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                قم بإنشاء سيكشنز جديدة لكورساتك، وأضف دروساً تفاعلية مباشرة من جدول الإدارة أدناه.
            </p>
        </div>

        {{-- ─── فورم إضافة سيكشن جديد ─── --}}
        <form action="{{ route('instructor.sections.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 transition-all duration-300">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- عنوان السيكشن --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        عنوان السيكشن
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                        placeholder="مثال: مقدمة في البرمجة"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700
                               text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2
                               focus:ring-indigo-500 focus:border-transparent transition duration-200
                               @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- اختيار الكورس --}}
                <div>
                    <label for="course_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        اختر الكورس
                    </label>
                    <div class="relative">
                        <select name="course_id" id="course_id" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700
                                   text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2
                                   focus:ring-indigo-500 focus:border-transparent transition duration-200 appearance-none cursor-pointer
                                   @error('course_id') border-rose-500 @enderror">
                            <option value="" disabled {{ old('course_id') ? '' : 'selected' }} hidden>
                                اختر الكورس المستهدف...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                    @error('course_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- وصف السيكشن --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    وصف السيكشن
                </label>
                <textarea name="description" id="description" required rows="3"
                    placeholder="اكتب وصفاً مختصراً لمحتويات هذا السيكشن..."
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2
                           focus:ring-indigo-500 focus:border-transparent transition duration-200 resize-none
                           @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600
                           text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none
                           transform hover:-translate-y-0.5 transition duration-200 text-center">
                    <i class="fas fa-plus ml-2"></i> إضافة السيكشن الجديد
                </button>
            </div>
        </form>

        {{-- ─── جدول السيكشنز ─── --}}
        <div
            class="mt-12 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">قائمة السيكشنز الحالية</h2>
                <span
                    class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold px-3 py-1.5 rounded-full">
                    إجمالي السيكشنز: {{ count($sections ?? []) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead
                        class="bg-gray-50 dark:bg-gray-900 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">اسم السيكشن</th>
                            <th class="px-6 py-4">وصف السيكشن</th>
                            <th class="px-6 py-4">الكورس</th>
                            <th class="px-6 py-4 text-center">إضافة محتوى</th>
                            <th class="px-6 py-4 text-left">التحكم</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($sections ?? [] as $section)
                            {{-- سطر السيكشن --}}
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/40 transition duration-150">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $section->title }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                    {{ $section->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $section->course->title ?? 'كورس غير معروف' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <button onclick="toggleLessonForm('{{ $section->id }}')"
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/40
                                               text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100
                                               dark:hover:bg-emerald-950/60 px-3 py-1.5 rounded-lg text-xs font-bold transition duration-200">
                                        <i class="fas fa-plus text-xs"></i> إضافة درس
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-left">
                                    <div class="inline-flex items-center space-x-reverse space-x-3">
                                        <a href="{{ route('instructor.sections.edit', $section->id) }}"
                                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold transition">
                                            تعديل
                                        </a>
                                        <span class="text-gray-300 dark:text-gray-600">|</span>
                                        {{-- زر الحذف بـ SweetAlert2 بدلاً من confirm() --}}
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('instructor.sections.destroy', $section->id) }}')"
                                            class="text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 font-semibold transition">
                                            حذف
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- فورم إضافة الدرس (مخفي) --}}
                            <tr id="lesson-row-{{ $section->id }}"
                                class="hidden bg-gray-50/50 dark:bg-gray-900/10 transition-all duration-300">
                                <td colspan="5" class="px-6 py-5">
                                    <div
                                        class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-inner">
                                        <div class="flex items-center gap-2 mb-6">
                                            <span class="flex h-2.5 w-2.5 relative">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                            </span>
                                            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                                إضافة درس إلى:
                                                <span
                                                    class="text-indigo-600 dark:text-indigo-400">{{ $section->title }}</span>
                                            </h4>
                                        </div>

                                        <form action="{{ route('instructor.lessons.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="section_id" value="{{ $section->id }}">

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                {{-- عنوان الدرس --}}
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">عنوان
                                                        الدرس *</label>
                                                    <input type="text" name="title" required
                                                        placeholder="مثال: أساسيات المتغيرات"
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>

                                                {{-- نوع الدرس --}}
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

                                                {{-- الترتيب --}}
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">ترتيب
                                                        الدرس</label>
                                                    <input type="number" name="order_number" min="1"
                                                        value="1" required
                                                        class="w-full px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                               text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                                </div>
                                            </div>

                                            {{-- حقول الفيديو --}}
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

                                            {{-- محتوى نصي --}}
                                            <div id="content-fields-{{ $section->id }}"
                                                class="mb-4 hidden transition-all duration-300">
                                                <label
                                                    class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">محتوى
                                                    الدرس</label>
                                                <textarea name="content" rows="4"
                                                    placeholder="اكتب المقال أو إرشادات الاختبار هنا..."
                                                    class="w-full px-3 py-3 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                                                           text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none resize-none"></textarea>
                                            </div>

                                            {{-- معاينة مجانية --}}
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
                                                    <span
                                                        class="mr-3 text-xs font-bold text-gray-700 dark:text-gray-300">
                                                        إتاحة كمعاينة مجانية (Free Preview)
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button"
                                                    onclick="toggleLessonForm('{{ $section->id }}')"
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    لا توجد سيكشنز مضافة حالياً. قم بإضافة أول سيكشن من النموذج أعلاه!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Hidden form used for DELETE requests --}}
    <form id="delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
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
            const type          = select.value;
            const videoFields   = document.getElementById('video-fields-'   + sectionId);
            const contentFields = document.getElementById('content-fields-' + sectionId);

            if (type === 'video') {
                videoFields.classList.remove('hidden');
                contentFields.classList.add('hidden');
            } else {
                videoFields.classList.add('hidden');
                contentFields.classList.remove('hidden');
            }
        }

        /* ─── حذف سيكشن بـ SweetAlert2 ─── */
        function confirmDelete(actionUrl) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف هذا السيكشن وجميع دروسه نهائياً ولا يمكن التراجع!',
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
