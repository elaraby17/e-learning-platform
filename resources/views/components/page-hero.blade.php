@props([
    'greeting' => null,
    'name' => null,
    'message' => null,
    'icon' => 'fa-solid fa-rocket',
    'eyebrow' => null,
])

@php
    $greeting = $greeting ?? 'أهلاً بك';
    $name = $name ?? (auth()->user()->name ?? '');
    $message =
        $message ??
        'استمر في التعلّم، كل خطوة جديدة تقرّبك أكثر من هدفك. جاهز ليوم مميز؟';
@endphp

<section {{ $attributes->class([
    'bg-accent-gradient relative isolate overflow-hidden rounded-3xl p-6 text-white shadow-accent sm:p-8',
]) }}>
    {{-- Decorative blobs + rings --}}
    <div class="pointer-events-none absolute -top-24 -start-16 size-72 rounded-full bg-white/15 blur-2xl"
        aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-10 -bottom-24 size-80 rounded-full bg-white/10 blur-3xl"
        aria-hidden="true"></div>
    <div class="pointer-events-none absolute top-1/2 end-8 size-40 -translate-y-1/2 rounded-full border-2 border-white/20"
        aria-hidden="true"></div>
    <div class="pointer-events-none absolute end-24 bottom-10 size-24 rounded-full border border-white/15"
        aria-hidden="true"></div>

    <div class="relative z-10 flex flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            @if ($eyebrow)
                <span
                    class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1.5 text-xs font-extrabold backdrop-blur">
                    <i class="{{ $icon }} text-[11px]" aria-hidden="true"></i>
                    {{ $eyebrow }}
                </span>
            @endif

            <h1 class="text-2xl font-extrabold text-white lg:text-3xl">
                {{ $greeting }}@if ($name), {{ $name }}@endif
            </h1>

            <p class="mt-3 max-w-2xl text-[15px] leading-relaxed text-white/85">{{ $message }}</p>
        </div>

        @isset($actions)
            <div class="flex w-full shrink-0 flex-wrap items-center gap-3 lg:w-auto">
                {{ $actions }}
            </div>
        @endisset
    </div>

    @isset($footer)
        <div class="relative z-10 mt-6 border-t border-white/20 pt-4">
            {{ $footer }}
        </div>
    @endisset
</section>
