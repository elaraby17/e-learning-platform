<?php
// app/Services/EnrollmentService.php
namespace App\Services;

use App\Exceptions\AlreadyEnrolledException;
use App\Exceptions\CourseNotAvailableException;
use App\Exceptions\NotEnrolledException;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    public function enroll(User $user, Course $course): Enrollment
    {
        if ($course->status !== 'published') {
            throw new CourseNotAvailableException();
        }

        return DB::transaction(function () use ($user, $course) {
            $enrollment = Enrollment::firstOrCreate(
                ['student_id' => $user->id, 'course_id' => $course->id],
                [
                    'progress_percentage' => 0,
                    'price'               => $course->price,
                    'status'              => 'active',
                    'enrolled_at'         => now(),
                ]
            );

            if (! $enrollment->wasRecentlyCreated) {
                throw new AlreadyEnrolledException();
            }

            return $enrollment;
        });
    }

    /** @throws NotEnrolledException */
    public function getEnrollmentOrFail(User $user, Course $course): Enrollment
    {
        return Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->first() ?? throw new NotEnrolledException();
    }

    public function userEnrollments(User $user): Collection
    {
        return $user->enrollments()->with('course')->get();
    }

    public function userCourses(User $user, int $perPage = 10)
    {
        return Course::whereHas('enrollments', fn ($q) => $q->where('student_id', $user->id))
            ->with(['instructor', 'category'])
            ->paginate($perPage);
    }
}
