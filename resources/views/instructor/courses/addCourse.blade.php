@extends('layouts.app')

@section('title', 'إضافة كورس جديد')

@section('content')
    <x-page-header title="إضافة كورس جديد" icon="fa-solid fa-circle-plus"
        description="أدخل تفاصيل الكورس بعناية ليتم عرضه بشكل صحيح للطلاب." />

    <x-card>
        <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <x-input name="title" label="عنوان الكورس" required icon="fa-solid fa-book"
                    placeholder="مثال: أساسيات البرمجة بـ PHP" />

                <x-input name="slug" label="الرابط الدائم (Slug)" dir="ltr"
                    placeholder="اتركه فارغاً للتوليد التلقائي" />
            </div>

            <x-input name="short_description" label="وصف قصير للتعريف بالكورس"
                placeholder="جملة واحدة تصف الكورس بإيجاز" icon="fa-solid fa-align-start" />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <x-select name="category_id" label="التصنيف" required>
                    <option value="">اختر التصنيف</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>

                <x-select name="instructor_id" label="المدرب" required>
                    <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                </x-select>

                <x-select name="status" label="حالة الكورس">
                    <option value="published" @selected(old('status', 'published') == 'published')>منشور (Published)</option>
                    <option value="draft" @selected(old('status') == 'draft')>مسودة (Draft)</option>
                </x-select>

                <x-input name="price" label="السعر" dir="ltr" placeholder="0.00" hint="اتركه فارغاً للمجاني"
                    suffix="USD" />
            </div>

            <x-textarea name="description" label="وصف الكورس بالتفصيل" rows="5"
                placeholder="اكتب وصفاً شاملاً يوضح ما سيتعلمه الطالب داخل الكورس..." />

            <x-file-field label="صورة غلاف الكورس" for="image"
                hint="PNG, JPG, WebP — حتى 2 ميجابايت">
                <div
                    class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-canvas px-6 py-8 text-center transition hover:border-brand-400 hover:bg-brand-50/40 dark:border-navy-border dark:bg-navy/30 dark:hover:border-brand-500/50">
                    <i class="fa-solid fa-cloud-arrow-up mb-3 text-3xl text-slate-400 dark:text-slate-500"
                        aria-hidden="true"></i>

                    <label for="image" class="cursor-pointer text-sm font-extrabold text-brand-600 dark:text-brand-400">
                        <span>ارفع ملف الصورة</span>
                        <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                    </label>

                    <p class="mt-1 text-xs font-bold text-slate-400 dark:text-slate-500">
                        PNG, JPG, WebP — حتى 2 ميجابايت
                    </p>
                </div>
            </x-file-field>

            <div
                class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-4 dark:border-navy-border">
                <x-button variant="secondary" type="button" icon="fa-solid fa-xmark"
                    onclick="history.back()">إلغاء</x-button>
                <x-button type="submit" icon="fa-solid fa-floppy-disk">حفظ الكورس</x-button>
            </div>
        </form>
    </x-card>
@endsection