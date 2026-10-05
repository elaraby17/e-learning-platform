@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    {{-- ══ Hero تدرّج بلون دور الأدمن ══ --}}
    <x-page-hero icon="fa-solid fa-shield-halved" eyebrow="مدير النظام" greeting="أهلاً بك"
        :name="auth()->user()->name"
        message="لديك نظرة سريعة على أداء المنصة: المستخدمون، الكورسات، الاشتراكات، والإيرادات.">
        <x-slot:actions>
            @if (Route::has('admin.users.create'))
                <x-button size="lg" class="bg-white! text-ink! shadow-card hover:bg-white/90"
                    icon="fa-solid fa-user-plus" :href="route('admin.users.create')">مستخدم جديد</x-button>
            @endif
            @if (Route::has('admin.courses.index'))
                <x-button size="lg" variant="secondary" class="border-white/40! bg-white/10! text-white! hover:bg-white/20!"
                    icon="fa-solid fa-layer-group" :href="route('admin.courses.index')">إدارة الكورسات</x-button>
            @endif
        </x-slot:actions>

        <x-slot:footer>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm font-bold text-white/85">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-users text-brand-200" aria-hidden="true"></i>
                    {{ $total_users ?? 0 }} مستخدم
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-brand-200" aria-hidden="true"></i>
                    {{ $total_courses ?? 0 }} كورس
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-brand-200" aria-hidden="true"></i>
                    {{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
                </span>
            </div>
        </x-slot:footer>
    </x-page-hero>

    {{-- ══ KPIs ══ --}}
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card title="إجمالي المستخدمين" icon="fa-solid fa-users" tone="brand" trend="+12%"
            trend-note="عن الشهر الماضي" :sparkline="[38, 46, 44, 58, 66, 78, 92]">
            {{ $total_users ?? 0 }}
        </x-stat-card>

        <x-stat-card title="إجمالي الكورسات" icon="fa-solid fa-graduation-cap" tone="violet" trend="+8%"
            trend-note="هذا الشهر" :sparkline="[22, 30, 34, 33, 45, 52, 60]">
            {{ $total_courses ?? 0 }}
        </x-stat-card>

        <x-stat-card title="إجمالي التسجيلات" icon="fa-solid fa-user-plus" tone="emerald" trend="+21%"
            trend-note="مقارنة بالشهر السابق" :sparkline="[18, 24, 30, 28, 44, 52, 68]">
            {{ $total_enrollments ?? 0 }}
        </x-stat-card>

        <x-stat-card title="إجمالي الأرباح" icon="fa-solid fa-sack-dollar" tone="sun" trend="+15%"
            trend-note="إيرادات متزايدة" :sparkline="[25, 32, 30, 40, 48, 55, 70]">
            ${{ number_format($total_revenue ?? 0, 2) }}
        </x-stat-card>
    </div>

    {{-- ══ Tables ══ --}}
  <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

    {{-- ===================== أحدث المسجلين ===================== --}}
    <x-card title="أحدث المسجلين" description="آخر 10 حسابات تم تسجيلها"
            icon="fa-solid fa-user-clock" :padded="false">

        <x-slot:actions>
            @if (Route::has('admin.users.index'))
                <x-button variant="ghost" size="sm" icon="fa-solid fa-arrow-left"
                          :href="route('admin.users.index')">
                    عرض الكل
                </x-button>
            @endif
        </x-slot:actions>

        <x-data-table>
            <x-slot:head>
                <tr>
                    <th class="table-head-cell">المستخدم</th>
                    <th class="table-head-cell whitespace-nowrap">تاريخ التسجيل</th>
                    <th class="table-head-cell text-end">الدور</th>
                </tr>
            </x-slot:head>

            @forelse ($users as $user)
                <tr>
                    <td class="table-body-cell">
                        <div class="flex min-w-0 items-center gap-3">
                            <x-avatar :name="$user->name" size="h-10 w-10" :image="$user->image" />
                            <div class="min-w-0">
                                <p class="truncate font-extrabold">{{ $user->name }}</p>
                                <p class="text-xs text-ink-muted">#{{ $user->id }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="table-body-cell whitespace-nowrap">
                        <p class="text-sm font-bold" dir="ltr">
                            {{ $user->created_at?->format('Y-m-d') }}
                        </p>
                        <p class="text-xs text-ink-muted">
                            {{ $user->created_at?->diffForHumans() }}
                        </p>
                    </td>

                    <td class="table-body-cell text-end">
                        @switch($user->role)
                            @case('admin')
                                <x-badge variant="danger" dot>مدير</x-badge>
                                @break
                            @case('instructor')
                                <x-badge variant="info" dot>محاضر</x-badge>
                                @break
                            @default
                                <x-badge variant="neutral" dot>طالب</x-badge>
                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-10">
                        <x-empty-state title="لا يوجد مستخدمون جدد"
                                       description="لا حسابات مسجلة حالياً."
                                       icon="fa-solid fa-user-slash" />
                    </td>
                </tr>
            @endforelse
        </x-data-table>
    </x-card>

    {{-- ===================== أحدث الاشتراكات ===================== --}}
    <x-card title="أحدث الاشتراكات" description="آخر 10 اشتراكات في الكورسات"
            icon="fa-solid fa-receipt" :padded="false">

        <x-data-table>
            <x-slot:head>
                <tr>
                    <th class="table-head-cell">الطالب</th>
                    <th class="table-head-cell">الكورس</th>
                    <th class="table-head-cell text-end">السعر</th>
                </tr>
            </x-slot:head>

            @forelse ($recent_enrollments as $enrollment)
                @php
                    $student = $enrollment->student;
                    $course  = $enrollment->course;
                    $name    = $student?->name ?? 'طالب محذوف';
                    $price   = $enrollment->price_paid ?? $course?->price;
                @endphp

                <tr>
                    {{-- الطالب --}}
                    <td class="table-body-cell">
                        <div class="flex min-w-0 items-center gap-3">
                            @if ($student)
                                <x-avatar :name="$name" size="h-10 w-10" :image="$student->image" />
                            @else
                                <span class="grid size-10 shrink-0 place-items-center rounded-full bg-default text-slate-400 dark:bg-white/5">
                                    <i class="fa-solid fa-user-slash text-xs"></i>
                                </span>
                            @endif

                            <div class="min-w-0">
                                <p @class([
                                    'truncate font-extrabold',
                                    'italic text-ink-muted' => ! $student,
                                ])>{{ $name }}</p>
                                <p class="text-xs text-ink-muted">
                                    {{ $enrollment->created_at?->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- الكورس --}}
                    <td class="table-body-cell">
                        <span class="line-clamp-2 max-w-[14rem] font-extrabold text-accent">
                            {{ $course?->title ?? 'كورس محذوف' }}
                        </span>
                    </td>

                    {{-- السعر --}}
                    <td class="table-body-cell text-end whitespace-nowrap">
                        @if ($price === null)
                            <span class="text-ink-muted">—</span>
                        @elseif ($price > 0)
                            <span class="font-extrabold" dir="ltr">${{ number_format($price, 2) }}</span>
                        @else
                            <x-badge variant="success" dot>مجاني</x-badge>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-10">
                        <x-empty-state title="لا توجد اشتراكات"
                                       description="لا توجد اشتراكات جديدة حالياً."
                                       icon="fa-solid fa-receipt" />
                    </td>
                </tr>
            @endforelse
        </x-data-table>
    </x-card>
</div>

    {{-- ══ Quick links ══ --}}
    <div class="surface-card mt-6 overflow-hidden p-6 sm:p-8">
        <h2 class="mb-5 flex items-center gap-2 text-lg font-extrabold text-ink dark:text-mist">
            <span class="icon-box bg-accent-gradient text-white shadow-accent">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
            </span>
            روابط سريعة
        </h2>

        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach ([
                ['route' => 'admin.users.index', 'icon' => 'fa-solid fa-users-gear', 'label' => 'إدارة المستخدمين'],
                ['route' => 'admin.courses.index', 'icon' => 'fa-solid fa-layer-group', 'label' => 'إدارة الكورسات'],
                ['route' => 'admin.categories.index', 'icon' => 'fa-solid fa-list-check', 'label' => 'التصنيفات'],
                ['route' => 'admin.dashboard', 'icon' => 'fa-solid fa-gears', 'label' => 'لوحة النظام'],
            ] as $shortcut)
                @if (Route::has($shortcut['route']))
                    <a href="{{ route($shortcut['route']) }}"
                        class="group flex flex-col items-center gap-2 rounded-2xl border border-separator bg-canvas p-4 text-center transition hover:-translate-y-0.5 hover:border-accent hover:bg-white hover:shadow-accent dark:border-navy-border dark:bg-navy/40 dark:hover:border-accent dark:hover:bg-navy-elevated">
                        <span class="bg-accent-gradient flex size-11 items-center justify-center rounded-xl text-white shadow-accent transition group-hover:scale-110">
                            <i class="{{ $shortcut['icon'] }}" aria-hidden="true"></i>
                        </span>
                        <span class="text-sm font-extrabold text-ink dark:text-mist">{{ $shortcut['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endsection
