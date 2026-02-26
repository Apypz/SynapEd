<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;

class LessonController extends Controller
{
    public function show(string $courseSlug, string $lessonSlug = null)
    {
        $course = LmsData::findCourse($courseSlug);

        if (! $course) {
            abort(404);
        }

        $flatLessons = LmsData::flatLessons($course);
        $iconPaths   = LmsData::iconPaths();

        // Default to first lesson if none specified
        if (! $lessonSlug) {
            $lesson = $flatLessons[0] ?? null;
        } else {
            $lesson = LmsData::findLesson($course, $lessonSlug);
        }

        if (! $lesson) {
            abort(404);
        }

        // Determine prev / next lesson
        $currentIndex = null;
        foreach ($flatLessons as $i => $l) {
            if ($l['slug'] === $lesson['slug']) {
                $currentIndex = $i;
                break;
            }
        }

        $prevLesson = ($currentIndex > 0) ? $flatLessons[$currentIndex - 1] : null;
        $nextLesson = isset($flatLessons[$currentIndex + 1]) ? $flatLessons[$currentIndex + 1] : null;

        return view('courses.learn', compact(
            'course', 'lesson', 'flatLessons', 'iconPaths', 'prevLesson', 'nextLesson'
        ));
    }
}
