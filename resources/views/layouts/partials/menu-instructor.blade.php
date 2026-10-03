@php
    $groups = [
        [
            'title' => 'الرئيسية',
            'links' => [[
                'route' => 'instructor.dashboard',
                'pattern' => 'instructor.dashboard',
                'icon' => 'fa-solid fa-gauge-high',
                'label' => 'لوحة التحكم',
                'tone' => 'bg-coral-500/10 text-coral-600 dark:text-coral-300',
            ]],
        ],
        [
            'title' => 'المحتوى',
            'links' => [
                [
                    'route' => 'instructor.courses.create',
                    'pattern' => 'instructor.courses.create',
                    'icon' => 'fa-solid fa-circle-plus',
                    'label' => 'إضافة كورس',
                    'tone' => 'bg-amber-500/10 text-amber-600 dark:text-amber-300',
                ],
                [
                    'route' => 'instructor.sections.create',
                    'pattern' => 'instructor.sections.*',
                    'icon' => 'fa-solid fa-layer-group',
                    'label' => 'السيكشنز والدروس',
                    'tone' => 'bg-brand-500/10 text-brand-600 dark:text-brand-300',
                ],
            ],
        ],
        [
            'title' => 'الحساب',
            'links' => [[
                'route' => 'instructor.profile.show',
                'pattern' => 'instructor.profile.*',
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
