<?php

namespace App\Services\Student;

use App\Exceptions\AlreadyEnrolledException;
use App\Exceptions\CourseNotAvailableException;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// اشتراك الطالب في الكورسات
class StudentEnrollmentService
{
    public function enroll(User $student, Course $course): Enrollment
    {
        // مينفعش يشترك في كورس مسودة
        if ($course->status !== 'published') {
            throw new CourseNotAvailableException();
        }

        return DB::transaction(function () use ($student, $course) {
            $enrollment = Enrollment::firstOrCreate(
                ['student_id' => $student->id, 'course_id' => $course->id],
                [
                    'progress_percentage' => 0,
                    'price'               => $course->price,
                    'status'              => 'active',
                    'enrolled_at'         => now(),
                ]
            );

            // لو الاشتراك كان موجود قبل كده
            if (! $enrollment->wasRecentlyCreated) {
                throw new AlreadyEnrolledException();
            }

            // زود عداد الطلاب في الكورس
            $course->increment('total_students');

            return $enrollment;
        });
    }

    public function isEnrolled(User $student, Course $course): bool
    {
        return Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->exists();
    }

    public function myEnrollments(User $student)
    {
        return $student->enrollments()->with('course')->get();
    }
}
