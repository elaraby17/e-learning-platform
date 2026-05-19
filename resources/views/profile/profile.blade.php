@extends('layouts.master')
@section('title', 'الملف الشخصي')
@section('content')

    <div class="min-h-screen bg-white dark:bg-slate-800 text-white p-4 lg:p-8" dir="rtl">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- ══ SIDEBAR (Glassmorphism) ══ --}}
            <aside class="lg:col-span-1 space-y-4">
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 absolute top-20 lg:relative lg:top-0 shadow-lg shadow-white/10">
                    <div class="flex items-center gap-4 mb-8 px-2">
                        <div
                            class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight">لوحة التحكم</span>
                    </div>

                    <nav class="space-y-2">
                        <a href="#"
                            class="flex items-center gap-4 px-4 py-3 bg-blue-600/20 text-blue-400 rounded-2xl font-bold border border-blue-500/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            الملف الشخصي
                        </a>
                        <a href="#"
                            class="flex items-center gap-4 px-4 py-3 text-gray-400 hover:bg-white/5 rounded-2xl font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            الإشعارات
                        </a>
                    </nav>
                </div>
            </aside>

            {{-- ══ MAIN CONTENT ══ --}}
            <main class="lg:col-span-3 space-y-6">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-500 dark:text-white">إعدادات الحساب</h1>
                        <p class="text-gray-400 text-sm mt-1">تحكم في بياناتك الشخصية وصورتك</p>
                    </div>
                    <div
                        class="bg-white/5 border border-white/10 p-2 pr-4 rounded-2xl flex items-center gap-3 backdrop-blur-md">
                        <div class="text-right">
                            <p class="text-sm font-bold text-black/60 dark:text-white leading-none">
                                {{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-blue-400 mt-1 uppercase font-bold tracking-tighter">
                                {{ auth()->user()->role == 'instructor' ? 'مدرب معتمد' : 'طالب مميز' }}
                            </p>
                        </div>
                        <img src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/default-avatar.png') }}"
                            class="w-10 h-10 rounded-xl object-cover ring-2 ring-blue-500/20">
                    </div>
                </div>

                {{-- Profile Card --}}
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Profile Header/Avatar --}}
                        <div
                            class="p-8 md:p-10 border-b border-white/5 flex flex-col md:flex-row items-center gap-8 justify-between bg-gradient-to-l from-blue-600/5 to-transparent">
                            <div class="flex flex-col md:flex-row items-center gap-6">
                                <div class="relative group cursor-pointer"
                                    onclick="document.getElementById('avatarInput').click()">
                                    <img id="preview"
                                        src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/default-avatar.png') }}"
                                        class="w-32 h-32 rounded-[2rem] object-cover ring-4 ring-white/10 shadow-2xl transition-all duration-300 group-hover:brightness-50">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input type="file" id="avatarInput" name="image" class="hidden"
                                        onchange="previewImage(this)">
                                </div>
                                <div class="text-center md:text-right">
                                    <h2 class="text-2xl font-bold text-black/85 dark:text-white">{{ auth()->user()->name }}
                                    </h2>
                                    <p class="text-gray-400">{{ auth()->user()->email }}</p>
                                    <span
                                        class="inline-block mt-3 px-4 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-full text-xs font-bold">حساب
                                        نشط ✓</span>
                                </div>
                            </div>

                            <div id="view-mode-actions">
                                <button type="button" onclick="toggleEdit()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-blue-600/20">تعديل
                                    الملف</button>
                            </div>
                            <div id="edit-mode-actions" class="hidden flex gap-3">
                                <button type="button" onclick="toggleEdit()"
                                    class="bg-white/5 text-gray-300 px-6 py-3 rounded-2xl font-bold hover:bg-white/10 transition">إلغاء</button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-2xl font-bold transition shadow-lg shadow-green-600/20">حفظ
                                    ✓</button>
                            </div>
                        </div>

                        {{-- Fields --}}
                        <div class="p-8 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $labelStyle =
                                    'block text-xs font-bold text-blue-400 uppercase tracking-widest mb-2 mr-1';
                                $viewStyle =
                                    'w-full p-4 bg-white/5 border border-white/5 rounded-2xl text-gray-300 text-sm';
                                $inputStyle =
                                    'hidden w-full p-4 bg-gray-50 dark:bg-[#1e293b] border border-blue-500/30 rounded-2xl text-gray-800 dark:text-white text-sm outline-none focus:ring-2 focus:ring-blue-500/50 transition';
                            @endphp

                            <div>
                                <label class="{{ $labelStyle }}">الاسم بالكامل</label>
                                <div id="name-view" class="{{ $viewStyle }}">{{ auth()->user()->name }}</div>
                                <input type="text" name="name" id="name-input" value="{{ auth()->user()->name }}"
                                    class="{{ $inputStyle }}">
                            </div>

                            <div>
                                <label class="{{ $labelStyle }}">رقم الهاتف</label>
                                <div id="phone-view" class="{{ $viewStyle }}">
                                    {{ auth()->user()->phone ?? 'لم يتم الإضافة' }}</div>
                                <input type="text" name="phone" id="phone-input" value="{{ auth()->user()->phone }}"
                                    class="{{ $inputStyle }}">
                            </div>

                            <div class="md:col-span-2">
                                <label class="{{ $labelStyle }}">نبذة تعريفية (Bio)</label>
                                <div id="bio-view" class="{{ $viewStyle }} min-h-[100px]">
                                    {{ auth()->user()->bio ?? 'أخبر الطلاب المزيد عنك...' }}</div>
                                <textarea name="bio" id="bio-input" rows="3" class="{{ $inputStyle }} resize-none">{{ auth()->user()->bio }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Password Card (Danger Zone Design) --}}
                <div class="bg-white/5 backdrop-blur-xl border border-red-500/10 rounded-[2.5rem] p-8 shadow-xl">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex items-center gap-5">
                            <div
                                class="w-14 h-14 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-500 border border-red-500/20">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-lg">الأمان وكلمة المرور</h3>
                                <p class="text-gray-400 text-sm italic">آخر تحديث منذ شهرين</p>
                            </div>
                        </div>
                        <button onclick="document.getElementById('password-form').classList.toggle('hidden')"
                            class="bg-transparent border border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white px-6 py-3 rounded-2xl font-bold transition-all text-sm">
                            تغيير كلمة السر
                        </button>
                    </div>

                    <form id="password-form" action="{{ route('password.update.custom') }}" method="POST"
                        class="hidden mt-8 pt-8 border-t border-white/5 space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="password" name="current_password" placeholder="كلمة السر الحالية"
                                class="w-full p-4 bg-gray-50 dark:bg-[#1e293b] border dark:border-slate-600 border-white/5 rounded-2xl text-white outline-none focus:border-red-500/50">
                            <input type="password" name="password" placeholder="كلمة السر الجديدة"
                                class="w-full p-4 bg-gray-50 dark:bg-[#1e293b] border dark:border-slate-600 border-white/5 rounded-2xl text-white outline-none focus:border-red-500/50">
                            <input type="password" name="password_confirmation" placeholder="تأكيد الجديدة"
                                class="w-full p-4 bg-gray-50 dark:bg-[#1e293b] border dark:border-slate-600 border-white/5 rounded-2xl text-white outline-none focus:border-red-500/50">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-2xl font-bold transition shadow-lg shadow-red-600/20">تحديث
                                الأمان 🔒</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleEdit() {
            const ids = ['name', 'phone', 'bio'];
            const isEditing = !document.getElementById('edit-mode-actions').classList.contains('hidden');

            document.getElementById('edit-mode-actions').classList.toggle('hidden');
            document.getElementById('view-mode-actions').classList.toggle('hidden');

            ids.forEach(id => {
                document.getElementById(id + '-view').classList.toggle('hidden');
                document.getElementById(id + '-input').classList.toggle('hidden');
            });
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('preview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
