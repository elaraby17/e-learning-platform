<?php

namespace App\Http\Middleware;

use App\Models\Enrollment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEnrollment
{
    public function handle($request, Closure $next)
    {
        $course = $request->route('course') ;

        $enrolled = Enrollment::where('student_id', auth()->id())
            ->where('course_id', $course->id)
            ->exists();

        if (!$enrolled) {
            return redirect()
                ->route('all-courses')
                ->with('error', 'يجب الاشتراك في الكورس أولاً');
        }

        return $next($request);
    }
}
