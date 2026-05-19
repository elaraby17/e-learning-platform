@props([
    'course',
    'title',
    'image',
    'categoryName' => 'جديد',
    'instructorName',
    'instructorImage',
    'price' => 0
])

<div class="group bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-500 transition-all duration-500 hover:-translate-y-2">

    {{-- Course Image & Badge --}}
    <div class="relative p-3">
        <div class="relative h-52 overflow-hidden rounded-[2rem]">
            <img src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-md text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-lg">
                {{ $categoryName }}
            </span>
        </div>
    </div>

    {{-- Course Details --}}
    <div class="p-6 pt-2">
        {{-- Ratings --}}
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-yellow-400">
                @for ($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
            <span class="text-slate-400 text-xs font-bold">(4.9)</span>
        </div>

        {{-- Title --}}
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-indigo-600 transition-colors">
            <a href="{{ route('course-details', $course) }}">{{ $title }}</a>
        </h3>

        {{-- Instructor --}}
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ $instructorImage }}"
                class="w-6 h-6 rounded-full object-cover ring-2 ring-indigo-500/10">
            <span class="text-slate-500 dark:text-slate-400 text-xs font-medium">{{ $instructorName }}</span>
        </div>

        {{-- Price & Enrollment Action --}}
        <div class="flex items-center justify-between pt-5 border-t border-slate-100 dark:border-slate-700/50">
            <div class="flex flex-col">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">السعر</span>
                <span class="text-xl font-black text-slate-900 dark:text-white">
                    {{ $price > 0 ? $price . ' ج.م' : 'مجاناً' }}
                </span>
            </div>

            @if (!$course->students->contains(auth()->id()))
                <form method="POST" action="{{ route('courses.enroll', $course) }}">
                    @csrf
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-600/10 transition">
                        اشترك الآن
                    </button>
                </form>
            @else
                <button disabled class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-xl font-bold text-xs cursor-not-allowed">
                    أنت مشترك بالفعل
                </button>
            @endif
        </div>
    </div>
</div>
