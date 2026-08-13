<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request, Course $course)
    {
        $user = auth()->user();

        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('learn', $course->slug)->with('info', 'Anda sudah terdaftar di kursus ini.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
            'status' => 'active',
            'completed_lessons' => [],
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil mendaftar kursus ' . $course->title . '!');
    }
}
