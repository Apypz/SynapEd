<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonPolicy
{
    public function update(User $user, Lesson $lesson): Response
    {
        return $user->isAdmin() || $lesson->course->user_id === $user->id
            ? Response::allow()
            : Response::deny('Anda hanya dapat mengubah materi pada kursus milik Anda sendiri.');
    }

    public function delete(User $user, Lesson $lesson): Response
    {
        return $user->isAdmin() || $lesson->course->user_id === $user->id
            ? Response::allow()
            : Response::deny('Anda hanya dapat menghapus materi pada kursus milik Anda sendiri.');
    }
}
