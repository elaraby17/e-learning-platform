@extends('layouts.app')

@section('title', 'تعديل المستخدم')

@section('page-breadcrumb')
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">الرئيسية</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <a href="{{ route('admin.users.index') }}" class="transition hover:text-brand-600 dark:hover:text-brand-300">
        المستخدمون
    </a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <span class="text-brand-600 dark:text-brand-300">تعديل</span>
@endsection

@section('content')
    <x-page-header title="تعديل المستخدم" icon="fa-solid fa-user-pen"
        :description="'تعديل بيانات: ' . $user->name">
        <x-slot:actions>
            <x-badge variant="brand" icon="fa-solid fa-user">
                {{ $user->role == 'admin' ? 'مدير' : ($user->role == 'instructor' ? 'محاضر' : 'طالب') }}
            </x-badge>
        </x-slot:actions>
    </x-page-header>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- ══ الصورة والنبذة ══ --}}
            <x-card title="الصورة والنبذة" icon="fa-solid fa-image" class="lg:col-span-1">
                <div class="flex flex-col items-center">
                    <label for="image" class="group relative block cursor-pointer">
                        <x-avatar :name="$user->name" size="h-32 w-32" rounded="rounded-full"
                            :image="$user->image" />
                        <span
                            class="absolute inset-0 flex items-center justify-center rounded-full bg-navy/70 text-xs font-extrabold text-white opacity-0 transition group-hover:opacity-100 group-focus-within:opacity-100">
                            تغيير الصورة
                        </span>
                        <input type="file" name="image" id="image" accept="image/*" class="sr-only">
                    </label>

                    <p class="mt-3 text-xs font-bold text-slate-500 dark:text-slate-400">JPG أو PNG — حتى 2 ميجابايت</p>

                    @error('image')
                        <p class="form-error justify-center">
                            <i class="fa-solid fa-circle-exclamation mt-0.5 text-[11px]" aria-hidden="true"></i>
                            {{ $message }}
                        </p>
                    @enderror

                    <x-textarea name="bio" label="النبذة التعريفية (Bio)" rows="4" class="mt-5 w-full"
                        placeholder="نبذة مختصرة..." :value="$user->bio" />
                </div>
            </x-card>

            {{-- ══ البيانات ══ --}}
            <div class="space-y-6 lg:col-span-2">
                <x-card title="البيانات الأساسية" icon="fa-solid fa-address-card">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <x-input name="name" label="الاسم الكامل" :value="$user->name" required
                            icon="fa-solid fa-user" />

                        <x-input name="phone" label="رقم الهاتف" type="tel" :value="$user->phone" required dir="ltr"
                            icon="fa-solid fa-phone" />

                        <x-input name="email" label="البريد الإلكتروني" type="email" :value="$user->email" required
                            dir="ltr" icon="fa-solid fa-envelope" wrapperClass="md:col-span-2" />
                    </div>
                </x-card>

                <x-card title="الصلاحيات وحالة الحساب" icon="fa-solid fa-shield-halved">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <x-select name="status" label="الحالة" required>
                            <option value="active" @selected(old('status', $user->status) == 'active')>نشط</option>
                            <option value="inactive" @selected(old('status', $user->status) == 'inactive')>غير نشط</option>
                        </x-select>

                        <x-radio-group name="gender" label="الجنس" :value="$user->gender"
                            :options="['male' => 'ذكر', 'female' => 'أنثى']" />
                    </div>
                </x-card>

                <x-card title="تغيير كلمة المرور" icon="fa-solid fa-key"
                    description="اتركه فارغاً للإبقاء على كلمة المرور الحالية.">
                    <x-input name="password" label="كلمة المرور الجديدة" type="password" dir="ltr"
                        placeholder="كلمة مرور جديدة" autocomplete="new-password" :use-old="false" />
                </x-card>
            </div>
        </div>

        {{-- ══ الإجراءات ══ --}}
        <div class="form-actions">
            <x-button variant="secondary" type="button" icon="fa-solid fa-xmark"
                onclick="history.back()">إلغاء</x-button>
            <x-button type="submit" icon="fa-solid fa-floppy-disk">حفظ التعديلات</x-button>
        </div>
    </form>
@endsection