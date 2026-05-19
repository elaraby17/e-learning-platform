@extends('layouts.master')
@section('title', 'إنشاء حساب')
@section('content')

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="min-h-screen bg-white dark:bg-slate-900 transition-colors duration-300" x-data="{ step: 1 }">

    @include('layouts.partials.header')

    <div class="min-h-[calc(100vh-73px)] flex items-center justify-center p-6 relative overflow-hidden">

        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-indigo-100 dark:bg-indigo-900/30 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-80 h-80 bg-purple-100 dark:bg-purple-900/30 rounded-full blur-[100px] opacity-50 pointer-events-none"></div>

        <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-5 bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-100 dark:shadow-slate-900 border border-gray-100 dark:border-slate-700 relative z-10 transition-colors duration-300">

            {{-- ══ Form ══ --}}
            <div class="md:col-span-3 p-10 md:p-12">

                {{-- Step indicator --}}
                <div class="flex items-center gap-3 mb-10">
                    <div :class="step >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500'"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black transition-all duration-300 flex-shrink-0">1</div>
                    <div :class="step >= 2 ? 'bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700'"
                        class="flex-1 h-1 rounded-full transition-all duration-500"></div>
                    <div :class="step >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500'"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black transition-all duration-300 flex-shrink-0">2</div>
                    <div :class="step >= 3 ? 'bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700'"
                        class="flex-1 h-1 rounded-full transition-all duration-500"></div>
                    <div :class="step >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500'"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black transition-all duration-300 flex-shrink-0">3</div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-2xl p-4 mb-6 text-sm text-right">
                        @foreach ($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
                    </div>
                @endif

                <form action="{{ route('auth.signup') }}" method="POST" enctype="multipart/form-data" class="text-right">
                    @csrf

                    {{-- input classes reused --}}
                    @php $input = "w-full bg-slate-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-4 py-3.5 text-slate-800 dark:text-slate-100 text-sm outline-none focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 dark:focus:ring-indigo-900/30 transition placeholder-slate-300 dark:placeholder-slate-500"; @endphp

                    {{-- STEP 1 --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                        <div class="mb-2">
                            <p class="text-xs font-bold text-indigo-500 dark:text-indigo-400 tracking-widest mb-1">الخطوة 1 من 3</p>
                            <h2 class="text-2xl font-black text-slate-900 dark:text-white">البيانات الشخصية</h2>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">أدخل معلوماتك الأساسية للبدء</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">الاسم الكامل</label>
                                <input type="text" name="name" required placeholder="محمد أحمد" value="{{ old('name') }}" class="{{ $input }}">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">رقم الهاتف</label>
                                <input type="text" name="phone" required placeholder="01XXXXXXXXX" value="{{ old('phone') }}" class="{{ $input }}">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">البريد الإلكتروني</label>
                            <input type="email" name="email" required placeholder="example@email.com" value="{{ old('email') }}" class="{{ $input }}">
                        </div>
                        <div class="pt-2">
                            <button type="button" @click="step = 2" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:-translate-y-0.5 transform duration-200">التالي ←</button>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                        <div class="mb-2">
                            <p class="text-xs font-bold text-indigo-500 dark:text-indigo-400 tracking-widest mb-1">الخطوة 2 من 3</p>
                            <h2 class="text-2xl font-black text-slate-900 dark:text-white">عن نفسك</h2>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">أخبرنا أكثر عن شخصيتك</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">النوع</label>
                            <div class="flex gap-3">
                                <label class="flex-1 flex items-center justify-center gap-2 bg-slate-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-4 py-3.5 cursor-pointer text-slate-600 dark:text-slate-300 font-semibold text-sm transition hover:border-indigo-300 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30 has-[:checked]:text-indigo-600 dark:has-[:checked]:text-indigo-400">
                                    <input type="radio" name="gender" value="male" class="hidden"> 👨 ذكر
                                </label>
                                <label class="flex-1 flex items-center justify-center gap-2 bg-slate-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-4 py-3.5 cursor-pointer text-slate-600 dark:text-slate-300 font-semibold text-sm transition hover:border-indigo-300 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30 has-[:checked]:text-indigo-600 dark:has-[:checked]:text-indigo-400">
                                    <input type="radio" name="gender" value="female" class="hidden"> 👩 أنثى
                                </label>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">الصورة الشخصية</label>
                            <input type="file" name="avatar" accept="image/*" class="{{ $input }} cursor-pointer file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-600 dark:file:text-indigo-400 file:border-0 file:font-bold file:text-xs file:rounded-lg file:px-3 file:py-1 file:mr-2">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">نبذة مختصرة عنك</label>
                            <textarea name="bio" rows="3" placeholder="اكتب شيئاً عن نفسك..." class="{{ $input }} resize-none">{{ old('bio') }}</textarea>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="step = 1" class="w-1/3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl transition text-sm">→ السابق</button>
                            <button type="button" @click="step = 3" class="w-2/3 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:-translate-y-0.5 transform duration-200">التالي ←</button>
                        </div>
                    </div>

                    {{-- STEP 3 --}}
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                        <div class="mb-2">
                            <p class="text-xs font-bold text-indigo-500 dark:text-indigo-400 tracking-widest mb-1">الخطوة 3 من 3</p>
                            <h2 class="text-2xl font-black text-slate-900 dark:text-white">تأمين الحساب</h2>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">اختر كلمة مرور قوية لحماية حسابك</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">كلمة المرور</label>
                            <input type="password" name="password" required placeholder="••••••••" class="{{ $input }}">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="{{ $input }}">
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-2xl p-4">
                            <p class="text-amber-700 dark:text-amber-400 text-xs font-semibold leading-relaxed">⚠️ يجب أن تكون كلمة المرور 8 أحرف على الأقل وتحتوي على أحرف وأرقام</p>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="step = 2" class="w-1/3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl transition text-sm">→ السابق</button>
                            <button type="submit" class="w-2/3 bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-emerald-200 dark:shadow-emerald-900/50 hover:-translate-y-0.5 transform duration-200">✓ إنشاء الحساب</button>
                        </div>
                    </div>

                </form>

                <p class="text-center text-slate-400 dark:text-slate-500 text-sm mt-6">
                    لديك حساب بالفعل؟
                    <a href="{{ route('auth.login') }}" class="text-indigo-600 dark:text-indigo-400 font-black hover:underline">تسجيل الدخول</a>
                </p>
            </div>

            {{-- ══ Visual panel ══ --}}
            <div class="hidden md:flex md:col-span-2 flex-col items-center justify-center relative overflow-hidden p-10 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-slate-700 dark:to-slate-800 transition-colors duration-300">
                <div class="absolute top-[-10%] left-[-10%] w-56 h-56 bg-indigo-200/30 dark:bg-indigo-600/10 rounded-full blur-[60px] pointer-events-none"></div>
                <div class="relative z-10 text-center w-full">
                    <div class="relative inline-block mb-7">
                        <div class="w-32 h-32 bg-white dark:bg-slate-700 rounded-3xl shadow-xl flex items-center justify-center mx-auto border border-indigo-50 dark:border-slate-600">
                            <svg class="w-16 h-16 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div class="float absolute -bottom-3 -right-5 bg-white dark:bg-slate-700 rounded-2xl shadow-lg px-3 py-2 flex items-center gap-2 border border-gray-100 dark:border-slate-600">
                            <span class="text-base">🎓</span>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">انضم الآن!</span>
                        </div>
                    </div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white mb-2">ابدأ رحلتك التعليمية</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-7 max-w-[200px] mx-auto">انضم لأكثر من 1000 طالب في Suez E-Learning</p>
                    <div class="space-y-3 text-right">
                        <template x-for="(s, i) in [{label:'البيانات الشخصية', sub:'الاسم والبريد والهاتف'},{label:'عن نفسك', sub:'الصورة والنوع والنبذة'},{label:'تأمين الحساب', sub:'كلمة المرور وتأكيدها'}]" :key="i">
                            <div :class="step >= i+1 ? 'border-indigo-200 dark:border-indigo-700 bg-white dark:bg-slate-700' : 'border-gray-100 dark:border-slate-600 bg-white/50 dark:bg-slate-700/50'"
                                class="rounded-2xl p-3.5 flex items-center gap-3 border transition-all duration-300 shadow-sm">
                                <div :class="step >= i+1 ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-slate-500'"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black flex-shrink-0 transition-all" x-text="i+1"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-200" x-text="s.label"></p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500" x-text="s.sub"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
