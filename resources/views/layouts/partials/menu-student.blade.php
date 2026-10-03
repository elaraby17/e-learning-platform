@php
    $groups = [
        [
            'title' => 'الرئيسية',
            'links' => [
                [
                    'route' => 'student.home',
                    'pattern' => 'student.home',
                    'icon' => 'fa-solid fa-house',
                    'label' => 'الرئيسية',
                    'tone' => 'bg-brand-500/10 text-brand-600 dark:text-brand-300',
                ],
                [
                    'route' => 'courses',
                    'pattern' => 'courses',
                    'icon' => 'fa-solid fa-book-open',
                    'label' => 'كورساتي',
                    'tone' => 'bg-sky-500/10 text-sky-600 dark:text-sky-300',
                ],
            ],
        ],
        [
            'title' => 'الاستكشاف',
            'links' => [[
                'route' => 'all-courses',
                'pattern' => 'all-courses*',
                'icon' => 'fa-solid fa-compass',
                'label' => 'جميع الكورسات',
                'tone' => 'bg-violet-500/10 text-violet-600 dark:text-violet-300',
            ]],
        ],
        [
            'title' => 'الحساب',
            'links' => [[
                'route' => 'profile.show',
                'pattern' => 'profile.*',
                'icon' => 'fa-solid fa-user',
                'label' => 'الملف الشخصي',
                'tone' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300',
            ]],
        ],
    ];

    $menuGroups = array_values(array_filter(array_map(function ($group) {
        $group['links'] = array_map(fn ($link) => [
            'href' => route($link['route']),
            'label' => $link['label'],
            'icon' => $link['icon'],
            'pattern' => $link['pattern'],
            'tone' => $link['tone'],
        ], array_values(array_filter($group['links'], fn ($link) => Route::has($link['route']))));

        return $group['links'] ? $group : null;
    }, $groups)));
@endphp

<div class="space-y-6">
    @foreach ($menuGroups as $group)
        <div>
            <p class="sidebar-label mb-2 px-3 text-xs font-extrabold tracking-wider text-ink-soft uppercase">
                {{ $group['title'] }}
            </p>
            <x-sidebar-link :links="$group['links']" />
        </div>
    @endforeach
</div>
