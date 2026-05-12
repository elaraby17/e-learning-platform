@extends('layouts.master')

@section('title', 'welcome')

@section('content')


    <div class="relative min-h-screen flex items-center justify-center">

        <div
            class="absolute top-20 right-10 w-64 h-64 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float">
        </div>
        <div class="absolute bottom-20 left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"
            style="animation-delay: 2s"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

                <div class="lg:w-1/2 text-right space-y-8" data-aos="fade-left">
                    <div
                        class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold tracking-wide">
                        انطلق نحو مستقبل أفضل
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight">
                        ابدأ رحلة تعلم <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">فريدة
                            من نوعها</span>
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                        انضم إلى منصتنا التعليمية اليوم واحصل على وصول غير محدود لأفضل الدورات التدريبية المقدمة من نخبة
                        من المحاضرين، مع متابعة شخصية لتقدمك.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        @if (Route::has('register'))
                            <a href="{{ route('auth.register') }}"
                                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300">
                                ابدأ الآن - مجاناً
                            </a>
                        @endif

                        <a href="#features"
                            class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold text-lg hover:bg-slate-50 transition-all duration-300">
                            اكتشف المزيد
                        </a>
                    </div>

                    <div class="flex gap-8 pt-8 border-t border-slate-200">
                        <div>
                            <span class="block text-2xl font-bold text-slate-900">+10k</span>
                            <span class="text-sm text-slate-500">طالب نشط</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-slate-900">+500</span>
                            <span class="text-sm text-slate-500">دورة تدريبية</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative">
                    <div class="relative z-20 animate-float">
                        <div class="bg-white/40 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-2xl">
                            <img src="https://img.freepik.com/free-vector/online-learning-concept-illustration_114360-1105.jpg"
                                alt="Education" class="rounded-2xl shadow-sm">
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-6 -right-6 bg-white p-4 rounded-2xl shadow-xl z-30 flex items-center gap-3 border border-slate-100 animate-bounce">
                        <div
                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
                            ✓</div>
                        <div>
                            <p class="text-xs text-slate-500">تم إكمال</p>
                            <p class="text-sm font-bold">كورس البرمجة</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
