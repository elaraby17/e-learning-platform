@extends('layouts.master')

@section('title', $course->title ?? 'عرض الكورس')

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

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
        dir="rtl">

        {{-- =====================================================
             الهيدر العلوي
        ====================================================== --}}
        <header
            class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ url()->previous() }}"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                        <i class="fas fa-arrow-right text-lg"></i>
                    </a>
                    <div>
                        <span
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">صفحة
                            الطالب</span>
                        <h1 class="text-xl font-extrabold text-gray-900 dark:text-white line-clamp-1">
                            {{ $course->title }}</h1>
                    </div>
                </div>

                {{-- شريط التقدم (جمالي) --}}
                <div class="flex items-center gap-3 w-full md:w-auto min-w-[250px]">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-500" id="progress-bar"
                            style="width: 0%"></div>
                    </div>
                    <span id="progress-label"
                        class="text-xs font-bold text-gray-600 dark:text-gray-400 whitespace-nowrap">0%</span>
                </div>
            </div>
        </header>

        {{-- =====================================================
             المحتوى الرئيسي
        ====================================================== --}}
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ── منطقة المشغل ── --}}
                <div class="lg:col-span-2 space-y-6">
                    <div id="main-viewer-card"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-750 overflow-hidden">

                        {{-- 1. مشغل الفيديو: iframe (يوتيوب / فيميو) --}}
                        <div id="video-iframe-wrapper" class="hidden"
                            style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                            <iframe id="video-player-iframe"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
                                allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture"
                                allowfullscreen src="">
                            </iframe>
                        </div>

                        {{-- 2. مشغل فيديو محلي --}}
                        <div id="video-native-wrapper" class="hidden">
                            <video id="video-player-native" controls
                                class="w-full rounded-t-2xl bg-black max-h-[450px]">
                                <source src="" type="video/mp4">
                                المتصفح لا يدعم تشغيل الفيديو.
                            </video>
                        </div>

                        {{-- 3. شاشة ترحيب (تظهر عند دخول الصفحة ولا يوجد درس محدد) --}}
                        <div id="welcome-placeholder" class="flex flex-col items-center justify-center py-20 px-8 text-center
                            @if($lesson && $lesson->type === 'video') hidden @endif">
                            <div
                                class="w-20 h-20 bg-indigo-50 dark:bg-indigo-950/40 rounded-full flex items-center justify-center mb-5">
                                <i class="fas fa-play-circle text-4xl text-indigo-500"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">ابدأ رحلتك التعليمية</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">اختر درساً من القائمة الجانبية للبدء في
                                المشاهدة.</p>
                        </div>

                        {{-- 4. حاوية المقالات --}}
                        <div id="article-container" class="hidden p-8 prose max-w-none dark:prose-invert">
                            <div class="flex items-center gap-3 text-emerald-600 dark:text-emerald-400 mb-4">
                                <i class="fas fa-file-invoice text-2xl"></i>
                                <span class="font-bold text-sm uppercase">درس قراءة ومطالعة</span>
                            </div>
                            <h2 id="article-title" class="text-2xl font-bold mb-4 text-gray-900 dark:text-white"></h2>
                            <div id="article-content" class="text-gray-700 dark:text-gray-300 leading-relaxed space-y-4">
                            </div>
                        </div>

                        {{-- 5. حاوية الاختبار --}}
                        <div id="quiz-container" class="hidden p-8 text-center max-w-lg mx-auto py-12">
                            <div
                                class="w-20 h-20 bg-indigo-50 dark:bg-indigo-950/40 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-lightbulb text-3xl text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <h2 id="quiz-title" class="text-2xl font-bold mb-3 text-gray-950 dark:text-white"></h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-6">
                                هذا الاختبار مصمم لقياس استيعابك للمفاهيم التي تم تغطيتها في هذا القسم.
                            </p>
                            <div id="quiz-content-preview"
                                class="mb-8 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 text-right text-sm">
                            </div>
                            <button onclick="startQuizConfirm()"
                                class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-bold px-8 py-3 rounded-xl transition duration-200 shadow-md">
                                بدء الاختبار الآن <i class="fas fa-angle-left mr-2"></i>
                            </button>
                        </div>

                        {{-- معلومات الدرس الحالي --}}
                        <div
                            class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <h3 id="active-lesson-title"
                                        class="text-lg font-bold text-gray-900 dark:text-white">
                                        @if ($lesson)
                                            {{ $lesson->title }}
                                        @else
                                            مرحباً بك في لوحة التعلم
                                        @endif
                                    </h3>
                                    <p id="active-lesson-meta" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        @if ($lesson)
                                            نوع المحتوى:
                                            {{ $lesson->type === 'video' ? 'فيديو شروحات' : ($lesson->type === 'article' ? 'قراءة ومقالة' : 'اختبار قصير') }}
                                        @else
                                            يرجى تحديد درس للبدء في المتابعة
                                        @endif
                                    </p>
                                </div>
                                {{-- زر اكتمال الدرس --}}
                                <button id="btn-complete-lesson" onclick="markAsCompleted()"
                                    class="{{ $lesson ? '' : 'hidden' }} sm:inline-flex items-center gap-2 bg-emerald-50 dark:bg-emerald-950/45 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 px-4 py-2 rounded-xl text-sm font-bold transition">
                                    <i class="fas fa-check-double"></i>
                                    تحديد كمكتمل
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- وصف الكورس --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-750">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">عن هذا الكورس</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                            {{ $course->description ?? 'لا يوجد وصف متاح لهذا الكورس حالياً.' }}
                        </p>
                    </div>
                </div>

                {{-- ── الشريط الجانبي للمنهج ── --}}
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-750 overflow-hidden">
                        <div
                            class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="text-md font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fas fa-list-ol text-indigo-500"></i>
                                منهج ومحتويات الكورس
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                إجمالي الأقسام: {{ $course->sections->count() }} سيكشن
                            </p>
                        </div>

                        <div class="divide-y divide-gray-150 dark:divide-gray-700 max-h-[600px] overflow-y-auto">
                            @forelse ($course->sections as $sectionIndex => $section)
                                <div class="section-block">
                                    {{-- ترويسة السيكشن --}}
                                    <button onclick="toggleSection('sec-{{ $section->id }}')"
                                        class="w-full p-4 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/10 hover:bg-gray-50 dark:hover:bg-gray-900/30 transition text-right">
                                        <div>
                                            <span
                                                class="text-xs font-semibold text-gray-500 dark:text-gray-400">قسم
                                                {{ $sectionIndex + 1 }}</span>
                                            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                                {{ $section->title }}</h4>
                                        </div>
                                        <i id="icon-sec-{{ $section->id }}"
                                            class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                                    </button>

                                    {{-- دروس السيكشن --}}
                                    <div id="sec-{{ $section->id }}"
                                        class="bg-white dark:bg-gray-800 transition-all duration-300">
                                        <div class="p-2 space-y-1">
                                            @forelse ($section->lessons->sortBy('order_number') as $lessonItem)
                                                <button onclick="selectLesson(this)"
                                                    data-id="{{ $lessonItem->id }}"
                                                    data-title="{{ $lessonItem->title }}"
                                                    data-type="{{ $lessonItem->type }}"
                                                    data-video-url="{{ $lessonItem->video_url }}"
                                                    data-video-duration="{{ $lessonItem->video_duration }}"
                                                    data-is-free="{{ $lessonItem->is_free_preview ? '1' : '0' }}"
                                                    data-content="{{ e($lessonItem->content) }}"
                                                    class="lesson-btn w-full flex items-center justify-between p-3 rounded-xl text-right text-xs transition duration-150 group hover:bg-indigo-50/70 dark:hover:bg-indigo-950/20
                                                    @if ($lesson && $lesson->id === $lessonItem->id) bg-indigo-50 dark:bg-indigo-950/30 border-r-4 border-indigo-600 @endif">

                                                    <div class="flex items-center gap-3">
                                                        <span
                                                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-500 dark:text-gray-400 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                                            @if ($lessonItem->type === 'video')
                                                                <i class="fas fa-play text-[10px]"></i>
                                                            @elseif ($lessonItem->type === 'article')
                                                                <i class="fas fa-file-alt text-[10px]"></i>
                                                            @elseif ($lessonItem->type === 'quiz')
                                                                <i class="fas fa-question text-[10px]"></i>
                                                            @endif
                                                        </span>
                                                        <div>
                                                            <span
                                                                class="block font-semibold text-gray-800 dark:text-gray-200 group-hover:text-indigo-900 dark:group-hover:text-indigo-300 transition line-clamp-1">
                                                                {{ $lessonItem->title }}
                                                            </span>
                                                            <span
                                                                class="block text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">
                                                                @if ($lessonItem->type === 'video')
                                                                    فيديو •
                                                                    {{ $lessonItem->video_duration ?? 0 }} دقيقة
                                                                @elseif ($lessonItem->type === 'article')
                                                                    قراءة ومقالة
                                                                @elseif ($lessonItem->type === 'quiz')
                                                                    اختبار تقييمي
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        @if ($lessonItem->is_free_preview)
                                                            <span
                                                                class="bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded text-[10px] font-bold">
                                                                مجاني
                                                            </span>
                                                        @endif
                                                        <span
                                                            class="lesson-status-{{ $lessonItem->id }} text-gray-300 dark:text-gray-600">
                                                            <i class="far fa-circle text-xs"></i>
                                                        </span>
                                                    </div>
                                                </button>
                                            @empty
                                                <div class="text-center py-4 text-[11px] text-gray-400">
                                                    لا توجد دروس في هذا السيكشن حالياً.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-sm text-gray-500">
                                    لا توجد محتويات مضافة لهذا الكورس حتى الآن.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================
         JavaScript
    ====================================================== --}}
    <script>
        /* ─── حالة الدروس المكتملة (يمكن ربطها بـ API لاحقاً) ─── */
        const completedLessons = new Set();
        let activeLessonId = null;

        /* ─── تحميل أول درس تلقائياً إن وُجد ─── */
        document.addEventListener('DOMContentLoaded', () => {
            @if ($lesson)
                const firstBtn = document.querySelector('.lesson-btn');
                if (firstBtn) selectLesson(firstBtn);
            @endif
        });

        /* ─── فتح/إغلاق أقسام المنهج ─── */
        function toggleSection(sectionId) {
            const target = document.getElementById(sectionId);
            const icon = document.getElementById('icon-' + sectionId);
            const isHidden = target.classList.toggle('hidden');
            icon.style.transform = isHidden ? 'rotate(-90deg)' : 'rotate(0deg)';
        }

        /* ─── اختيار درس وعرضه ─── */
        function selectLesson(btn) {
            /* تمييز الزر النشط */
            document.querySelectorAll('.lesson-btn').forEach(b => {
                b.classList.remove('bg-indigo-50', 'dark:bg-indigo-950/30', 'border-r-4', 'border-indigo-600');
            });
            btn.classList.add('bg-indigo-50', 'dark:bg-indigo-950/30', 'border-r-4', 'border-indigo-600');

            /* قراءة البيانات */
            activeLessonId = btn.dataset.id;
            const title     = btn.dataset.title;
            const type      = btn.dataset.type;
            const videoUrl  = btn.dataset.videoUrl  || '';
            const content   = btn.dataset.content   || 'لا يوجد محتوى نصي لهذا الدرس حالياً.';

            /* تحديث الفوتر */
            document.getElementById('active-lesson-title').innerText = title;
            document.getElementById('active-lesson-meta').innerText =
                'نوع المحتوى: ' + (type === 'video' ? 'فيديو شروحات' :
                                    type === 'article' ? 'قراءة ومقالة' : 'اختبار قصير');
            document.getElementById('btn-complete-lesson').classList.remove('hidden');

            /* إخفاء كل الحاويات */
            ['video-iframe-wrapper', 'video-native-wrapper', 'welcome-placeholder',
             'article-container', 'quiz-container'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });

            /* إظهار الحاوية المناسبة */
            if (type === 'video') {
                let embedUrl = videoUrl;

                if (/youtube\.com\/watch\?v=/.test(videoUrl)) {
                    embedUrl = videoUrl.replace('watch?v=', 'embed/') + '?autoplay=1&rel=0';
                } else if (/youtu\.be\//.test(videoUrl)) {
                    const vid = videoUrl.split('youtu.be/')[1].split('?')[0];
                    embedUrl  = `https://www.youtube.com/embed/${vid}?autoplay=1&rel=0`;
                } else if (/vimeo\.com/.test(videoUrl)) {
                    const vid = videoUrl.split('vimeo.com/')[1];
                    embedUrl  = `https://player.vimeo.com/video/${vid}?autoplay=1`;
                }

                const isEmbed = /youtube\.com\/embed|vimeo\.com\/video/.test(embedUrl);

                if (isEmbed) {
                    document.getElementById('video-player-iframe').src = embedUrl;
                    document.getElementById('video-iframe-wrapper').classList.remove('hidden');
                } else {
                    const native = document.getElementById('video-player-native');
                    native.src = videoUrl;
                    native.load();
                    document.getElementById('video-native-wrapper').classList.remove('hidden');
                }

            } else if (type === 'article') {
                document.getElementById('article-title').innerText = title;
                document.getElementById('article-content').innerHTML = content.replace(/\n/g, '<br>');
                document.getElementById('article-container').classList.remove('hidden');

            } else if (type === 'quiz') {
                document.getElementById('quiz-title').innerText = title;
                document.getElementById('quiz-content-preview').innerHTML =
                    `<strong>تعليمات الاختبار:</strong><br>
                     1. هذا الاختبار مخصص لتطبيق ما تم شرحه.<br>
                     2. ملخص الدرس:<br>
                     <span class="text-gray-500">${content}</span>`;
                document.getElementById('quiz-container').classList.remove('hidden');
            }

            /* تمرير تلقائي على موبايل */
            if (window.innerWidth < 1024) {
                document.getElementById('main-viewer-card').scrollIntoView({ behavior: 'smooth' });
            }
        }

        /* ─── تحديد الدرس كمكتمل مع SweetAlert2 ─── */
        function markAsCompleted() {
            if (!activeLessonId) return;

            if (completedLessons.has(activeLessonId)) {
                Swal.fire({
                    icon: 'info',
                    title: 'تم الإكمال مسبقاً',
                    text: 'لقد قمت بتحديد هذا الدرس كمكتمل من قبل.',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#4f46e5',
                    timer: 2500,
                    timerProgressBar: true,
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'أحسنت! 🎉',
                text: 'تم تحديد هذا الدرس كمكتمل. استمر في التقدم!',
                confirmButtonText: 'التالي',
                confirmButtonColor: '#10b981',
                timer: 3000,
                timerProgressBar: true,
            }).then(() => {
                /* تحديث أيقونة الدرس في السايدبار */
                completedLessons.add(activeLessonId);
                const statusEl = document.querySelector(`.lesson-status-${activeLessonId} i`);
                if (statusEl) {
                    statusEl.classList.remove('far', 'fa-circle', 'text-gray-300', 'dark:text-gray-600');
                    statusEl.classList.add('fas', 'fa-check-circle', 'text-emerald-500');
                }
                updateProgressBar();
            });
        }

        /* ─── تحديث شريط التقدم ─── */
        function updateProgressBar() {
            const totalLessons = document.querySelectorAll('.lesson-btn').length;
            if (!totalLessons) return;
            const pct = Math.round((completedLessons.size / totalLessons) * 100);
            document.getElementById('progress-bar').style.width = pct + '%';
            document.getElementById('progress-label').innerText = pct + '%';
        }

        /* ─── تأكيد بدء الاختبار ─── */
        function startQuizConfirm() {
            Swal.fire({
                title: 'هل أنت مستعد؟',
                text: 'بمجرد البدء لن تتمكن من إيقاف الاختبار. تأكد من جهوزيتك!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ابدأ الاختبار',
                cancelButtonText: 'ليس الآن',
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'info',
                        title: 'جاري تحميل الأسئلة...',
                        text: 'ركّز وحل بكل دقة. بالتوفيق! 💪',
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#4f46e5',
                    });
                }
            });
        }
    </script>
@endsection
