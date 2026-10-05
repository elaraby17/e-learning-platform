@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('page-breadcrumb')
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">الرئيسية</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <span class="text-brand-600 dark:text-brand-300">المستخدمون</span>
@endsection

@section('content')
    <x-page-header title="إدارة الأعضاء والمستخدمين" icon="fa-solid fa-users"
        description="التحكم في صلاحيات المستخدمين، وتفقد حساباتهم وحالاتهم داخل المنصة.">
        <x-slot:actions>
            <x-button icon="fa-solid fa-user-plus" :href="route('admin.users.create')">إضافة مستخدم</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card :padded="false">
        <x-slot:actions>
            <x-badge variant="brand" icon="fa-solid fa-users">
                {{ $users instanceof \Illuminate\Contracts\Pagination\Paginator ? $users->total() : $users->count() }}
                مستخدم
            </x-badge>
        </x-slot:actions>

        {{-- ══ جدول سطح المكتب ══ --}}
        <div class="hidden md:block">
            <x-data-table>
                <x-slot:head>
                    <tr>
                        <th class="table-head-cell">المستخدم</th>
                        <th class="table-head-cell text-center">الهاتف</th>
                        <th class="table-head-cell text-center">الدور / الصلاحية</th>
                        <th class="table-head-cell text-center">الحالة</th>
                        <th class="table-head-cell text-end">الإجراءات</th>
                    </tr>
                </x-slot:head>

                @forelse ($users as $user)
                    <tr class="transition-colors hover:bg-brand-50/40 dark:hover:bg-brand-500/5">
                        <td class="table-body-cell">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="shrink-0 transition hover:opacity-80">
                                    <x-avatar :name="$user->name" size="h-12 w-12"
                                        :image="$user->image" />
                                </a>

                                <div class="min-w-0">
                                    <p class="truncate font-extrabold text-ink dark:text-white">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-muted" dir="ltr">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="table-body-cell text-center font-bold whitespace-nowrap" dir="ltr">
                            {{ $user->phone }}
                        </td>

                        <td class="table-body-cell text-center">
                            @if ($user->role == 'admin')
                                <x-badge variant="danger" dot>مدير</x-badge>
                            @elseif ($user->role == 'instructor')
                                <x-badge variant="info" dot>محاضر</x-badge>
                            @else
                                <x-badge variant="neutral" dot>طالب</x-badge>
                            @endif
                        </td>

                        <td class="table-body-cell text-center">
                            @if ($user->status == 'active')
                                <x-badge variant="success" dot>نشط</x-badge>
                            @else
                                <x-badge variant="warning" dot>معطل</x-badge>
                            @endif
                        </td>

                        <td class="table-body-cell">
                            <div class="flex items-center justify-end gap-2">
                                <x-button variant="secondary" size="sm" icon="fa-solid fa-pen"
                                    :href="route('admin.users.edit', $user)">تعديل</x-button>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    data-confirm="هل أنت متأكد أنك تريد حذف المستخدم ({{ $user->name }}) نهائياً؟">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash">
                                        حذف
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-14">
                            <x-empty-state title="لا يوجد مستخدمون مسجلون"
                                description="لم يقم أي عضو بالتسجيل في المنصة حتى الآن." icon="fa-solid fa-users-slash" />
                        </td>
                    </tr>
                @endforelse
            </x-data-table>
        </div>

        {{-- ══ بطاقات الموبايل ══ --}}
        <div class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2 md:hidden">
            @forelse ($users as $user)
                <article class="surface-muted p-4">
                    <div class="flex items-start gap-3">
                        <x-avatar :name="$user->name" size="h-12 w-12"
                            :image="$user->image" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-extrabold text-ink dark:text-white">{{ $user->name }}</p>
                            <p class="truncate text-xs text-muted" dir="ltr">{{ $user->email }}</p>
                            <p class="mt-1 truncate text-xs font-bold text-muted" dir="ltr">
                                {{ $user->phone }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        @if ($user->role == 'admin')
                            <x-badge variant="danger" dot>مدير</x-badge>
                        @elseif ($user->role == 'instructor')
                            <x-badge variant="info" dot>محاضر</x-badge>
                        @else
                            <x-badge variant="neutral" dot>طالب</x-badge>
                        @endif

                        @if ($user->status == 'active')
                            <x-badge variant="success" dot>نشط</x-badge>
                        @else
                            <x-badge variant="warning" dot>معطل</x-badge>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                        <x-button variant="secondary" size="sm" icon="fa-solid fa-pen" block
                            :href="route('admin.users.edit', $user)">تعديل</x-button>

                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                            data-confirm="هل أنت متأكد أنك تريد حذف المستخدم ({{ $user->name }}) نهائياً؟" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash" block>
                                حذف
                            </x-button>
                        </form>
                    </div>
                </article>
            @empty
                <x-empty-state title="لا يوجد مستخدمون مسجلون" description="لم يقم أي عضو بالتسجيل في المنصة حتى الآن."
                    icon="fa-solid fa-users-slash" />
            @endforelse
        </div>

        @if (method_exists($users, 'links') && $users->hasPages())
            <x-slot:footer>
                <div class="flex justify-center">{{ $users->links() }}</div>
            </x-slot:footer>
        @endif
    </x-card>
@endsection