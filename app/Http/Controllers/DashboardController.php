<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user       = User::find(Auth::id()) ?? Auth::user();
        $courses    = Course::with('lessons')->latest()->get();
        $levelMap   = LmsData::levelColorMap();
        $iconPaths  = LmsData::iconPaths();
        $allUsers   = User::latest()->get();

        // ── STUDENT ENROLLED COURSES (REAL FROM DATABASE) ────────────────────
        $studentEnrollments = Enrollment::where('user_id', $user->id)->with('course')->get();
        $enrolled = [];

        foreach ($studentEnrollments as $en) {
            if ($en->course) {
                $enrolled[] = [
                    'course' => $en->course->toArray(),
                    'progress' => $en->progress ?: 0,
                    'last_lesson' => $en->last_lesson_slug ?: 'pengantar-' . $en->course->slug,
                ];
            }
        }

        // If student has no enrollments yet, fallback to default course preview for smooth onboarding
        if (empty($enrolled) && count($courses) > 0) {
            $enrolled[] = [
                'course' => $courses[0]->toArray(),
                'progress' => 0,
                'last_lesson' => 'pengantar-' . $courses[0]->slug,
            ];
        }

        // ── STUDENT LEARNING STATS (REAL, COMPUTED FROM completed_lessons) ───
        $completedLessonsCount = 0;
        $completedMinutes = 0;
        foreach ($studentEnrollments as $en) {
            $completed = $en->completed_lessons ?? [];
            $completedLessonsCount += count($completed);
            if (! empty($completed)) {
                $durations = Lesson::where('course_id', $en->course_id)->whereIn('slug', $completed)->pluck('duration');
                foreach ($durations as $duration) {
                    $completedMinutes += LmsData::durationToMinutes($duration);
                }
            }
        }
        $completedHours = round($completedMinutes / 60, 1);
        $avgProgress = $studentEnrollments->count() > 0 ? round($studentEnrollments->avg('progress')) : 0;

        // ── EDUCATOR DATA (REAL FROM DATABASE) ───────────────────────────────
        $educatorCourses = Course::where('user_id', $user->id)->orWhere('instructor', $user->name)->get();
        $educatorCourseIds = $educatorCourses->pluck('id')->toArray();

        $studentProgress = Enrollment::whereIn('course_id', $educatorCourseIds)
            ->with(['user', 'course'])
            ->latest()
            ->get();

        $totalEducatorStudents = Enrollment::whereIn('course_id', $educatorCourseIds)->distinct('user_id')->count('user_id');
        $totalEducatorLessons = Lesson::whereIn('course_id', $educatorCourseIds)->count();

        // ── DYNAMIC STATS PER ROLE ───────────────────────────────────────────
        if ($user->isAdmin()) {
            $stats = [
                ['label' => 'Total Pengguna',     'value' => count($allUsers), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Total Kursus',       'value' => count($courses),  'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['label' => 'Total Pendaftaran',  'value' => Enrollment::count(), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Kursus Dipublikasi', 'value' => Course::where('is_published', true)->count(), 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ];
        } elseif ($user->isEducator()) {
            $stats = [
                ['label' => 'Kursus Saya',       'value' => count($educatorCourses), 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['label' => 'Total Peserta',     'value' => $totalEducatorStudents ?: '0', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Pelajaran Dibuat',  'value' => $totalEducatorLessons ?: '0',  'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label' => 'Rata-rata Progress Siswa', 'value' => ($studentProgress->count() > 0 ? round($studentProgress->avg('progress')) : 0) . '%', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
            ];
        } else {
            $stats = [
                ['label' => 'Kursus Diikuti',    'value' => count($enrolled), 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['label' => 'Pelajaran Selesai', 'value' => $completedLessonsCount, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Jam Belajar',       'value' => $completedHours,  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Progress Rata-rata', 'value' => $avgProgress . '%', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ];
        }

        return view('dashboard', compact('courses', 'levelMap', 'iconPaths', 'user', 'enrolled', 'stats', 'allUsers', 'studentProgress', 'educatorCourses'));
    }
}
