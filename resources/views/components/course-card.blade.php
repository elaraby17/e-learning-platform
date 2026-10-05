@props([
    'course',
    'title',
    'image',
    'description',
    'categoryName' => 'جديد',
    'instructorName',
    'instructorImage',
    'price' => 0,
    'lessonsCount' => null,
    'studentsCount' => null,
    'rating' => 4.9,
    'progress' => null,
])

@php
    $isEnrolled = $course->students->contains(auth()->id());
    $cover = $image ?: null;
    $instructorAvatar = $instructorName
        ? \Illuminate\Support\Str::of($instructorName)->substr(0, 1)->upper()
        : '?';
    $progressValue = is_null($progress) ? null : max(0, min(100, (int) $progress));

    /* التقييم اختياري: لو غير متاح نخفي النجوم بدل عرض 0.0 */
    $hasRating = ! is_null($rating) && (float) $rating > 0;
@endphp

{{-- course-card · روح Udemy: غلاف 16:9، بادج، سطران للعنوان، مدرس، نجوم،
     عدد الطلاب، شريط تقدم للطالب، والسعر/الزر. hover: يرتفع + تكبّر الصورة. --}}
<article
    class="group surface-card relative flex flex-col overflow-hidden transition-all duration-200 hover:-translate-y-0.5 hover:shadow-brand dark:hover:border-brand-500/40">

    {{-- ══ الغلاف 16:9 ══ --}}
    <div class="relative aspect-video overflow-hidden bg-accent">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $title }}" loading="lazy" data-img-fallback
                class="size-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <span class="absolute inset-0 flex items-center justify-center text-5xl font-extrabold text-white/90"
                aria-hidden="true">
                {{ \Illuminate\Support\Str::of($title ?: '؟')->substr(0, 1)->upper() }}
            </span>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-ink/10 to-transparent"></div>

        {{-- بادج التصنيف --}}
        <span
            class="absolute top-3 start-3 rounded-full bg-overlay/95 px-3 py-1.5 text-xs font-bold text-accent-soft-foreground shadow-overlay backdrop-blur">
            {{ $categoryName }}
        </span>

        {{-- عدد الدروس --}}
        @if ($lessonsCount)
            <span
                class="absolute bottom-3 end-3 flex items-center gap-1.5 rounded-full bg-ink/70 px-2.5 py-1.5 text-xs font-extrabold text-white backdrop-blur">
                <i class="fa-solid fa-book-open text-[10px] text-brand-300" aria-hidden="true"></i>
                {{ $lessonsCount }} درس
            </span>
        @endif

        {{-- شريط التقدّم للطالب --}}
        @if ($isEnrolled && ! is_null($progressValue))
            <div class="absolute inset-x-0 bottom-0 h-1.5 bg-ink/40" role="progressbar"
                aria-valuenow="{{ $progressValue }}" aria-valuemin="0" aria-valuemax="100" aria-label="نسبة إكمال الكورس">
                <div class="h-full rounded-full bg-success"
                    style="width: {{ $progressValue }}%"></div>
            </div>
        @endif
    </div>

    {{-- ══ المحتوى ══ --}}
    <div class="flex flex-1 flex-col p-5">
        {{-- التقييم + عدد الطلاب --}}
        @if ($hasRating || ! is_null($studentsCount))
            <div class="mb-2 flex items-center gap-3">
                @if ($hasRating)
                    <span class="flex items-center gap-1.5">
                        <span class="flex" aria-hidden="true">
                            @for ($star = 1; $star <= 5; $star++)
                                <i @class([
                                    'fa-solid fa-star text-[11px]',
                                    'text-amber-400' => $star <= round((float) $rating),
                                    'text-slate-300 dark:text-navy-border' => $star > round((float) $rating),
                                ])></i>
                            @endfor
                        </span>
                        <span class="text-sm font-extrabold text-ink dark:text-mist" dir="ltr">
                            {{ number_format((float) $rating, 1) }}
                        </span>
                    </span>
                @endif

                @if (! is_null($studentsCount))
                    <span class="flex items-center gap-1.5 text-xs font-bold text-ink-muted">
                        <i class="fa-solid fa-users text-[11px]" aria-hidden="true"></i>
                        {{ number_format($studentsCount) }} طالب
                    </span>
                @endif
            </div>
        @endif

        {{-- العنوان (سطران) --}}
        <h3 class="mb-2 line-clamp-2 min-h-[3rem] text-[17px] leading-snug font-extrabold text-ink dark:text-mist">
            <a href="{{ route('course-details', $course) }}"
                class="transition-colors group-hover:text-brand-600 dark:group-hover:text-brand-300">
                {{ $title }}
            </a>
        </h3>

        @if ($description)
            <p class="mb-4 line-clamp-2 text-sm text-ink-muted">{{ $description }}</p>
        @endif

        {{-- المدرس --}}
        <div class="mb-4 flex items-center gap-2.5">
            <span
                class="bg-accent-gradient relative flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full text-xs font-extrabold text-white">
                <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                    {{ $instructorAvatar }}
                </span>
                @if ($instructorImage)
                    <img src="{{ $instructorImage }}" alt="{{ $instructorName }}" loading="lazy" data-img-fallback
                        class="relative size-full object-cover">
                @endif
            </span>
            <span class="min-w-0 truncate text-sm font-bold text-ink dark:text-mist">{{ $instructorName }}</span>
        </div>

        {{-- التقدّم أو السعر + الإجراء --}}
        @if ($isEnrolled)
            <div class="mt-auto">
                <x-progress class="mb-3" :value="$progressValue ?? 0" label="نسبة الإكمال"
                    :show-value="! is_null($progressValue)" size="sm" tone="emerald" />

                <x-button block icon="fa-solid fa-play" :href="route('course-details', $course)">
                    {{ ! is_null($progressValue) ? 'أكمل التعلم' : 'ابدأ التعلم' }}
                </x-button>
            </div>
        @else
            <div class="mt-auto flex items-center justify-between gap-2 border-t border-dashed border-separator pt-4 dark:border-navy-border">
                <div class="flex flex-col leading-tight">
                    <span class="text-[11px] font-extrabold tracking-wider text-ink-soft uppercase">السعر</span>
                    <span class="text-lg font-extrabold text-ink dark:text-mist">
                        {{ $price > 0 ? number_format($price) . ' ج.م' : 'مجاناً' }}
                    </span>
                </div>

                @if ((float) $course->price > 0)
                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                        @csrf
                        <x-button type="submit" size="sm" icon="fa-solid fa-bolt">اشترك الآن</x-button>
                    </form>
                @else
                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                        @csrf
                        <x-button type="submit" size="sm" icon="fa-solid fa-bolt">اشترك مجاناً</x-button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</article>
