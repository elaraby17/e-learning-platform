@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div id="profile-page">
        <x-page-header title="إعدادات الحساب" icon="fa-solid fa-user-gear"
            description="تحكم في بياناتك الشخصية وصورتك وكلمة المرور." />

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            {{-- ══ بطاقة الهوية ══ --}}
            <x-card class="lg:col-span-1">
                <div class="text-center">
                    <x-avatar :name="auth()->user()->name" size="h-32 w-32" rounded="rounded-2xl"
                        wrapperClass="mx-auto"
                        :image="auth()->user()->image" />

                    <h2 class="mt-4 text-xl font-extrabold text-ink dark:text-white">{{ auth()->user()->name }}</h2>
                    <p class="mt-1 text-sm text-slate-400" dir="ltr">{{ auth()->user()->email }}</p>

                    <div class="mt-3 flex justify-center">
                        <x-badge variant="success" icon="fa-solid fa-circle-check">حساب نشط</x-badge>
                    </div>

                    <div class="mt-5 space-y-2 border-t border-separator pt-4 text-start text-xs dark:border-navy-border">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-muted">الصلاحية:</span>
                            <x-badge variant="brand">
                                {{ auth()->user()->role == 'instructor' ? 'مدرب معتمد' : 'طالب مميز' }}
                            </x-badge>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-muted">تاريخ الإنضمام:</span>
                            <span class="font-extrabold" dir="ltr">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- ══ النماذج ══ --}}
            <div class="space-y-6 lg:col-span-3">
                <x-card title="الملف الشخصي" icon="fa-solid fa-address-card">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col items-start gap-6 border-b border-separator pb-6 md:flex-row md:items-center md:justify-between dark:border-navy-border">
                            <div class="flex flex-col items-center gap-4 md:flex-row">
                                <label for="avatarInput" class="group relative block cursor-pointer">
                                    <img data-avatar-preview
                                        src="{{ \Illuminate\Support\Str::startsWith((string) auth()->user()->image, ['http://', 'https://'])
                                            ? auth()->user()->image
                                            : (auth()->user()->image ? Storage::url(auth()->user()->image) : asset('images/logo.png')) }}"
                                        alt="صورة الملف الشخصي"
                                        class="h-28 w-28 rounded-2xl object-cover ring-4 ring-brand-500/10 transition group-hover:brightness-50">

                                    <span
                                        class="absolute inset-0 flex items-center justify-center rounded-2xl text-white opacity-0 transition group-focus-within:opacity-100 group-hover:opacity-100">
                                        <i class="fa-solid fa-camera text-2xl" aria-hidden="true"></i>
                                    </span>

                                    <input type="file" id="avatarInput" data-avatar-input name="image" accept="image/*"
                                        class="sr-only">
                                </label>

                                <div class="text-center md:text-start">
                                    <p class="text-xs font-extrabold text-muted">الصورة الشخصية</p>
                                    <p class="mt-1 text-xs text-muted">
                                        اضغط على الصورة لاختيار صورة جديدة (JPG أو PNG).
                                    </p>
                                </div>
                            </div>

                            <div class="flex w-full gap-2 md:w-auto" data-view-actions>
                                <x-button type="button" class="flex-1 md:flex-none" data-edit-toggle icon="fa-solid fa-pen">
                                    تعديل الملف
                                </x-button>
                            </div>

                            <div class="hidden w-full flex-wrap items-center gap-2 md:w-auto" data-edit-actions>
                                <x-button type="button" variant="secondary" class="flex-1 md:flex-none" data-edit-toggle
                                    icon="fa-solid fa-xmark">إلغاء</x-button>
                                <x-button type="submit" variant="success" class="flex-1 md:flex-none" icon="fa-solid fa-check">
                                    حفظ
                                </x-button>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <span class="form-label">الاسم بالكامل</span>
                                <div data-profile-view class="surface-muted p-4 text-sm font-bold">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="hidden" data-profile-edit>
                                    <x-input name="name" :value="auth()->user()->name" />
                                </div>
                            </div>

                            <div>
                                <span class="form-label">رقم الهاتف</span>
                                <div data-profile-view class="surface-muted p-4 text-sm font-bold" dir="ltr">
                                    {{ auth()->user()->phone ?? 'لم يتم الإضافة' }}
                                </div>
                                <div class="hidden" data-profile-edit>
                                    <x-input name="phone" :value="auth()->user()->phone" dir="ltr" />
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <span class="form-label">نبذة تعريفية (Bio)</span>
                                <div data-profile-view class="surface-muted min-h-[100px] p-4 text-sm font-bold">
                                    {{ auth()->user()->bio ?? 'أخبر الطلاب المزيد عنك...' }}
                                </div>
                                <div class="hidden" data-profile-edit>
                                    <x-textarea name="bio" rows="3" :value="auth()->user()->bio" />
                                </div>
                            </div>
                        </div>
                    </form>
                </x-card>

                {{-- ══ الأمان ══ --}}
                <x-card class="border-danger-500/30 dark:border-danger-500/20">
                    <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                        <div class="flex items-center gap-4">
                            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-danger-500/20 bg-danger-50 text-danger-500 dark:bg-danger-500/10">
                                <i class="fa-solid fa-lock text-xl" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h3 class="text-lg font-extrabold text-ink dark:text-white">الأمان وكلمة المرور</h3>
                                <p class="text-sm text-muted">آخر تحديث منذ شهرين</p>
                            </div>
                        </div>

                        <x-button type="button" variant="outline-danger" data-password-toggle aria-expanded="false"
                            icon="fa-solid fa-key">تغيير كلمة السر</x-button>
                    </div>

                    <form data-password-form class="mt-8 hidden border-t border-separator pt-8 dark:border-navy-border"
                        action="{{ route('password.update.custom') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <x-input name="current_password" label="كلمة السر الحالية" type="password" required
                                dir="ltr" autocomplete="current-password" icon="fa-solid fa-lock" />

                            <x-input name="password" label="كلمة السر الجديدة" type="password" required dir="ltr"
                                autocomplete="new-password" icon="fa-solid fa-key" />

                            <x-input name="password_confirmation" label="تأكيد الجديدة" type="password" required
                                dir="ltr" autocomplete="new-password" icon="fa-solid fa-key" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-button type="submit" variant="danger" icon="fa-solid fa-shield-halved">تحديث الأمان</x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
@endsection