@extends('layouts.master')
@section('title', 'home')
@section('content')
<div class="min-h-screen bg-[#f8f9fa] p-4 lg:p-10" dir="rtl">
    <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-800 family-cairo">أهلاً بك، {{ auth()->user()->name }} 👋</h1>
            <p class="text-gray-500 mt-1">سعيد برؤيتك مرة أخرى، لنكمل رحلة التعلم اليوم.</p>
        </div>
        <a href="" class="px-8 py-4 bg-indigo-600 text-white rounded-[20px] font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
            <i class="fa-solid fa-magnifying-glass text-sm"></i>
            تصفح الكورسات
        </a>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <p class="text-gray-400 font-bold text-sm uppercase tracking-widest">كورسات مسجلة</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $enrolled_count ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-gray-400 font-bold text-sm uppercase tracking-widest">كورسات مكتملة</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $completed_count ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 flex items-center gap-6">
            <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl">
                <i class="fa-solid fa-award"></i>
            </div>
            <div>
                <p class="text-gray-400 font-bold text-sm uppercase tracking-widest">شهادات محصلة</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $certificates_count ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-3">
            <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
            تابع التعلم
        </h2>

        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($in_progress_courses as $course)
            <div class="bg-gray-50/50 rounded-[30px] p-6 border border-transparent hover:border-indigo-100 transition-all group">
                <img src="{{ asset('storage/'.$course->image) }}" class="w-full h-40 object-cover rounded-[24px] mb-4 shadow-sm">
                <h4 class="font-bold text-lg text-gray-800 mb-4">{{ $course->title }}</h4>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm font-bold">
                        <span class="text-indigo-600">{{ $course->pivot->progress }}%</span>
                        <span class="text-gray-400">مكتمل</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000" style="width: {{ $course->pivot->progress }}%"></div>
                    </div>
                </div>

                <a href="#" class="mt-6 w-full py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold block text-center hover:bg-indigo-600 hover:text-white transition-all">
                    إكمال الدرس
                </a>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-400 italic">لا توجد كورسات قيد الدراسة حالياً، ابدأ رحلتك الآن!</p>
            </div>
            @endforelse
        </div> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-gray-50/50 rounded-[30px] p-6 border border-transparent hover:border-indigo-100 transition-all group">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="w-full h-40 object-cover rounded-[24px] mb-4 shadow-sm">
                <h4 class="font-bold text-lg text-gray-800 mb-4">كورسات قيد الدراسة</h4>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm font-bold">
                        <span class="text-indigo-600">95%</span>
                        <span class="text-gray-400">مكتمل</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000" style="width: 95%"></div>
                    </div>
                </div>

                <a href="#" class="mt-6 w-full py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold block text-center hover:bg-indigo-600 hover:text-white transition-all">
                    إكمال الدرس
                </a>
            </div>
   
        </div>
    </div>
</div>
@endsection
