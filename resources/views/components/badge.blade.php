@props([
    'variant' => 'neutral',
    'icon' => null,
    'dot' => false,
])

@php
    /*
     * HeroUI Chip: `.chip` + لون (`.chip--accent` …) + `.chip--soft` للخلفية الخفيفة
     * أو `.chip--primary` للخلفية الصلبة. الأسماء القديمة (brand / violet / info …)
     * بتتحول لأقرب لون في HeroUI عشان الـ views الحالية متتغيرش.
     */
    $variants = [
        'brand' => 'chip--accent chip--soft',
        'violet' => 'chip--accent chip--soft',
        'info' => 'chip--accent chip--soft',
        'coral' => 'chip--warning chip--soft',
        'success' => 'chip--success chip--soft',
        'danger' => 'chip--danger chip--soft',
        'warning' => 'chip--warning chip--soft',
        'neutral' => 'chip--default chip--soft',
        'accent' => 'chip--primary chip--accent',
    ];
@endphp

<span {{ $attributes->class([
        'chip gap-1.5 px-2.5 py-1 font-bold whitespace-nowrap',
        $variants[$variant] ?? $variants['neutral'],
    ]) }}>
    @if ($dot)
        <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
    @endif
    @if ($icon)
        <i class="{{ $icon }} text-[10px]" aria-hidden="true"></i>
    @endif
    {{ $slot }}
</span>
