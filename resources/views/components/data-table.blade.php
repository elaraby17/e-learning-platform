@props([
    'head' => null,
    'empty' => null,
    'hint' => true,
])

{{-- data-table · header مائل للـ brand + hover ملوّن + أزرار أيقونات.
     على الموبايل: يبقى الجدول قابلاً للسحب (نفس منطق الصفحات الحالية). --}}
<div {{ $attributes->class(['relative overflow-hidden rounded-2xl']) }}>
    <div class="scroll-x-hint">
        <table class="w-full min-w-full border-collapse text-start">
            @if ($head)
                <thead class="bg-brand-500/8 dark:bg-brand-500/10">
                    {{ $head }}
                </thead>
            @endif

            <tbody class="divide-y divide-slate-100 dark:divide-navy-border/70 [&>tr]:transition-colors [&>tr:hover]:bg-brand-500/5 dark:[&>tr:hover]:bg-white/5">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($hint)
        <p class="mt-2 flex items-center justify-center gap-1.5 text-xs font-bold text-ink-soft md:hidden">
            <i class="fa-solid fa-arrows-left-right" aria-hidden="true"></i>
            اسحب أفقياً لعرض المزيد
        </p>
    @endif
</div>
