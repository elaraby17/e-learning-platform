@extends('layouts.master')

@section('title', 'Add New Course')

@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-800 transition-colors duration-300">

    <!-- عنوان الفورم -->
    <div class="mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إضافة كورس جديد</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">أدخل تفاصيل الكورس بعناية ليتم عرضه بشكل صحيح للطلاب.</p>
    </div>

    <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- عنوان الكورس والـ Slug -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان الكورس *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الرابط الدائم (Slug)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="اتركه فارغاً للتوليد التلقائي"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                @error('slug') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- الوصف القصير -->
        <div>
            <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وصف قصير للتعريف بالكورس</label>
            <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
            @error('short_description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- التصنيف، المدرب، الحالة، السعر -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- التصنيف -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">التصنيف *</label>
                <select name="category_id" id="category_id" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    <option value="">اختر التصنيف</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- المدرب -->
            <div>
                <label for="instructor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المدرب *</label>
                <select name="instructor_id" id="instructor_id" required
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    <option value="">اختر المدرب</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                    @endforeach
                </select>
                @error('instructor_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- حالة الكورس -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">حالة الكورس</label>
                <select name="status" id="status"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>منشور (Published)</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>مسودة (Draft)</option>
                </select>
                @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- السعر -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">السعر (اتركه فارغاً للمجاني)</label>
                <div class="relative">
                    <input type="text" name="price" id="price" value="{{ old('price') }}" placeholder="0.00"
                        class="w-full pl-12 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-left">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500 text-sm">
                        USD
                    </div>
                </div>
                @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- الوصف الكامل -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وصف الكورس بالتفصيل</label>
            <textarea name="description" id="description" rows="5"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all resize-none">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- غلاف الكورس (صورة) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">صورة غلاف الكورس</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4 24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                        <label for="image" class="relative cursor-pointer rounded-md font-medium text-blue-600 dark:text-blue-400 hover:underline focus-within:outline-none">
                            <span>ارفع ملف الصورة</span>
                            <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WebP حتى 2 ميجابايت</p>
                </div>
            </div>
            @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- أزرار التحكم -->
        <div class="flex items-center justify-end gap-3 border-t border-gray-100 dark:border-gray-800 pt-4">
            <a href="#"
               class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                إلغاء
            </a>
            <button type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg shadow-sm focus:ring-4 focus:ring-blue-300 transition-colors">
                حفظ الكورس
            </button>
        </div>
    </form>
</div>
@endsection
