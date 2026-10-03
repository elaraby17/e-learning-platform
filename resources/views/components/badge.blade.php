@props([
    'variant' => 'neutral',
    'icon' => null,
    'dot' => false,
])

@php
    $variants = [
        'brand' => 'bg-brand-500/10 text-brand-700 dark:text-brand-300',
        'violet' => 'bg-violet-500/10 text-violet-700 dark:text-violet-300',
        'coral' => 'bg-coral-500/10 text-coral-700 dark:text-coral-300',
        'success' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300',
        'danger' => 'bg-rose-500/10 text-rose-700 dark:text-rose-300',
        'warning' => 'bg-amber-500/10 text-amber-700 dark:text-amber-300',
        'info' => 'bg-sky-500/10 text-sky-700 dark:text-sky-300',
        'neutral' => 'bg-slate-500/10 text-slate-700 dark:text-mist/80',
        'accent' => 'bg-accent-gradient text-white',
    ];

    $dotColors = [
        'brand' => 'bg-brand-500',
        'violet' => 'bg-violet-500',
        'coral' => 'bg-coral-500',
        'success' => 'bg-emerald-500',
        'danger' => 'bg-rose-500',
        'warning' => 'bg-amber-500',
        'info' => 'bg-sky-500',
        'neutral' => 'bg-slate-400',
        'accent' => 'bg-white',
    ];
@endphp

<span {{ $attributes->class([
        'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-extrabold whitespace-nowrap',
        $variants[$variant] ?? $variants['neutral'],
    ]) }}>
    @if ($dot)
        <span class="h-1.5 w-1.5 rounded-full {{ $dotColors[$variant] ?? $dotColors['neutral'] }}" aria-hidden="true"></span>
    @endif
    @if ($icon)
        <i class="{{ $icon }} text-[10px]" aria-hidden="true"></i>
    @endif
    {{ $slot }}
</span>