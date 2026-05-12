@extends('layouts.master')

@section('title', 'instructor Dashboard')

@section('content')

<div class="min-h-screen bg-[#f8f9fa] p-4 lg:p-10" dir="rtl">
    <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-800">لوحة المحاضر: {{ auth()->user()->name }} 👨‍🏫</h1>
            <p class="text-gray-500 mt-1">إليك تقرير سريع عن أداء كورساتك وطلابك.</p>
        </div>
        <a href="#" class="px-8 py-4 bg-indigo-600 text-white rounded-[20px] font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus text-sm"></i>
            إنشاء كورس جديد
        </a>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 border-b-4 border-b-blue-500">
            <p class="text-gray-400 font-bold text-sm tracking-widest mb-2">إجمالي الكورسات</p>
            <h3 class="text-4xl font-black text-gray-800">{{ $total_courses ?? 0 }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 border-b-4 border-b-orange-500">
            <p class="text-gray-400 font-bold text-sm tracking-widest mb-2">إجمالي الطلاب</p>
            <h3 class="text-4xl font-black text-gray-800">{{ $total_students ?? 0 }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 border-b-4 border-b-yellow-500">
            <p class="text-gray-400 font-bold text-sm tracking-widest mb-2">متوسط التقييم</p>
            <h3 class="text-4xl font-black text-gray-800">{{ $avg_rating ?? '0.0' }} <span class="text-lg text-yellow-500">★</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h2 class="text-2xl font-bold text-gray-800">إدارة كورساتي</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="p-6 text-gray-500 font-bold uppercase text-xs tracking-widest">الكورس</th>
                        <th class="p-6 text-gray-500 font-bold uppercase text-xs tracking-widest text-center">الطلاب المسجلين</th>
                        <th class="p-6 text-gray-500 font-bold uppercase text-xs tracking-widest text-center">السعر</th>
                        <th class="p-6 text-gray-500 font-bold uppercase text-xs tracking-widest text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- @foreach($instructor_courses as $course)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="p-6 flex items-center gap-4">
                            <img src="{{ asset('storage/'.$course->image) }}" class="w-14 h-14 rounded-xl object-cover">
                            <span class="font-bold text-gray-800">{{ $course->title }}</span>
                        </td>
                        <td class="p-6 text-center font-semibold text-gray-600">{{ $course->students_count }} طالب</td>
                        <td class="p-6 text-center font-bold text-indigo-600">${{ $course->price }}</td>
                        <td class="p-6 text-left space-x-2 space-x-reverse">
                            <button class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach --}}
                    <tr></tr>
                        <td class="p-6 text-center" colspan="4">
                            <p class="text-gray-400 italic">لا توجد كورسات مسجلة حالياً.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
