<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Course $course): bool
    {
        return $user->id === $course->user_id || $user->role_id === 3;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id, [2, 3]);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->user_id || $user->role_id === 3;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id || $user->role_id === 3;
    }
}
