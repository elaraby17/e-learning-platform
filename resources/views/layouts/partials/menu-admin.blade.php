@php
    /* كل مجموعة: عنوان صغير + روابطها (أيقونة كل رابط بلون مختلف) */
    $groups = [
        [
            'title' => 'الرئيسية',
            'links' => [[
                'route' => 'admin.dashboard',
                'pattern' => 'admin.dashboard',
                'icon' => 'fa-solid fa-gauge-high',
                'label' => 'لوحة التحكم',
                'tone' => 'bg-violet-500/10 text-violet-600 dark:text-violet-300',
            ]],
        ],
        [
            'title' => 'المحتوى',
            'links' => [
                [
                    'route' => 'admin.courses.index',
                    'pattern' => 'admin.courses.*',
                    'icon' => 'fa-solid fa-book-open',
                    'label' => 'الكورسات',
                    'tone' => 'bg-sky-500/10 text-sky-600 dark:text-sky-300',
                ],
                [
                    'route' => 'admin.categories.index',
                    'pattern' => 'admin.categories.*',
                    'icon' => 'fa-solid fa-tags',
                    'label' => 'التصنيفات',
                    'tone' => 'bg-amber-500/10 text-amber-600 dark:text-amber-300',
                ],
            ],
        ],
        [
            'title' => 'الإدارة',
            'links' => [
                [
                    'route' => 'admin.users.index',
                    'pattern' => 'admin.users.*',
                    'icon' => 'fa-solid fa-users',
                    'label' => 'المستخدمون',
                    'tone' => 'bg-coral-500/10 text-coral-600 dark:text-coral-300',
                ],
                [
                    'route' => 'admin.profile.show',
                    'pattern' => 'admin.profile.*',
                    'icon' => 'fa-solid fa-user',
                    'label' => 'الملف الشخصي',
                    'tone' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300',
                ],
            ],
        ],
    ];

    $menuGroups = array_values(array_filter(array_map(function ($group) {
        /* نتحقق من وجود الـ route قبل بناء الـ href */
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
