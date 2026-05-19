@extends('layouts.master')
@section('title', $course->title)
@section('content')

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-12 px-4 lg:p-12" dir="rtl">
        <div class="max-w-7xl mx-auto">

            {{-- ══ Breadcrumb ══ --}}
            <nav class="flex mb-8 text-sm font-bold gap-2 text-slate-400 dark:text-slate-500">
                <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">الرئيسية</a>
                <span>/</span>
                <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">الكورسات</a>
                <span>/</span>
                <span class="text-slate-600 dark:text-slate-300">{{ $course->title }}</span>
            </nav>

            {{-- ══ Layout Grid ══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- ══ Left Column: Course Main Content ══ --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Course Main Card --}}
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700/60 shadow-sm">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-xs font-black bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 mb-4 uppercase tracking-wider">
                            {{ $course->category->name ?? 'العامة' }}
                        </span>

                        <h1 class="text-2xl md:text-4xl font-black text-slate-900 dark:text-white mb-4 leading-tight">
                            {{ $course->title }}
                        </h1>

                        <p class="text-slate-500 dark:text-slate-400 text-base md:text-lg mb-6 leading-relaxed">
                            {{ $course->short_description ?? 'اكتشف محتوى الدورة وطوّر مهاراتك خطوة بخطوة مع شرح تطبيقي مكثف لضمان أقصى استفادة.' }}
                        </p>

                        {{-- Meta Info Row --}}
                        <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-slate-100 dark:border-slate-700/50 text-xs md:text-sm">
                            <div class="flex items-center gap-3">
                                <img src="{{ $course->instructor->image ? Storage::url($course->instructor->image) : asset('assets/default-avatar.png') }}"
                                     class="w-10 h-10 rounded-full object-cover ring-4 ring-indigo-500/10">
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold">المحاضر</p>
                                    <p class="font-bold text-slate-700 dark:text-slate-300">{{ $course->instructor->name }}</p>
                                </div>
                            </div>

                            <div class="h-8 w-[1px] bg-slate-100 dark:bg-slate-700/50 hidden sm:block"></div>

                            <div>
                                <p class="text-[10px] text-slate-400 font-bold">آخر تحديث</p>
                                <p class="font-bold text-slate-700 dark:text-slate-300">{{ $course->updated_at->format('Y/m/d') }}</p>
                            </div>

                            <div class="h-8 w-[1px] bg-slate-100 dark:bg-slate-700/50 hidden sm:block"></div>

                            <div>
                                <p class="text-[10px] text-slate-400 font-bold">التقييم</p>
                                <div class="flex items-center gap-1 mt-0.5">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">4.9</span>
                                    <svg class="w-3.5 h-3.5 fill-current text-yellow-400" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- About Course Section --}}
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700/60 shadow-sm">
                        <h2 class="text-xl font-black text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                            تفاصيل وتفاصيل الدورة
                        </h2>
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium space-y-4">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    {{-- Course Curriculum --}}
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-700/60 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                                الدروس والمحتوى
                            </h2>
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-bold">
                                {{ $course->lessons->count() ?? 0 }} درس
                            </span>
                        </div>

                        {{-- Lessons List --}}
                        <div class="space-y-3">
                            @forelse($course->lessons ?? [] as $index => $lesson)
                                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-transparent dark:border-slate-700/30 hover:border-indigo-500/30 dark:hover:border-indigo-500/40 hover:bg-indigo-50/20 dark:hover:bg-indigo-950/10 transition duration-300 group cursor-pointer">
                                    <div class="flex items-center gap-4">
                                        <span class="w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-sm font-black text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 group-hover:border-indigo-500 transition-colors">
                                            {{ sprintf('%02d', $index + 1) }}
                                        </span>
                                        <span class="font-bold text-slate-700 dark:text-slate-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $lesson->title }}
                                        </span>
                                    </div>
                                    <div class="text-slate-400 dark:text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-400 dark:text-slate-500 text-sm font-medium">
                                    لم يتم رفع دروس لهذا الكورس بعد.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- ══ Right Column: Sticky Pricing & Action Card ══ --}}
                <div class="lg:col-span-1 lg:sticky lg:top-12">
                    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700/60 shadow-xl overflow-hidden">

                        {{-- Course Image --}}
                        <div class="p-3 pb-0">
                            <div class="h-56 rounded-[2rem] overflow-hidden bg-slate-100 dark:bg-slate-900">
                                <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/default-course.jpg') }}"
                                     alt="{{ $course->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{-- Details & Actions --}}
                        <div class="p-6">
                            <div class="flex flex-col mb-6">
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">استثمار الكورس</span>
                                <span class="text-3xl font-black text-slate-900 dark:text-white">
                                    {{ $course->price > 0 ? $course->price . ' ج.م' : 'مجاناً' }}
                                </span>
                            </div>

                            {{-- Enrollment Logics identical to your grid --}}
                            <div class="space-y-3">
                                @if (!$course->students->contains(auth()->id()))
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                        @csrf
                                        <button class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-600/20 active:scale-[0.98] transition-all duration-200">
                                            اشترك الآن وابدأ التعلم
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full py-4 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold rounded-2xl cursor-not-allowed border border-emerald-500/20 text-center block">
                                        أنت مشترك بالفعل في هذا الكورس
                                    </button>
                                @endif

                                <a href="#" class="w-full py-3 bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:hover:bg-slate-950 text-slate-600 dark:text-slate-300 font-bold rounded-2xl border border-slate-200 dark:border-slate-700 text-center block transition">
                                    تواصل مع الدعم الفني
                                </a>
                            </div>

                            {{-- Course Features --}}
                            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700/50 space-y-3.5 text-xs font-bold text-slate-500 dark:text-slate-400">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>مشاهدة مدى الحياة في أي وقت ومن أي جهاز</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>ملفات تدريبية وتطبيقات عملية مرفقة</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>امتحانات وتكليفات دورية لمتابعة مستواك</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
