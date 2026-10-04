<?php

namespace App\Http\Middleware;

use App\Services\Student\StudentEnrollmentService;
use Closure;
use Illuminate\Http\Request;

// بيمنع الطالب يفتح كورس هو مش مشترك فيه
class CheckEnrollment
{
    public function __construct(private StudentEnrollmentService $enrollmentService) {}

    public function handle(Request $request, Closure $next)
    {
        $course = $request->route('course');

        if (! $this->enrollmentService->isEnrolled($request->user(), $course)) {
            return redirect()
                ->route('all-courses')
                ->with('error', 'يجب الاشتراك في الكورس أولاً');
        }

        return $next($request);
    }
}
