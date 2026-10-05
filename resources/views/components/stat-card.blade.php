@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'tone' => 'brand',
    'progress' => null,
    'suffix' => null,
    'trend' => null,
    'trendDirection' => 'up',
    'sparkline' => null,
])

@php
    /* HeroUI: مربع أيقونة soft + شريط solid بنفس النبرة (accent / success / warning / danger) */
    $tones = [
        'brand' => [
            'box' => 'bg-accent-soft text-accent-soft-foreground',
            'bar' => 'bg-accent',
            'text' => 'text-brand-600 dark:text-brand-300',
        ],
        'violet' => [
            'box' => 'bg-accent-soft text-accent-soft-foreground',
            'bar' => 'bg-accent',
            'text' => 'text-violet-600 dark:text-violet-300',
        ],
        'coral' => [
            'box' => 'bg-warning-soft text-warning-soft-foreground',
            'bar' => 'bg-warning',
            'text' => 'text-coral-600 dark:text-coral-300',
        ],
        'sun' => [
            'box' => 'bg-warning-soft text-warning-soft-foreground',
            'bar' => 'bg-warning',
            'text' => 'text-amber-600 dark:text-amber-300',
        ],
        'emerald' => [
            'box' => 'bg-success-soft text-success-soft-foreground',
            'bar' => 'bg-success',
            'text' => 'text-emerald-600 dark:text-emerald-300',
        ],
        'sky' => [
            'box' => 'bg-accent-soft text-accent-soft-foreground',
            'bar' => 'bg-accent',
            'text' => 'text-sky-600 dark:text-sky-300',
        ],
        'rose' => [
            'box' => 'bg-danger-soft text-danger-soft-foreground',
            'bar' => 'bg-danger',
            'text' => 'text-rose-600 dark:text-rose-300',
        ],
    ];

    $palette = $tones[$tone] ?? $tones['brand'];
    $trendUp = $trendDirection !== 'down';

    /* sparkline اختياري: أرقام 0..100 */
    $sparkPoints = collect($sparkline ?? [])
        ->filter(fn ($point) => is_numeric($point))
        ->map(fn ($point) => max(0, min(100, (float) $point)))
        ->values();

    $sparkPath = null;

    if ($sparkPoints->count() > 1) {
        $step = 100 / ($sparkPoints->count() - 1);
        $sparkPath = $sparkPoints
            ->map(fn ($point, $index) => round($point * 1.6, 2) . ',' . round(100 - $point, 2))
            ->reduce(function ($carry, $point, $index) use ($step) {
                return $carry . ($index === 0 ? '' : ' ') . $point;
            }, '');
    }
@endphp

<div {{ $attributes->class(['surface-card group relative overflow-hidden p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-brand']) }}>
    <div class="flex items-start gap-4">
        @if ($icon)
            <span class="icon-box-lg {{ $palette['box'] }}">
                <i class="{{ $icon }}" aria-hidden="true"></i>
            </span>
        @endif

        <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-bold text-ink-muted">{{ $title }}</p>

            <p class="mt-1 flex items-baseline gap-1.5 truncate text-3xl font-extrabold text-ink dark:text-mist">
                {{ $slot }}
                @if ($suffix)
                    <span class="text-base font-extrabold {{ $palette['text'] }}">{{ $suffix }}</span>
                @endif
            </p>

            @if ($trend || $description)
                <div class="mt-2 flex flex-wrap items-center gap-2">
                    @if ($trend)
                        <span @class([
                            'inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-extrabold',
                            'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' => $trendUp,
                            'bg-rose-500/10 text-rose-600 dark:text-rose-300' => ! $trendUp,
                        ])>
                            <i @class([
                                'fa-solid fa-arrow-trend-up',
                                'fa-solid fa-arrow-trend-down' => ! $trendUp,
                            ]) aria-hidden="true"></i>
                            {{ $trend }}
                        </span>
                    @endif

                    @isset($trendNote)
                        <span class="text-xs font-bold text-ink-soft">{{ $trendNote }}</span>
                    @endisset

                    @if ($description)
                        <span class="truncate text-xs font-bold text-ink-soft">{{ $description }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if (! is_null($progress))
        <div class="mt-4 h-2 w-full overflow-hidden rounded-full bg-default" role="progressbar"
            aria-valuenow="{{ (int) $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $title }}">
            <div class="h-full rounded-full {{ $palette['bar'] }} transition-[width] duration-500"
                style="width: {{ max(0, min(100, (int) $progress)) }}%"></div>
        </div>
    @endif

    {{-- sparkline زخرفي --}}
    @if ($sparkPath)
        <svg class="pointer-events-none mt-4 h-10 w-full opacity-80" viewBox="0 0 100 100" preserveAspectRatio="none"
            aria-hidden="true">
            <polyline points="{{ $sparkPath }}" fill="none" stroke="currentColor" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round"
                class="{{ $palette['text'] }}" />
        </svg>
    @endif

    {{-- شريط light ملوّن يمنح الكارت طاقة بصرية --}}
    <span aria-hidden="true"
        class="pointer-events-none absolute inset-x-0 bottom-0 h-1 {{ $palette['bar'] }} opacity-0 transition-opacity duration-200 group-hover:opacity-100"></span>
</div>
