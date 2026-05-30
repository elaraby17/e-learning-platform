@extends('layouts.master')

@section('title', 'Categories')
@section('content')
    <div class="max-w-5xl mx-auto my-6 p-4 text-slate-700 dark:text-slate-200" dir="rtl">

        <div class="mb-8 border-b border-slate-200 dark:border-slate-700/50 pb-4">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <span class="text-indigo-600 dark:text-indigo-400">#</span> لوحة إدارة الأقسام (Categories)
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">يمكنك إضافة، عرض، وحذف الأقسام المتاحة بالمنصة.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-500/10 border-r-4 border-emerald-500 text-emerald-600 dark:text-emerald-400 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-[#1e2530]/80 p-6 rounded-2xl shadow-md dark:shadow-xl border border-slate-200 dark:border-slate-700/40 mb-8 backdrop-blur-sm">
            <h2 class="text-md font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 dark:bg-indigo-500"></span> إضافة قسم جديد
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="categoryName"
                            class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-2">اسم القسم
                            (Name):</label>
                        <input type="text" name="name" id="categoryName" value="{{ old('name') }}"
                            class="w-full bg-slate-50 dark:bg-[#141a24] text-slate-900 dark:text-white px-4 py-2.5 border @error('name') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all text-sm"
                            placeholder="مثال: إلكترونيات، البرمجة..." required>
                        @error('name')
                            <p class="text-rose-500 dark:text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="categoryDesc"
                            class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-2">الوصف
                            (Description):</label>
                        <textarea name="description" id="categoryDesc" rows="3"
                            class="w-full bg-slate-50 dark:bg-[#141a24] text-slate-900 dark:text-white px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-all text-sm resize-none"
                            placeholder="اكتب وصفاً مختصراً للقسم..."></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/10 text-sm">
                            إضافة قسم جديد
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div
            class="bg-white dark:bg-[#1e2530]/80 rounded-2xl shadow-md dark:shadow-xl border border-slate-200 dark:border-slate-700/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 dark:bg-[#141a24]/60 text-slate-600 dark:text-slate-300 text-xs font-semibold border-b border-slate-200 dark:border-slate-700/50">
                            <th class="py-4 px-6 w-1/3">اسم القسم</th>
                            <th class="py-4 px-6 w-1/2">الوصف</th>
                            <th class="py-4 px-6 w-1/6 text-center">العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/40 text-sm">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50 dark:hover:bg-[#141a24]/30 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-800 dark:text-white">{{ $category->name }}</td>
                                <td class="py-4 px-6 text-slate-500 dark:text-slate-400 max-w-xs truncate text-xs">
                                    {{ $category->description ?? 'لا يوجد وصف حالياً' }}</td>
                                <td class="py-4 px-6 text-center space-x-reverse space-x-2 whitespace-nowrap text-xs">

                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="inline-block text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 bg-amber-500/10 hover:bg-amber-500/20 font-medium px-3 py-1.5 rounded-lg transition-colors">
                                        تعديل
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 font-medium px-3 py-1.5 rounded-lg transition-colors">
                                            حذف
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="py-10 text-center text-slate-400 dark:text-slate-500 italic text-xs">
                                    لا توجد أقسام مضافة حالياً بالمنصة.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
