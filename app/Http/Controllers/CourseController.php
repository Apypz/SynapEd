<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;

class CourseController extends Controller
{
    public function index()
    {
        $courses    = LmsData::courses();
        $levelMap   = LmsData::levelColorMap();
        $iconPaths  = LmsData::iconPaths();

        $categories = [
            ['slug' => 'semua',        'label' => 'Semua Materi'],
            ['slug' => 'neuroscience', 'label' => 'Neuroscience'],
            ['slug' => 'eeg',          'label' => 'Teknologi EEG'],
            ['slug' => 'analisis',     'label' => 'Analisis Data'],
        ];

        return view('courses.index', compact('courses', 'levelMap', 'iconPaths', 'categories'));
    }

    public function show(string $slug)
    {
        $course = LmsData::findCourse($slug);

        if (! $course) {
            abort(404);
        }

        $levelMap     = LmsData::levelColorMap();
        $iconPaths    = LmsData::iconPaths();
        $flatLessons  = LmsData::flatLessons($course);

        return view('courses.show', compact('course', 'levelMap', 'iconPaths', 'flatLessons'));
    }
}
