<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;
use Illuminate\Support\Str;

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

        $levelMap   = LmsData::levelColorMap();
        $iconPaths  = LmsData::iconPaths();
        $flatLessons = LmsData::flatLessons($course);

        $freeLessons = array_values(array_filter($flatLessons, fn (array $lesson) => ! empty($lesson['free'])));
        $previewLessons = array_slice($freeLessons, 0, 3);
        $lessonTypes = [
            'video' => collect($flatLessons)->where('type', 'video')->count(),
            'reading' => collect($flatLessons)->where('type', 'reading')->count(),
            'quiz' => collect($flatLessons)->where('type', 'quiz')->count(),
        ];

        $course['stats'] = [
            'duration_label' => $course['duration'],
            'lesson_count' => count($flatLessons),
            'enrolled_students' => number_format($course['enrolled_students'], 0, ',', '.'),
            'last_updated' => $course['last_updated'],
        ];
        $course['lesson_types'] = $lessonTypes;
        $course['preview_lessons'] = $previewLessons;
        $course['has_free_preview'] = ! empty($freeLessons);
        $course['cta'] = $this->buildCourseCta($course);
        $course['seo_title'] = $course['title'] . ' – SynapEd';
        $course['seo_description'] = Str::limit($course['long_desc'], 155);
        $course['canonical_url'] = route('courses.show', $course['slug']);

        $course['hero_blurb'] = $course['short_desc'];
        $course['instructor_avatar'] = strtoupper(Str::substr($course['instructor_profile']['name'], 0, 2));
        $course['related_courses'] = collect($course['instructor_profile']['other_courses'])
            ->map(fn (array $related) => [
                'title' => $related['title'],
                'slug' => $related['slug'],
                'url' => route('courses.show', $related['slug']),
            ])
            ->all();

        $course['review_placeholder'] = [
            'headline' => 'Ulasan peserta akan segera ditampilkan di sini.',
            'body' => 'Bagian ini disiapkan untuk menampilkan ringkasan rating, komentar, dan testimoni setelah data ulasan tersedia.',
        ];

        $course['course_schema'] = [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $course['title'],
            'description' => $course['seo_description'],
            'provider' => [
                '@type' => 'Organization',
                'name' => 'SynapEd',
                'url' => url('/'),
            ],
            'educationalLevel' => $course['level'],
            'coursePrerequisites' => $course['requirements'] ?? [],
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $course['price'],
                'priceCurrency' => 'IDR',
                'availability' => 'https://schema.org/InStock',
                'url' => $course['canonical_url'],
            ],
            'instructor' => [
                '@type' => 'Person',
                'name' => $course['instructor_profile']['name'],
            ],
            'hasCourseInstance' => [
                '@type' => 'CourseInstance',
                'courseMode' => 'Online',
                'courseSchedule' => $course['cohort']['schedule'],
                'startDate' => $course['cohort']['starts_at'],
            ],
        ];

        return view('courses.show', compact('course', 'levelMap', 'iconPaths', 'flatLessons'));
    }

    private function buildCourseCta(array $course): array
    {
        if (auth()->check() && ! empty($course['is_enrolled'])) {
            return [
                'label' => 'Mulai Belajar',
                'href' => route('learn', $course['slug']),
                'style' => 'primary',
            ];
        }

        if (! auth()->check() && ! empty($course['has_free_preview'])) {
            return [
                'label' => 'Preview Gratis',
                'href' => route('courses.show', $course['slug']),
                'style' => 'secondary',
            ];
        }

        return [
            'label' => 'Daftar Sekarang — ' . $course['price_label'],
            'href' => auth()->check() ? route('learn', $course['slug']) : route('login'),
            'style' => 'primary',
        ];
    }
}
