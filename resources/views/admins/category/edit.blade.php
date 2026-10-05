@extends('layouts.app')

@section('title', 'تعديل قسم')

@section('page-breadcrumb')
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">الرئيسية</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <a href="{{ route('admin.categories.index') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">التصنيفات</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <span class="text-brand-600 dark:text-brand-300">تعديل</span>
@endsection

@section('content')
    <x-page-header title="تعديل القسم" icon="fa-solid fa-pen-to-square"
        :description="'تعديل بيانات القسم: ' . $category->name">
        <x-slot:actions>
            <x-button variant="secondary" size="sm" icon="fa-solid fa-arrow-right"
                :href="route('admin.categories.index')">رجوع للقائمة</x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- ══ نموذج التعديل ══ --}}
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="mb-6">
        @csrf
        @method('PUT')

        <x-form-card title="بيانات القسم" icon="fa-solid fa-pen" description="حدّث اسم القسم ووصفه ثم احفظ التغييرات."
            submit-label="حفظ التغييرات" class="grid grid-cols-1 gap-5">
            <x-input name="name" label="اسم القسم" placeholder="مثال: إلكترونيات، البرمجة..." required
                :value="$category->name" icon="fa-solid fa-tag" />

            <x-textarea name="description" label="الوصف" rows="3" placeholder="اكتب وصفاً مختصراً للقسم..."
                :value="$category->description" />
        </x-form-card>
    </form>

    {{-- ══ جدول الأقسام ══ --}}
    <x-card title="كل الأقسام" description="عدد الأقسام: {{ $categories->count() ?? 0 }}" :padded="false">
        <x-data-table>
            <x-slot:head>
                <tr>
                    <th class="table-head-cell">اسم القسم</th>
                    <th class="table-head-cell">الوصف</th>
                    <th class="table-head-cell text-center">العمليات</th>
                </tr>
            </x-slot:head>

            @forelse ($categories as $item)
                <tr @class([
                    'transition-colors hover:bg-brand-50/40 dark:hover:bg-brand-500/5',
                    'bg-brand-50/60 dark:bg-brand-500/10' => $item->id === $category->id,
                ])>
                    <td class="table-body-cell">
                        <div class="flex items-center gap-2">
                            <span class="h-8 w-1.5 shrink-0 rounded-full bg-brand-500" aria-hidden="true"></span>
                            <span class="font-extrabold">{{ $item->name }}</span>
                        </div>
                    </td>
                    <td class="table-body-cell">
                        <span class="line-clamp-2 text-muted">
                            {{ $item->description ?? 'لا يوجد وصف حالياً' }}
                        </span>
                    </td>
                    <td class="table-body-cell">
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <x-button variant="secondary" size="sm" icon="fa-solid fa-pen"
                                :href="route('admin.categories.edit', $item)">تعديل</x-button>

                            <form method="POST" action="{{ route('admin.categories.destroy', $item) }}"
                                data-confirm="هل أنت متأكد من حذف هذا القسم؟ لا يمكن التراجع عن العملية.">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="outline-danger" size="sm" icon="fa-solid fa-trash">
                                    حذف
                                </x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-12">
                        <x-empty-state title="لا توجد أقسام" description="لا توجد أقسام مضافة حالياً بالمنصة."
                            icon="fa-solid fa-tags" />
                    </td>
                </tr>
            @endforelse
        </x-data-table>

        @if (method_exists($categories, 'links') && $categories->hasPages())
            <x-slot:footer>
                <div class="flex justify-center">{{ $categories->links() }}</div>
            </x-slot:footer>
        @endif
    </x-card>
@endsection