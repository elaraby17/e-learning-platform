<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /** Owner of the course or an admin. */
    public function manage(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->instructor_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    public function view(User $user, Course $course): bool
    {
        return $this->manage($user, $course);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    public function update(User $user, Course $course): bool
    {
        return $this->manage($user, $course);
    }

    public function delete(User $user, Course $course): bool
    {
        return $this->manage($user, $course);
    }

    // Not used (no SoftDeletes yet)
    public function restore(User $user, Course $course): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return $user->role === 'admin';
    }
}
