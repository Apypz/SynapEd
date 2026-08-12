<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function show(string $courseSlug, string $lessonSlug = null)
    {
        $user = auth()->user();
        $courseModel = Course::where('slug', $courseSlug)->with('lessons')->first();

        if (! $courseModel) {
            abort(404);
        }

        // Fetch or create enrollment for student
        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseModel->id,
            ],
            [
                'progress' => 0,
                'status' => 'active',
                'completed_lessons' => [],
            ]
        );

        $completedLessons = $enrollment->completed_lessons ?? [];
        $iconPaths = LmsData::iconPaths();
        $dbLessons = $courseModel->lessons;

        // Build flat lessons list
        $flatLessons = [];
        foreach ($dbLessons as $l) {
            $isCompleted = in_array($l->slug, $completedLessons);
            $flatLessons[] = [
                'id' => $l->id,
                'slug' => $l->slug,
                'title' => $l->title,
                'type' => $l->type,
                'duration' => $l->duration,
                'content' => $l->content ?: ('Materi pembelajaran ' . $l->title . '. Jelajahi topik ini secara mendalam.'),
                'video_url' => $l->video_url,
                'transcript' => $l->transcript,
                'attachment_path' => $l->attachment_path,
                'quiz_data' => $l->quiz_data,
                'free' => (bool)$l->free,
                'section_title' => $l->section_title ?: 'Modul Utama',
                'is_completed' => $isCompleted,
            ];
        }

        if (empty($flatLessons)) {
            $flatLessons[] = [
                'id' => 1,
                'slug' => 'pengantar',
                'title' => 'Pengantar ' . $courseModel->title,
                'type' => 'video',
                'duration' => '15 menit',
                'content' => 'Materi pengantar kursus.',
                'free' => true,
                'section_title' => 'Modul Utama',
                'is_completed' => in_array('pengantar', $completedLessons),
            ];
        }

        // Calculate real progress percentage
        $totalLessons = count($flatLessons);
        $completedCount = count(array_filter($flatLessons, fn ($l) => $l['is_completed']));
        $progressPct = $totalLessons > 0 ? min(100, round(($completedCount / $totalLessons) * 100)) : 0;

        if ($enrollment->progress !== $progressPct) {
            $enrollment->progress = $progressPct;
            $enrollment->save();
        }

        // Current lesson
        if (! $lessonSlug) {
            $lesson = $flatLessons[0];
        } else {
            $lesson = collect($flatLessons)->firstWhere('slug', $lessonSlug) ?: $flatLessons[0];
        }

        // Prev / next lesson
        $currentIndex = 0;
        foreach ($flatLessons as $i => $l) {
            if ($l['slug'] === $lesson['slug']) {
                $currentIndex = $i;
                break;
            }
        }

        $prevLesson = ($currentIndex > 0) ? $flatLessons[$currentIndex - 1] : null;
        $nextLesson = isset($flatLessons[$currentIndex + 1]) ? $flatLessons[$currentIndex + 1] : null;

        // Group lessons into sections
        $sectionsMap = [];
        foreach ($flatLessons as $l) {
            $secTitle = $l['section_title'];
            if (! isset($sectionsMap[$secTitle])) {
                $sectionsMap[$secTitle] = [];
            }
            $sectionsMap[$secTitle][] = $l;
        }

        $sections = [];
        $secIndex = 1;
        foreach ($sectionsMap as $secTitle => $secLessons) {
            $sections[] = [
                'id' => $secIndex++,
                'title' => $secTitle,
                'lessons' => $secLessons,
            ];
        }

        $course = $courseModel->toArray();
        $course['sections'] = $sections;
        $course['progress_pct'] = $progressPct;
        $course['completed_count'] = $completedCount;
        $course['total_lessons'] = $totalLessons;

        return view('courses.learn', compact(
            'course', 'lesson', 'flatLessons', 'iconPaths', 'prevLesson', 'nextLesson', 'enrollment'
        ));
    }

    public function create(Request $request, Course $course)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $type = $request->query('type', 'video');

        if ($type === 'reading') {
            return view('lessons.manage_reading', compact('course'));
        } elseif ($type === 'quiz') {
            return view('lessons.manage_quiz', compact('course'));
        }

        return view('lessons.manage_video', compact('course'));
    }

    public function edit(Lesson $lesson)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $course = $lesson->course;

        if ($lesson->type === 'reading') {
            return view('lessons.manage_reading', compact('course', 'lesson'));
        } elseif ($lesson->type === 'quiz') {
            return view('lessons.manage_quiz', compact('course', 'lesson'));
        }

        return view('lessons.manage_video', compact('course', 'lesson'));
    }

    public function markComplete(Request $request, string $courseSlug, string $lessonSlug)
    {
        $user = auth()->user();
        $courseModel = Course::where('slug', $courseSlug)->firstOrFail();

        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $courseModel->id,
            ],
            [
                'progress' => 0,
                'status' => 'active',
                'completed_lessons' => [],
            ]
        );

        $completed = $enrollment->completed_lessons ?? [];

        if (! in_array($lessonSlug, $completed)) {
            $completed[] = $lessonSlug;
        }

        $totalLessons = $courseModel->lessons()->count() ?: 1;
        $completedCount = count($completed);
        $newProgress = min(100, round(($completedCount / $totalLessons) * 100));

        $enrollment->completed_lessons = $completed;
        $enrollment->progress = $newProgress;
        $enrollment->last_lesson_slug = $lessonSlug;
        $enrollment->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'progress' => $newProgress,
                'message' => "Pelajaran diselesaikan! Progress Anda sekarang {$newProgress}%.",
            ]);
        }

        $dbLessons = $courseModel->lessons;
        $currentIndex = null;
        foreach ($dbLessons as $idx => $l) {
            if ($l->slug === $lessonSlug) {
                $currentIndex = $idx;
                break;
            }
        }

        $nextLesson = ($currentIndex !== null && isset($dbLessons[$currentIndex + 1])) ? $dbLessons[$currentIndex + 1] : null;

        if ($nextLesson) {
            return redirect()->route('learn.lesson', [$courseSlug, $nextLesson->slug])
                ->with('success', "✓ Pelajaran diselesaikan! Progress Anda bertambah ke {$newProgress}%.");
        }

        return redirect()->route('learn.lesson', [$courseSlug, $lessonSlug])
            ->with('success', "🎉 Selamat! Anda telah menyelesaikan seluruh materi di modul ini. Total Progress: {$newProgress}%.");
    }

    public function store(Request $request, Course $course)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'section_title' => 'required|string',
            'type' => 'required|in:video,reading,quiz',
            'duration' => 'required|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string',
            'transcript' => 'nullable|string',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment_file')) {
            $path = $request->file('attachment_file')->store('attachments', 'public');
            $attachmentPath = '/storage/' . $path;
        }

        $quizData = null;
        if ($validated['type'] === 'quiz' && $request->has('questions')) {
            $quizData = array_values($request->input('questions'));
        }

        $slug = Str::slug($validated['title']);
        if (Lesson::where('course_id', $course->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(3);
        }

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'section_title' => $validated['section_title'],
            'type' => $validated['type'],
            'duration' => $validated['duration'],
            'content' => $validated['content'] ?: ('Materi ' . $validated['title']),
            'video_url' => $validated['video_url'] ?? null,
            'transcript' => $validated['transcript'] ?? null,
            'attachment_path' => $attachmentPath,
            'quiz_data' => $quizData,
            'free' => false,
            'sort_order' => $course->lessons()->count() + 1,
        ]);

        return redirect()->route('dashboard')->with('success', 'Materi "' . $lesson->title . '" (' . ucfirst($lesson->type) . ') berhasil diterbitkan!');
    }

    public function update(Request $request, Lesson $lesson)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'section_title' => 'required|string',
            'type' => 'required|in:video,reading,quiz',
            'duration' => 'required|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|string',
            'transcript' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment_file')) {
            $path = $request->file('attachment_file')->store('attachments', 'public');
            $validated['attachment_path'] = '/storage/' . $path;
        }

        if ($validated['type'] === 'quiz' && $request->has('questions')) {
            $validated['quiz_data'] = array_values($request->input('questions'));
        }

        $lesson->update($validated);

        return redirect()->route('dashboard')->with('success', 'Materi "' . $lesson->title . '" (' . ucfirst($lesson->type) . ') berhasil diperbarui!');
    }

    public function destroy(Lesson $lesson)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $title = $lesson->title;
        $lesson->delete();

        return redirect()->back()->with('success', 'Materi "' . $title . '" berhasil dihapus!');
    }
}
