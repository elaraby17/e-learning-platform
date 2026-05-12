@extends('layouts.master')

@section('title', 'profile')

@section('content')
    <div class="min-h-screen bg-[#f8f9fa] flex" dir="rtl">

        <aside class="w-72 bg-white border-l border-gray-100 hidden lg:flex flex-col sticky top-0 h-screen">
            <div class="p-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black text-gray-800 tracking-tight">لوحة التحكم</span>
                </div>
            </div>

            <nav class="flex-1 px-4 mt-4 space-y-2">
                <a href="#"
                    class="flex items-center gap-4 px-4 py-3.5 bg-indigo-50 text-indigo-700 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    الملف الشخصي
                </a>
                <a href="#"
                    class="flex items-center gap-4 px-4 py-3.5 text-gray-500 hover:bg-gray-50 rounded-2xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    الإشعارات
                </a>
            </nav>
        </aside>

        <main class="flex-1 lg:p-10 p-4">

            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">إعدادات الحساب</h1>
                    <p class="text-gray-400 text-sm mt-1">إدارة معلوماتك الشخصية وصورة الملف</p>
                </div>
                <div class="flex items-center gap-4 bg-white p-2 pr-4 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-bold">عضو ذهبي</p>
                    </div>
                    <img src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('default-avatar.png') }}"
                        class="w-10 h-10 rounded-xl object-cover shadow-sm">
                </div>
            </header>

            <div class="max-w-4xl bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-8 border-b border-gray-50 flex flex-col md:flex-row items-center gap-8 justify-between">
                        <div class="flex items-center gap-6">
                            <div class="relative">
                                <img id="preview"
                                    src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('default-avatar.png') }}"
                                    class="w-32 h-32 rounded-[28px] object-cover ring-4 ring-gray-50 shadow-2xl transition-all duration-500">

                                <label id="photo-overlay"
                                    class="hidden absolute inset-0 bg-black/40 rounded-[28px] flex items-center justify-center cursor-pointer group transition-all">
                                    <div
                                        class="bg-white/20 p-3 rounded-2xl backdrop-blur-md group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input type="file" name="image" class="hidden" onchange="previewImage(this)">
                                </label>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                                <p class="text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div id="view-mode-actions">
                            <button type="button" onclick="toggleEdit()"
                                class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                تعديل الملف
                            </button>
                        </div>
                        <div id="edit-mode-actions" class="hidden flex gap-3">
                            <button type="button" onclick="toggleEdit()"
                                class="px-6 py-3 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition-all">إلغاء</button>
                            <button type="submit"
                                class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">حفظ</button>
                        </div>
                    </div>

                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        <div class="group">
                            <label class="block text-xs font-bold text-indigo-500 uppercase mb-2 tracking-widest px-1">الاسم
                                بالكامل</label>
                            <div id="name-view"
                                class="text-lg text-gray-800 bg-gray-50/50 p-4 rounded-2xl border border-transparent text-right">
                                {{ auth()->user()->name }}</div>
                            <input type="text" name="name" id="name-input" dir="rtl"
                                value="{{ auth()->user()->name }}"
                                class="hidden w-full p-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all ">
                        </div>

                        <div class="space-y-1">
                            <label
                                class="block text-xs font-bold text-indigo-500 uppercase mb-2 tracking-widest px-1 text-right">
                                البريد الإلكتروني
                            </label>

                            <div id="email-view"
                                class="text-lg  text-gray-800 bg-gray-50/50 p-4 rounded-2xl border border-transparent text-right">
                                {{ auth()->user()->email }}
                            </div>

                            <input type="email" name="email" id="email-input" value="{{ auth()->user()->email }}"
                                dir="rtl"
                                class="hidden w-full p-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-right">
                        </div>

                        <div class="group">
                            <label class="block text-xs font-bold text-indigo-500 uppercase mb-2 tracking-widest px-1">رقم
                                الهاتف</label>
                            <div id="phone-view"
                                class="text-lg  text-gray-800 bg-gray-50/50 p-4 rounded-2xl border border-transparent">
                                {{ auth()->user()->phone ?? 'غير متاح' }}</div>
                            <input type="text" name="phone" id="phone-input" value="{{ auth()->user()->phone }}"
                                class="hidden w-full p-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all ">
                        </div>

                        <div class="group">
                            <label
                                class="block text-xs font-bold text-indigo-500 uppercase mb-2 tracking-widest px-1">النبذة
                                التعريفية (Bio)</label>
                            <div id="bio-view"
                                class="text-lg text-gray-800 bg-gray-50/50 p-4 rounded-2xl border border-transparent leading-relaxed">
                                {{ auth()->user()->bio ?? 'لا يوجد وصف حالياً..' }}</div>
                            <textarea name="bio" id="bio-input" rows="1"
                                class="hidden w-full p-4 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all  resize-none">{{ auth()->user()->bio }}</textarea>
                        </div>
                    </div>
                </form>
            </div>


            <div class="max-w-4xl mt-6 bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">كلمة المرور والأمان</h3>
                            <p class="text-sm text-gray-400">تأكد من استخدام كلمة مرور قوية لحماية حسابك</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('password-form').classList.toggle('hidden')"
                        class="px-6 py-2 border-2 border-red-500 text-red-500 rounded-xl font-bold hover:bg-red-50 transition">
                        تغيير كلمة السر
                    </button>
                </div>

                <form id="password-form" action="{{ route('password.update.custom') }}" method="POST"
                    class="hidden border-t border-gray-50 pt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">كلمة السر الحالية</label>
                            <input type="password" name="current_password"
                                class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-red-500/10 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">كلمة السر الجديدة</label>
                            <input type="password" name="password"
                                class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-red-500/10 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">تأكيد كلمة السر</label>
                            <input type="password" name="password_confirmation"
                                class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-red-500/10 outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-red-500 text-white rounded-xl font-bold shadow-lg shadow-red-100 hover:bg-red-600 transition">
                            تحديث الأمان
                        </button>
                    </div>
                </form>
                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status') === 'password-updated')
                    <div style="color: green;">✅ تم تغيير كلمة المرور بنجاح!</div>
                @endif
            </div>

        </main>
    </div>

    <script>
        function toggleEdit() {
            const viewActions = document.getElementById('view-mode-actions');
            const editActions = document.getElementById('edit-mode-actions');
            const photoOverlay = document.getElementById('photo-overlay');
            const ids = ['name', 'email', 'phone', 'bio'];

            const isEditing = !editActions.classList.contains('hidden');

            if (isEditing) {
                editActions.classList.add('hidden');
                viewActions.classList.remove('hidden');
                photoOverlay.classList.add('hidden');
                ids.forEach(id => {
                    document.getElementById(id + '-view').classList.remove('hidden');
                    document.getElementById(id + '-input').classList.add('hidden');
                });
            } else {
                editActions.classList.remove('hidden');
                viewActions.classList.add('hidden');
                photoOverlay.classList.remove('hidden');
                ids.forEach(id => {
                    document.getElementById(id + '-view').classList.add('hidden');
                    document.getElementById(id + '-input').classList.remove('hidden');
                });
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
