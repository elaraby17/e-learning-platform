@extends('layouts.app')

@section('title', 'إدارة الكورسات')

@section('page-breadcrumb')
    <a href="{{ route('admin.dashboard') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">الرئيسية</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <span class="text-brand-600 dark:text-brand-300">الكورسات</span>
@endsection

@section('content')
    <x-page-header title="إدارة الكورسات" icon="fa-solid fa-book-open"
        description="كل الكورسات الموجودة في المنصة، تقدر تعدل أو تحذف أي كورس.">
        <x-slot:actions>
            <x-button icon="fa-solid fa-plus" :href="route('instructor.courses.create')">كورس جديد</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card :padded="false">
        <x-slot:actions>
            <x-badge variant="brand" icon="fa-solid fa-book-open">{{ $courses->total() }} كورس</x-badge>
        </x-slot:actions>

        <x-data-table>
            <x-slot:head>
                <tr>
                    <th class="table-head-cell">الكورس</th>
                    <th class="table-head-cell text-center">المدرس</th>
                    <th class="table-head-cell text-center">القسم</th>
                    <th class="table-head-cell text-center">الطلاب</th>
                    <th class="table-head-cell text-center">السعر</th>
                    <th class="table-head-cell text-center">الحالة</th>
                    <th class="table-head-cell text-end">الإجراءات</th>
                </tr>
            </x-slot:head>

            @forelse ($courses as $course)
                <tr class="transition-colors hover:bg-brand-50/40 dark:hover:bg-brand-500/5">
                    <td class="table-body-cell">
                        <p class="truncate font-extrabold text-ink dark:text-white">{{ $course->title }}</p>
                    </td>

                    <td class="table-body-cell text-center">{{ $course->instructor->name ?? '-' }}</td>
                    <td class="table-body-cell text-center">{{ $course->category->name ?? 'بدون تصنيف' }}</td>
                    <td class="table-body-cell text-center font-bold">{{ $course->enrollments_count }}</td>

                    <td class="table-body-cell text-center">
                        <x-badge :variant="$course->price > 0 ? 'brand' : 'success'">
                            {{ $course->price > 0 ? $course->price . ' ج.م' : 'مجاناً' }}
                        </x-badge>
                    </td>

                    <td class="table-body-cell text-center">
                        @if ($course->status === 'published')
                            <x-badge variant="success" dot>منشور</x-badge>
                        @else
                            <x-badge variant="warning" dot>مسودة</x-badge>
                        @endif
                    </td>

                    <td class="table-body-cell">
                        <div class="flex items-center justify-end gap-2">
                            <x-button variant="secondary" size="sm" icon="fa-solid fa-pen"
                                :href="route('instructor.courses.edit', $course)">تعديل</x-button>

                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                data-confirm="هل أنت متأكد أنك تريد حذف الكورس ({{ $course->title }}) نهائياً؟">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash">حذف</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-14">
                        <x-empty-state title="لا توجد كورسات" description="لسه محدش أضاف كورسات في المنصة."
                            icon="fa-solid fa-book-open" />
                    </td>
                </tr>
            @endforelse
        </x-data-table>

        @if ($courses->hasPages())
            <x-slot:footer>
                <div class="flex justify-center">{{ $courses->links() }}</div>
            </x-slot:footer>
        @endif
    </x-card>
@endsection
