@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <x-page-header title="الملف الشخصي والحساب" icon="fa-solid fa-address-card"
        description="إدارة معلوماتك الشخصية، تعديل الأمان، ومتابعة الاشتراكات النشطة." />

    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
        {{-- ══ بطاقة الهوية ══ --}}
        <div class="space-y-6 lg:col-span-1">
            <x-card class="text-center">
                <x-avatar :name="$user->name" size="h-32 w-32" rounded="rounded-full" wrapperClass="mx-auto"
                    :image="$user->image" />

                <h2 class="mt-4 text-xl font-extrabold text-ink dark:text-white">{{ $user->name }}</h2>

                <div class="mt-2 flex justify-center">
                    @if ($user->role == 'admin')
                        <x-badge variant="danger" icon="fa-solid fa-shield-halved">مدير النظام</x-badge>
                    @elseif ($user->role == 'instructor')
                        <x-badge variant="info" icon="fa-solid fa-chalkboard-user">مدرس</x-badge>
                    @else
                        <x-badge variant="brand" icon="fa-solid fa-user-graduate">طالب</x-badge>
                    @endif
                </div>

                <p class="mt-4 px-2 text-sm leading-relaxed text-muted">
                    {{ $user->bio ?? 'لا توجد نبذة تعريفية مكتوبة حالياً.' }}
                </p>

                <div class="mt-6 space-y-2 border-t border-separator pt-4 text-start text-xs dark:border-navy-border">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-muted">حالة الحساب:</span>
                        @if ($user->status == 'active')
                            <x-badge variant="success" dot>نشط</x-badge>
                        @else
                            <x-badge variant="warning" dot>معطل</x-badge>
                        @endif
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-muted">تاريخ الإنضمام:</span>
                        <span class="font-extrabold" dir="ltr">{{ $user->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-muted">البريد الإلكتروني:</span>
                        <span class="truncate font-extrabold" dir="ltr">{{ $user->email }}</span>
                    </div>
                </div>
            </x-card>

            <x-card title="الاشتراكات والكورسات النشطة" icon="fa-solid fa-book-bookmark"
                :description="'إجمالي الكورسات: ' . (isset($user->courses) ? $user->courses->count() : 0)">
                <div class="max-h-72 space-y-3 overflow-y-auto pe-1">
                    @if (isset($user->courses) && $user->courses->count() > 0)
                        @foreach ($user->courses as $course)
                            <div
                                class="flex items-center justify-between gap-3 rounded-xl border border-separator bg-canvas p-3 dark:border-navy-border dark:bg-navy/40">
                                <div class="min-w-0">
                                    <h4 class="line-clamp-1 text-sm font-bold text-ink dark:text-white">
                                        {{ $course->title }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400">
                                        اشترك في: {{ $course->pivot->created_at->format('Y-m-d') }}
                                    </span>
                                </div>
                                <x-badge variant="success">نشط</x-badge>
                            </div>
                        @endforeach
                    @else
                        <x-empty-state title="لا توجد اشتراكات"
                            description="لم يسجل هذا المستخدم في أي كورس حتى الآن." icon="fa-solid fa-book-open" />
                    @endif
                </div>
            </x-card>
        </div>

        {{-- ══ نموذج التعديل ══ --}}
        <x-card title="تعديل بيانات الحساب الشخصي" icon="fa-solid fa-user-pen" class="lg:col-span-2">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="role" value="{{ $user->role }}">
                <input type="hidden" name="status" value="{{ $user->status }}">

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <x-input name="name" label="الاسم الكامل" required icon="fa-solid fa-user"
                        :value="$user->name" />

                    <x-input name="phone" label="رقم الهاتف" type="tel" required dir="ltr"
                        icon="fa-solid fa-phone" :value="$user->phone" />

                    <x-input name="email" label="البريد الإلكتروني" type="email" required dir="ltr"
                        icon="fa-solid fa-envelope" :value="$user->email" wrapperClass="md:col-span-2" />

                    <x-radio-group name="gender" label="الجنس" :value="$user->gender"
                        :options="['male' => 'ذكر', 'female' => 'أنثى']" />

                    <x-file-field label="تحديث الصورة الشخصية" for="image">
                        <input type="file" name="image" id="image" accept="image/*"
                            class="block w-full cursor-pointer text-xs font-bold text-slate-500 file:me-3 file:min-h-9 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:text-xs file:font-extrabold file:text-brand-700 transition hover:file:bg-brand-100 dark:text-slate-400 dark:file:bg-brand-500/10 dark:file:text-brand-300 dark:hover:file:bg-brand-500/20" />
                    </x-file-field>

                    <x-textarea name="bio" label="النبذة التعريفية (Bio)" rows="3" wrapperClass="md:col-span-2"
                        placeholder="تعديل النبذة الشخصية المكتوبة..." :value="$user->bio" />
                </div>

                <div class="border-t border-separator pt-5 dark:border-navy-border">
                    <h3 class="mb-4 text-sm font-extrabold tracking-wider text-brand-600 uppercase dark:text-brand-400">
                        تغيير كلمة المرور الشخصية
                    </h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <x-input name="password" label="كلمة المرور الجديدة" type="password" dir="ltr"
                            placeholder="اكتب كلمة مرور جديدة" autocomplete="new-password" :use-old="false" />

                        <x-input name="password_confirmation" label="تأكيد كلمة المرور الجديدة" type="password"
                            dir="ltr" placeholder="أعد كتابة كلمة المرور" autocomplete="new-password" :use-old="false" />
                    </div>
                </div>

                <div class="form-actions">
                    <x-button type="submit" icon="fa-solid fa-floppy-disk">حفظ كافة التغييرات</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection