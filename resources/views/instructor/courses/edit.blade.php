@extends('layouts.app')

@section('title', 'تعديل كورس')

@section('content')
    <x-page-header title="تعديل كورس" icon="fa-solid fa-pen-to-square"
        :description="'تعديل تفاصيل: ' . $course->title">
        <x-slot:actions>
            <x-button variant="secondary" size="sm" icon="fa-solid fa-arrow-right"
                :href="route('instructor.dashboard')">رجوع للوحة</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <x-input name="title" label="عنوان الكورس" required icon="fa-solid fa-book" :value="$course->title" />

                <x-input name="slug" label="الرابط الدائم (Slug)" dir="ltr" :value="$course->slug"
                    placeholder="اتركه فارغاً للتوليد التلقائي" />
            </div>

            <x-input name="short_description" label="وصف قصير للتعريف بالكورس" :value="$course->short_description"
                placeholder="جملة واحدة تصف الكورس بإيجاز" icon="fa-solid fa-align-start" />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <x-select name="category_id" label="التصنيف" required>
                    <option value="">اختر التصنيف</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>

                <x-select name="instructor_id" label="المدرب" required>
                    <option value="">اختر المدرب</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" @selected(old('instructor_id', $course->instructor_id) == $instructor->id)>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </x-select>

                <x-select name="status" label="حالة الكورس">
                    <option value="published" @selected(old('status', $course->status ?? 'published') == 'published')>منشور (Published)</option>
                    <option value="draft" @selected(old('status', $course->status) == 'draft')>مسودة (Draft)</option>
                </x-select>

                <x-input name="price" label="السعر" dir="ltr" placeholder="0.00" hint="اتركه فارغاً للمجاني"
                    :value="$course->price" suffix="USD" />
            </div>

            <x-textarea name="description" label="وصف الكورس بالتفصيل" rows="5" :value="$course->description"
                placeholder="اكتب وصفاً شاملاً يوضح ما سيتعلمه الطالب داخل الكورس..." />

            <x-file-field label="صورة غلاف الكورس" for="image"
                hint="PNG, JPG, WebP — حتى 2 ميجابايت">
                <div
                    class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-canvas px-6 py-8 text-center transition hover:border-brand-400 hover:bg-brand-50/40 dark:border-navy-border dark:bg-navy/30 dark:hover:border-brand-500/50">
                    @if ($course->image)
                        <img src="{{ filter_var($course->image, FILTER_VALIDATE_URL) ? $course->image : asset('storage/' . $course->image) }}"
                            alt="{{ $course->title }}" loading="lazy" data-img-fallback
                            class="mb-3 h-24 w-full max-w-sm rounded-xl object-cover">
                    @else
                        <i class="fa-solid fa-cloud-arrow-up mb-3 text-3xl text-slate-400 dark:text-slate-500"
                            aria-hidden="true"></i>
                    @endif

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