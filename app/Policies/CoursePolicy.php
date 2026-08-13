<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    public function update(User $user, Course $course): Response
    {
        return $user->isAdmin() || $course->user_id === $user->id
            ? Response::allow()
            : Response::deny('Anda hanya dapat mengubah kursus milik Anda sendiri.');
    }

    public function delete(User $user, Course $course): Response
    {
        return $user->isAdmin() || $course->user_id === $user->id
            ? Response::allow()
            : Response::deny('Anda hanya dapat menghapus kursus milik Anda sendiri.');
    }
}
