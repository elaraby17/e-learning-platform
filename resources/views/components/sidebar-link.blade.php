@props([
    'href' => null,
    'label' => null,
    'icon' => null,
    'active' => false,
    'pattern' => null,
    'links' => null,
])

@php
    $items = $links ?? [[
        'href' => $href,
        'label' => $label,
        'icon' => $icon,
        'active' => $active,
        'pattern' => $pattern,
    ]];

    /* لون مختلف لكل رابط من الـ palette (أيقونة داخل مربع ملوّن) */
    $iconTones = [
        'bg-brand-500/10 text-brand-600 dark:text-brand-300',
        'bg-violet-500/10 text-violet-600 dark:text-violet-300',
        'bg-coral-500/10 text-coral-600 dark:text-coral-300',
        'bg-amber-500/10 text-amber-600 dark:text-amber-300',
        'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300',
        'bg-sky-500/10 text-sky-600 dark:text-sky-300',
        'bg-rose-500/10 text-rose-600 dark:text-rose-300',
    ];
@endphp

<ul class="space-y-1.5">
    @foreach ($items as $link)
        @php
            $isActive = $link['active'] ?? false;

            if (! $isActive && ! empty($link['pattern'])) {
                $isActive = request()->routeIs($link['pattern']);
            }

            $linkHref = $link['href'] ?? '#';
            $tone = $link['tone'] ?? $iconTones[$loop->index % count($iconTones)];
        @endphp

        <li>
            <a href="{{ $linkHref }}" @if ($isActive) aria-current="page" @endif
                class="sidebar-link group relative flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition-all duration-200
                    {{ $isActive
                        ? 'bg-accent-gradient text-white shadow-accent'
                        : 'text-ink-muted hover:bg-canvas hover:text-ink dark:text-mist/80 dark:hover:bg-white/5 dark:hover:text-mist' }}">

                @if ($isActive)
                    <span class="absolute inset-y-2 start-0 w-1 rounded-full bg-white/80" aria-hidden="true"></span>
                @endif

                <span @class([
                    'icon-box transition-colors duration-200',
                    'bg-white/20! text-white!' => $isActive,
                    $tone => ! $isActive,
                ])>
                    <i class="{{ $link['icon'] ?? 'fa-solid fa-circle-dot' }}" aria-hidden="true"></i>
                </span>

                <span class="sidebar-label min-w-0 flex-1 truncate">{{ $link['label'] ?? '' }}</span>

                @if (! empty($link['badge']))
                    <span @class([
                        'sidebar-label shrink-0 rounded-full px-2 py-0.5 text-[11px] font-extrabold',
                        'bg-white/20 text-white' => $isActive,
                        'bg-canvas text-ink-muted dark:bg-navy-elevated dark:text-mist/80' => ! $isActive,
                    ])>{{ $link['badge'] }}</span>
                @endif

                <span class="sidebar-tooltip" role="tooltip">{{ $link['label'] ?? '' }}</span>
            </a>
        </li>
    @endforeach
</ul>
