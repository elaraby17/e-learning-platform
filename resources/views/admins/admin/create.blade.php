@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('page-breadcrumb')
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/') }}"
        class="transition hover:text-brand-600 dark:hover:text-brand-300">الرئيسية</a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <a href="{{ route('admin.users.index') }}" class="transition hover:text-brand-600 dark:hover:text-brand-300">
        المديرين
    </a>
    <i class="fa-solid fa-chevron-left text-[9px]" aria-hidden="true"></i>
    <span class="text-brand-600 dark:text-brand-300">إضافة</span>
@endsection

@section('content')
    <x-page-header title="إضافة مدير جديد" icon="fa-solid fa-user-plus"
        description="إنشاء حساب جديد وتعيين الصلاحيات الخاصة به في المنصة.">
        <x-slot:actions>
            <x-button variant="secondary" size="sm" icon="fa-solid fa-arrow-right" :href="route('admin.users.index')">إلغاء
                والعودة</x-button>
        </x-slot:actions>
    </x-page-header>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            {{-- ══ الصورة والنبذة ══ --}}
            <x-card title="الصورة الشخصية والوظيفة" icon="fa-solid fa-id-card"
                description="ارفع صورة المستخدم وحدد النبذة التعريفية الخاصة به.">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <x-file-field label="الصورة الشخصية" for="image">
                        <div class="flex items-center gap-4">
                            <span
                                class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-brand-50 text-brand-500 dark:bg-brand-500/10">
                                <i class="fa-solid fa-user text-2xl" aria-hidden="true"></i>
                            </span>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="block w-full cursor-pointer text-xs font-bold text-slate-500 file:me-3 file:min-h-9 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:text-xs file:font-extrabold file:text-brand-700 transition hover:file:bg-brand-100 dark:text-slate-400 dark:file:bg-brand-500/10 dark:file:text-brand-300 dark:hover:file:bg-brand-500/20" />
                        </div>
                    </x-file-field>

                    <x-textarea name="bio" label="النبذة التعريفية (Bio)" rows="4"
                        placeholder="اكتب نبذة مختصرة عن المستخدم أو المدرس..." />
                </div>
            </x-card>

            {{-- ══ البيانات الأساسية ══ --}}
            <x-card title="البيانات الأساسية" icon="fa-solid fa-address-card"
                description="المعلومات الشخصية التي سيتم استخدامها للتواصل والتعريف بالفرد.">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <x-input name="name" label="الاسم الكامل" placeholder="محمد العربي" required
                        icon="fa-solid fa-user" />

                    <x-input name="email" label="البريد الإلكتروني" type="email" placeholder="example@domain.com"
                        required dir="ltr" autocomplete="off" icon="fa-solid fa-envelope" />

                    <x-input name="phone" label="رقم الهاتف" type="tel" placeholder="01xxxxxxxxx" required
                        dir="ltr" icon="fa-solid fa-phone" />

                    <x-select name="gender" label="الجنس">
                        <option value="" disabled @selected(old('gender') === null)>اختر الجنس</option>
                        <option value="male" @selected(old('gender') == 'male')>ذكر</option>
                        <option value="female" @selected(old('gender') == 'female')>أنثى</option>
                        <option value="other" @selected(old('gender') == 'other')>أخرى</option>
                    </x-select>
                </div>
            </x-card>

            {{-- ══ الصلاحيات ══ --}}
            <x-card title="الصلاحيات والأمان" icon="fa-solid fa-lock"
                description="تحديد مستوى الوصول للنظام وإنشاء كلمة مرور قوية.">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <x-select name="role" label="الصلاحية (Role)" required>
                        <option value="student" @selected(old('role', 'student') == 'student')>طالب (Student)</option>
                        <option value="instructor" @selected(old('role') == 'instructor')>مدرس (Instructor)</option>
                        <option value="admin" @selected(old('role') == 'admin')>مدير (Admin)</option>
                    </x-select>

                    <x-select name="status" label="حالة الحساب" required>
                        <option value="active" @selected(old('status', 'active') == 'active')>نشط (Active)</option>
                        <option value="inactive" @selected(old('status') == 'inactive')>غير نشط (Inactive)</option>
                    </x-select>

                    <x-input name="password" label="كلمة المرور" type="password" placeholder="••••••••" required
                        dir="ltr" autocomplete="new-password" :use-old="false" icon="fa-solid fa-key" />

                    <x-input name="password_confirmation" label="تأكيد كلمة المرور" type="password" placeholder="••••••••"
                        required dir="ltr" autocomplete="new-password" :use-old="false" icon="fa-solid fa-key" />
                </div>
            </x-card>
        </div>

        {{-- ══ الإجراءات ══ --}}
        <div class="form-actions">
            <x-button variant="secondary" type="button" icon="fa-solid fa-xmark" onclick="history.back()">إلغاء</x-button>
            <x-button type="submit" icon="fa-solid fa-floppy-disk">حفظ الحساب الجديد</x-button>
        </div>
    </form>
@endsection
