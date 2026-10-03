@extends('layouts.app')

@section('title', config('app.name', 'E Learning'))

@section('content')
    {{-- ══ HERO ══ --}}
    <section class="relative overflow-hidden py-12 lg:py-20">
        <div class="pointer-events-none absolute -top-24 -start-24 h-96 w-96 rounded-full bg-brand-500/20 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -end-24 h-80 w-80 rounded-full bg-brand-500/10 blur-3xl"
            aria-hidden="true"></div>

        <div class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 md:grid-cols-2">
            {{-- ══ النص ══ --}}
            <div class="space-y-6">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-brand-200 bg-brand-50 px-4 py-2 text-xs font-extrabold text-brand-700 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-300">
                    <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                    انطلق نحو مستقبل أفضل
                </span>

                <h1 class="text-4xl leading-tight font-extrabold text-ink sm:text-5xl md:text-6xl dark:text-white">
                    ابدأ رحلة<br>
                    <span class="text-brand-600 dark:text-brand-400">تعلم فريدة</span><br>
                    <span class="text-2xl font-bold text-slate-500 sm:text-3xl md:text-4xl dark:text-slate-400">
                        من نوعها
                    </span>
                </h1>

                <p class="max-w-md text-lg leading-relaxed text-slate-500 dark:text-slate-400">
                    انضم إلى منصتنا التعليمية اليوم واحصل على وصول غير محدود لأفضل الدورات التدريبية المقدمة من نخبة من
                    المحاضرين.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <x-button size="lg" icon="fa-solid fa-play" :href="route('auth.register')">
                        ابدأ التعلم مجاناً
                    </x-button>

                    <a href="#courses"
                        class="inline-flex items-center gap-2 font-bold text-slate-600 transition hover:text-brand-600 dark:text-slate-300 dark:hover:text-brand-300">
                        <span
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-surface shadow-sm dark:border-navy-border dark:bg-navy-surface">
                            <i class="fa-solid fa-play text-xs" aria-hidden="true"></i>
                        </span>
                        اكتشف الدورات
                    </a>
                </div>

                <div
                    class="flex items-center justify-end gap-6 border-t border-slate-200 pt-4 dark:border-navy-border">
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-ink dark:text-white">+10k</p>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500">طالب نشط</p>
                    </div>
                    <span class="h-10 w-px bg-slate-200 dark:bg-navy-border"></span>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-ink dark:text-white">+500</p>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500">دورة تدريبية</p>
                    </div>
                    <span class="h-10 w-px bg-slate-200 dark:bg-navy-border"></span>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-ink dark:text-white">98%</p>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500">نسبة رضا</p>
                    </div>
                </div>
            </div>

            {{-- ══ كارت التقدم ══ --}}
            <div class="relative flex justify-center">
                <div class="relative w-full max-w-md">
                    <div class="surface-card p-8">
                        <div class="mb-6 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500">دورة Laravel المتقدمة</span>
                            <x-badge variant="success" dot>مباشر الآن</x-badge>
                        </div>

                        <div
                            class="mb-6 flex h-44 items-center justify-center rounded-2xl bg-navy">
                            <div class="text-center">
                                <span
                                    class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500 shadow-brand">
                                    <i class="fa-solid fa-code text-2xl text-white" aria-hidden="true"></i>
                                </span>
                                <p class="text-sm font-extrabold text-slate-100">Full-Stack Development</p>
                                <p class="text-xs text-slate-400">Laravel + Next.js</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="font-extrabold text-ink dark:text-white">تقدمك في الدورة</span>
                                <span class="font-extrabold text-brand-600 dark:text-brand-400">72%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-navy-border">
                                <div class="h-2.5 rounded-full bg-brand-500" style="width: 72%"
                                    role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"
                                    aria-label="تقدمك في الدورة"></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="surface-card absolute -bottom-4 -end-4 flex items-center gap-3 px-4 py-3 shadow-card-lg">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-success-500">
                            <i class="fa-solid fa-check text-white" aria-hidden="true"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-slate-500">تم إكمال</p>
                            <p class="text-sm font-extrabold text-ink dark:text-white">كورس البرمجة</p>
                        </div>
                    </div>

                    <div
                        class="absolute -top-4 -start-4 rounded-2xl bg-brand-500 px-4 py-3 shadow-card-lg">
                        <p class="text-xs font-extrabold text-white">
                            <i class="fa-solid fa-star" aria-hidden="true"></i>
                            4.9 تقييم
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ المميزات ══ --}}
    <section id="courses" class="py-16">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-brand-200 bg-brand-50 px-4 py-2 text-xs font-extrabold text-brand-700 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-300">
                    لماذا تختار منصتنا؟
                </span>
                <h2 class="text-3xl font-extrabold text-ink md:text-4xl dark:text-white">كل ما تحتاجه في مكان واحد</h2>
                <p class="mt-3 text-lg text-slate-400 dark:text-slate-500">منصة متكاملة صُممت لتجربة تعليمية استثنائية</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ([
                    [
                        'icon' => 'fa-solid fa-clapperboard',
                        'title' => 'محتوى فيديو عالي الجودة',
                        'description' => 'دروس مسجلة بأعلى جودة مع إمكانية المشاهدة في أي وقت ومن أي مكان',
                        'highlight' => false,
                    ],
                    [
                        'icon' => 'fa-solid fa-certificate',
                        'title' => 'شهادات معتمدة',
                        'description' => 'احصل على شهادات إتمام معتمدة يمكنك إضافتها لـ LinkedIn وسيرتك الذاتية',
                        'highlight' => true,
                    ],
                    [
                        'icon' => 'fa-solid fa-comments',
                        'title' => 'دعم مباشر من المحاضرين',
                        'description' => 'تواصل مباشر مع المحاضرين واحصل على إجابات لأسئلتك في أسرع وقت',
                        'highlight' => false,
                    ],
                ] as $feature)
                    @if ($feature['highlight'])
                        <div
                            class="rounded-3xl bg-brand-500 p-8 transition duration-300 hover:-translate-y-1 hover:shadow-brand">
                            <span class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20">
                                <i class="{{ $feature['icon'] }} text-2xl text-white" aria-hidden="true"></i>
                            </span>
                            <h3 class="mb-3 text-xl font-extrabold text-white">{{ $feature['title'] }}</h3>
                            <p class="leading-relaxed text-brand-100">{{ $feature['description'] }}</p>
                        </div>
                    @else
                        <div class="surface-card p-8 transition duration-300 hover:-translate-y-1 hover:border-brand-200">
                            <span
                                class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-300">
                                <i class="{{ $feature['icon'] }} text-2xl" aria-hidden="true"></i>
                            </span>
                            <h3 class="mb-3 text-xl font-extrabold text-ink dark:text-white">{{ $feature['title'] }}</h3>
                            <p class="leading-relaxed text-slate-400 dark:text-slate-500">{{ $feature['description'] }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section class="pb-16">
        <div class="mx-auto max-w-4xl">
            <div class="relative overflow-hidden rounded-3xl bg-navy p-12 text-center md:p-14">
                <div class="absolute -top-16 -end-16 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl"
                    aria-hidden="true"></div>
                <div class="absolute -bottom-16 -start-16 h-64 w-64 rounded-full bg-brand-500/10 blur-3xl"
                    aria-hidden="true"></div>

                <div class="relative z-10">
                    <h2 class="mb-4 text-3xl font-extrabold text-white md:text-4xl">جاهز تبدأ رحلتك؟</h2>
                    <p class="mb-8 text-lg text-slate-400">انضم لأكثر من 10,000 طالب وابدأ التعلم اليوم مجاناً</p>

                    <x-button size="lg" class="bg-white! text-brand-600! shadow-none hover:bg-brand-50"
                        icon="fa-solid fa-rocket" :href="route('auth.register')">سجل الآن مجاناً</x-button>
                </div>
            </div>
        </div>
    </section>
@endsection