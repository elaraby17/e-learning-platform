@extends('layouts.app')

@section('title', 'لوحة المحاضر')

@section('content')
    {{-- ══ Hero تدرّج بلون دور المحاضر (coral → amber) ══ --}}
    <x-page-hero icon="fa-solid fa-chalkboard-user" eyebrow="لوحة المحاضر" greeting="أهلاً بك"
        :name="auth()->user()->name"
        message="إليك تقرير سريع عن أداء كورساتك وطلابك، وأحدث ما يمكنك تطويره اليوم.">
        <x-slot:actions>
            <x-button size="lg" class="bg-white! text-ink! shadow-card hover:bg-white/90" icon="fa-solid fa-plus"
                :href="route('instructor.courses.create')">إنشاء كورس</x-button>
        </x-slot:actions>

        <x-slot:footer>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm font-bold text-white/85">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-book text-amber-200" aria-hidden="true"></i>
                    {{ $total_courses ?? 0 }} كورس
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-users text-amber-200" aria-hidden="true"></i>
                    {{ $total_students ?? 0 }} طالب
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar text-amber-200" aria-hidden="true"></i>
                    {{ now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
                </span>
            </div>
        </x-slot:footer>
    </x-page-hero>

    {{-- ══ الإحصائيات ══ --}}
    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <x-stat-card title="إجمالي الكورسات" icon="fa-solid fa-book" tone="coral" trend="+5%"
            trend-note="منذ بداية الشهر" :sparkline="[20, 28, 32, 30, 44, 50, 62]">
            {{ $total_courses ?? 0 }}
        </x-stat-card>

        <x-stat-card title="إجمالي الطلاب" icon="fa-solid fa-users" tone="sun" trend="+18%"
            trend-note="اشتراكات جديدة" :sparkline="[15, 22, 28, 34, 42, 58, 74]">
            {{ $total_students ?? 0 }}
        </x-stat-card>

        <x-stat-card title="متوسط التقييم" icon="fa-solid fa-star" tone="emerald" :suffix="'★'"
            trend="+0.3" trend-note="تحسّن في رضا الطلاب" :sparkline="[60, 66, 64, 72, 78, 84, 90]">
            {{ $avg_rating ?? '0.0' }}
        </x-stat-card>
    </div>

    {{-- ══ إدارة الكورسات ══ --}}
    <x-card title="إدارة كورساتي" description="يمكنك تعديل أو حذف الكورسات الخاصة بك." icon="fa-solid fa-layer-group"
        :padded="false" class="mt-6">
        <x-slot:actions>
            <x-badge variant="accent" icon="fa-solid fa-book-open">{{ $total_courses ?? 0 }} كورس</x-badge>
        </x-slot:actions>

        <x-data-table>
            <x-slot:head>
                <tr>
                    <th class="table-head-cell">الكورس</th>
                    <th class="table-head-cell text-center">الطلاب</th>
                    <th class="table-head-cell text-center">السعر</th>
                    <th class="table-head-cell text-end">الإجراءات</th>
                </tr>
            </x-slot:head>

            @forelse ($courses as $course)
                <tr>
                    <td class="table-body-cell">
                        <div class="flex items-center gap-4">
                            <span class="bg-accent-gradient h-14 w-14 shrink-0 overflow-hidden rounded-xl">
                                <img
                                    src="{{ $course->image
                                        ? (filter_var($course->image, FILTER_VALIDATE_URL)
                                            ? $course->image
                                            : asset('storage/' . $course->image))
                                        : asset('images/logo.png') }}"
                                    alt="{{ $course->title }}" loading="lazy" data-img-fallback
                                    class="size-full object-cover">
                            </span>

                            <div class="min-w-0">
                                <p class="truncate font-extrabold text-ink dark:text-mist">{{ $course->title }}</p>
                                <p class="truncate text-sm text-ink-muted">
                                    {{ $course->category->name ?? 'بدون تصنيف' }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="table-body-cell text-center">
                        <x-badge variant="neutral" icon="fa-solid fa-users">
                            {{ $course->total_students ?? 0 }}
                        </x-badge>
                    </td>

                    <td class="table-body-cell text-center">
                        <x-badge :variant="$course->price > 0 ? 'brand' : 'success'" icon="fa-solid fa-tag">
                            {{ $course->price > 0 ? $course->price . ' ج.م' : 'مجاناً' }}
                        </x-badge>
                    </td>

                    <td class="table-body-cell">
                        <div class="flex items-center justify-end gap-2">
                            <x-button variant="secondary" size="sm" icon="fa-solid fa-pen"
                                :href="route('instructor.courses.edit', $course)">تعديل</x-button>

                            <x-button variant="secondary" size="sm" icon="fa-solid fa-list-check"
                                :href="route('instructor.sections.create', ['course' => $course->id])">المحتوى</x-button>

                            <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST"
                                data-confirm="هل أنت متأكد أنك تريد حذف هذا الكورس؟ لا يمكن التراجع عن العملية.">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash">حذف</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-16">
                        <x-empty-state title="لا توجد كورسات حالياً"
                            description="ابدأ بإنشاء أول كورس لك وشارك معرفتك مع الطلاب." icon="fa-solid fa-book-open">
                            <x-slot:actions>
                                <x-button icon="fa-solid fa-plus"
                                    :href="route('instructor.courses.create')">إنشاء كورس جديد</x-button>
                            </x-slot:actions>
                        </x-empty-state>
                    </td>
                </tr>
            @endforelse
        </x-data-table>
    </x-card>
@endsection
