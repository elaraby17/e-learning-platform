@props([
    'head' => null,
    'empty' => null,
    'hint' => true,
])

{{-- data-table · شكل جدول HeroUI: header بخلفية surface-secondary + فواصل خفيفة + hover.
     على الموبايل: يبقى الجدول قابلاً للسحب. --}}
<div {{ $attributes->class(['relative overflow-hidden rounded-2xl']) }}>
    <div class="scroll-x-hint">
        <table class="w-full min-w-full border-collapse text-start">
            @if ($head)
                <thead class="bg-surface-secondary">
                    {{ $head }}
                </thead>
            @endif

            <tbody class="divide-y divide-separator [&>tr]:transition-colors [&>tr:hover]:bg-default/40">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($hint)
        <p class="mt-2 flex items-center justify-center gap-1.5 text-xs font-bold text-muted md:hidden">
            <i class="fa-solid fa-arrows-left-right" aria-hidden="true"></i>
            اسحب أفقياً لعرض المزيد
        </p>
    @endif
</div>
