@extends('layouts.master')
@section('title', 'E Learning Platform')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-900 transition-colors duration-300">

    @include('layouts.partials.header')

    {{-- ══ HERO ══ --}}
    <section class="relative overflow-hidden min-h-[90vh] flex items-center">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-indigo-100 dark:bg-indigo-900/30 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-purple-100 dark:bg-purple-900/30 rounded-full blur-[100px] opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-8 w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center py-20 relative z-10">

            {{-- Text --}}
            <div class="text-right space-y-6">
                <span class="inline-block bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 text-xs font-bold px-4 py-2 rounded-full border border-indigo-100 dark:border-indigo-700">
                    🚀 انطلق نحو مستقبل أفضل
                </span>
                <h1 class="text-5xl md:text-6xl font-black text-slate-900 dark:text-white leading-tight">
                    ابدأ رحلة<br>
                    <span class="text-indigo-600 dark:text-indigo-400">تعلم فريدة</span><br>
                    <span class="text-3xl md:text-4xl font-bold text-slate-500 dark:text-slate-400">من نوعها</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-lg leading-relaxed max-w-md mr-auto">
                    انضم إلى منصتنا التعليمية اليوم واحصل على وصول غير محدود لأفضل الدورات التدريبية المقدمة من نخبة من المحاضرين.
                </p>
                <div class="flex items-center gap-4 justify-end">
                    <a href="{{ route('auth.register') }}"
                        class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:-translate-y-0.5 transform duration-200">
                        ابدأ التعلم مجاناً
                    </a>
                    <a href="#courses" class="flex items-center gap-2 text-slate-600 dark:text-slate-400 font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                        <span class="w-10 h-10 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full flex items-center justify-center shadow-sm">▶</span>
                        اكتشف الدورات
                    </a>
                </div>
                <div class="flex items-center gap-6 justify-end pt-4 border-t border-gray-100 dark:border-slate-700">
                    <div class="text-center">
                        <p class="text-2xl font-black text-slate-800 dark:text-white">+10k</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold">طالب نشط</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200 dark:bg-slate-700"></div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-slate-800 dark:text-white">+500</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold">دورة تدريبية</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200 dark:bg-slate-700"></div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-slate-800 dark:text-white">98%</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold">نسبة رضا</p>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="relative flex justify-center">
                <div class="relative w-full max-w-md">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl shadow-indigo-100 dark:shadow-slate-900 p-8 border border-gray-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 px-3 py-1 rounded-full">● مباشر الآن</span>
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-semibold">دورة Laravel المتقدمة</span>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl h-44 flex items-center justify-center mb-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                </div>
                                <p class="text-slate-600 dark:text-slate-300 font-bold text-sm">Full-Stack Development</p>
                                <p class="text-slate-400 dark:text-slate-500 text-xs">Laravel + Next.js</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="font-bold text-slate-700 dark:text-slate-200">تقدمك في الدورة</span>
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">72%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2.5">
                                <div class="bg-gradient-to-l from-indigo-600 to-purple-500 h-2.5 rounded-full" style="width:72%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="float absolute -bottom-4 -right-4 bg-white dark:bg-slate-800 rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3 border border-gray-100 dark:border-slate-700">
                        <div class="w-9 h-9 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-slate-500">تم إكمال</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200">كورس البرمجة ✓</p>
                        </div>
                    </div>
                    <div class="float absolute -top-4 -left-4 bg-indigo-600 text-white rounded-2xl shadow-xl px-4 py-3" style="animation-delay:1.5s">
                        <p class="text-xs font-bold">⭐ 4.9 تقييم</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FEATURES ══ --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/50 transition-colors duration-300" id="courses">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-14">
                <span class="inline-block bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 text-xs font-bold px-4 py-2 rounded-full mb-4 border border-indigo-100 dark:border-indigo-800">لماذا تختار منصتنا؟</span>
                <h2 class="text-4xl font-black text-slate-900 dark:text-white">كل ما تحتاجه في مكان واحد</h2>
                <p class="text-slate-400 dark:text-slate-500 mt-3 text-lg">منصة متكاملة صُممت لتجربة تعليمية استثنائية</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-gray-100 dark:border-slate-700 hover:shadow-xl hover:shadow-indigo-50 dark:hover:shadow-slate-900 transition-all duration-300 hover:-translate-y-1 text-right">
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">محتوى فيديو عالي الجودة</h3>
                    <p class="text-slate-400 dark:text-slate-500 leading-relaxed">دروس مسجلة بأعلى جودة مع إمكانية المشاهدة في أي وقت ومن أي مكان</p>
                </div>
                <div class="bg-indigo-600 rounded-3xl p-8 text-right hover:shadow-xl hover:shadow-indigo-200 dark:hover:shadow-indigo-900/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">شهادات معتمدة</h3>
                    <p class="text-indigo-200 leading-relaxed">احصل على شهادات إتمام معتمدة يمكنك إضافتها لـ LinkedIn وسيرتك الذاتية</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-gray-100 dark:border-slate-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-right">
                    <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">دعم مباشر من المحاضرين</h3>
                    <p class="text-slate-400 dark:text-slate-500 leading-relaxed">تواصل مباشر مع المحاضرين واحصل على إجابات لأسئلتك في أسرع وقت</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section class="py-20 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-8 text-center">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-14 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-black text-white mb-4">جاهز تبدأ رحلتك؟</h2>
                    <p class="text-indigo-200 text-lg mb-8">انضم لأكثر من 10,000 طالب وابدأ التعلم اليوم مجاناً</p>
                    <a href="{{ route('auth.register') }}"
                        class="inline-block bg-white text-indigo-600 font-black px-10 py-4 rounded-2xl hover:bg-indigo-50 transition shadow-xl text-base">
                        سجل الآن مجاناً 🚀
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
