<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)->get();
        $levelMap = LmsData::levelColorMap();
        $iconPaths = LmsData::iconPaths();

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
        $courseModel = Course::where('slug', $slug)->with('lessons')->first();

        if (! $courseModel) {
            abort(404);
        }

        $levelMap = LmsData::levelColorMap();
        $iconPaths = LmsData::iconPaths();

        $course = $courseModel->toArray();
        $course['price_label'] = $courseModel->price_label;
        $course['enrolled_students'] = $courseModel->enrollments()->count() ?: 1800;
        $course['last_updated'] = $courseModel->updated_at->translatedFormat('d F Y');
        $course['instructor_profile'] = [
            'name' => $courseModel->instructor ?: ($courseModel->author->name ?? 'Tim Pengajar'),
            'role' => 'Pengajar & Spesialis Neurosains',
            'bio' => $courseModel->instructor_bio ?: 'Pengajar Spesialis Neurosains',
            'credentials' => [
                'Pakar Neurosains Kognitif & Teknologi LMS',
                'Berpengalaman mengajar 10+ modul interaktif',
                'Membimbing ribuan siswa di platform SynapEd',
            ],
            'other_courses' => Course::where('id', '!=', $courseModel->id)->limit(2)->get(['title', 'slug'])->toArray(),
        ];
        $course['thumbnail'] = $courseModel->thumbnail;

        // Lessons
        $lessons = $courseModel->lessons;
        $groupedSections = [];

        if ($lessons->count() > 0) {
            $sectionsMap = [];
            foreach ($lessons as $les) {
                $secName = $les->section_title ?: 'Modul Utama';
                if (! isset($sectionsMap[$secName])) {
                    $sectionsMap[$secName] = [];
                }
                $sectionsMap[$secName][] = [
                    'id' => $les->id,
                    'slug' => $les->slug,
                    'title' => $les->title,
                    'type' => $les->type,
                    'duration' => $les->duration,
                    'free' => (bool)$les->free,
                    'section_title' => $secName,
                ];
            }
            $sId = 1;
            foreach ($sectionsMap as $secTitle => $secLessons) {
                $decLessons = [];
                foreach ($secLessons as $les) {
                    $les['type_label'] = ucfirst($les['type']);
                    $les['type_icon'] = $les['type'];
                    $les['completed'] = false;
                    $les['locked'] = ! $les['free'];
                    $les['is_preview'] = (bool) $les['free'];
                    $decLessons[] = $les;
                }
                $groupedSections[] = [
                    'id' => $sId++,
                    'title' => $secTitle,
                    'lessons' => $decLessons,
                    'lesson_count' => count($decLessons),
                    'section_duration_label' => count($decLessons) . ' Pelajaran',
                ];
            }
        } else {
            $groupedSections[] = [
                'id' => 1,
                'title' => 'Pengantar Kursus',
                'lessons' => [
                    [
                        'id' => 1,
                        'slug' => 'pengantar',
                        'title' => 'Pengantar ' . $courseModel->title,
                        'type' => 'video',
                        'duration' => '10 menit',
                        'free' => true,
                        'type_label' => 'Video',
                        'type_icon' => 'video',
                        'completed' => false,
                        'locked' => false,
                        'is_preview' => true,
                    ],
                ],
                'lesson_count' => 1,
                'section_duration_label' => '1 Pelajaran · 10 menit',
            ];
        }

        $course['sections'] = $groupedSections;
        $flatLessons = LmsData::flatLessons($course);
        $freeLessons = array_values(array_filter($flatLessons, fn (array $lesson) => ! empty($lesson['free'])));
        $previewLessons = array_slice($freeLessons, 0, 3);
        $lessonTypes = [
            'video' => collect($flatLessons)->where('type', 'video')->count(),
            'reading' => collect($flatLessons)->where('type', 'reading')->count(),
            'quiz' => collect($flatLessons)->where('type', 'quiz')->count(),
        ];

        $course['stats'] = [
            'duration_label' => $courseModel->duration,
            'lesson_count' => count($flatLessons),
            'enrolled_students' => number_format($course['enrolled_students'], 0, ',', '.'),
            'last_updated' => $course['last_updated'],
        ];
        $course['lesson_types'] = $lessonTypes;
        $course['preview_lessons'] = $previewLessons;
        $course['has_free_preview'] = ! empty($freeLessons);
        $course['cta'] = $this->buildCourseCta($courseModel);
        $course['seo_title'] = $courseModel->title . ' – SynapEd';
        $course['seo_description'] = Str::limit($courseModel->short_desc ?: $courseModel->title, 155);
        $course['canonical_url'] = route('courses.show', $courseModel->slug);
        $course['gradient'] = 'linear-gradient(135deg, #2563EB, #1D4ED8)';
        $course['gradient_from'] = '#2563EB';
        $course['gradient_to'] = '#1D4ED8';
        $course['review_placeholder'] = [
            'headline' => '4.8 dari 5 Bintang.',
            'body' => 'Berdasarkan ulasan dari para peserta yang telah menyelesaikan materi kursus ini.',
        ];
        $course['included_items'] = [
            ['label' => ($course['stats']['duration_label'] ?? '6 Jam') . ' Akses Materi', 'detail' => 'Akses selamanya ke seluruh materi video & bacaan'],
            ['label' => ($course['stats']['lesson_count'] ?? 10) . ' Pelajaran Terstruktur', 'detail' => 'Kurikulum dari tingkat dasar hingga lanjutan'],
            ['label' => 'Sertifikat Penyelesaian', 'detail' => 'Diberikan secara otomatis setelah menyelesaikan kuis & materi'],
        ];
        $course['hero_blurb'] = $courseModel->short_desc;
        $course['instructor_avatar'] = strtoupper(Str::substr($course['instructor_profile']['name'], 0, 2));
        $course['related_courses'] = collect($course['instructor_profile']['other_courses'])
            ->map(fn (array $related) => [
                'title' => $related['title'],
                'slug' => $related['slug'],
                'url' => route('courses.show', $related['slug']),
            ])
            ->all();

        return view('courses.show', compact('course', 'levelMap', 'iconPaths', 'flatLessons'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses khusus Educator atau Admin');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:courses,slug',
            'category' => 'required|string',
            'level' => 'required|string',
            'level_color' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'icon' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'short_desc' => 'required|string',
            'long_desc' => 'nullable|string',
            'instructor' => 'nullable|string',
            'instructor_bio' => 'nullable|string',
            'what_you_learn' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        // Handle file upload thumbnail if provided
        $thumbnailPath = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('thumbnails', 'public');
            $thumbnailPath = '/storage/' . $path;
        }

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);

        if (Course::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $learnArray = ! empty($validated['what_you_learn']) ? array_filter(array_map('trim', explode("\n", $validated['what_you_learn']))) : [];
        $reqArray = ! empty($validated['requirements']) ? array_filter(array_map('trim', explode("\n", $validated['requirements']))) : [];

        $course = Course::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'level' => $validated['level'],
            'level_color' => $validated['level_color'] ?? 'green',
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'icon' => $validated['icon'] ?? 'brain',
            'thumbnail' => $thumbnailPath,
            'short_desc' => $validated['short_desc'],
            'long_desc' => $validated['long_desc'] ?? $validated['short_desc'],
            'instructor' => $validated['instructor'] ?? $user->name,
            'instructor_bio' => $validated['instructor_bio'] ?? 'Pengajar Spesialis Neurosains & Teknologi',
            'what_you_learn' => $learnArray,
            'requirements' => $reqArray,
            'is_published' => true,
        ]);

        // Initial default lesson
        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Pengantar: ' . $course->title,
            'slug' => 'pengantar-' . $course->slug,
            'section_title' => 'Modul 1: Pendahuluan',
            'type' => 'video',
            'duration' => '15 menit',
            'content' => 'Selamat datang di kursus ' . $course->title . '. Pada modul ini Anda akan mempelajari dasar-dasar topik.',
            'free' => true,
            'sort_order' => 1,
        ]);

        return redirect()->back()->with('success', 'Kursus "' . $course->title . '" dan thumbnail berhasil disimpan!');
    }

    public function update(Request $request, Course $course)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'level' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'icon' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'short_desc' => 'required|string',
            'long_desc' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('thumbnails', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $course->update($validated);

        return redirect()->back()->with('success', 'Kursus dan thumbnail "' . $course->title . '" berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        $user = auth()->user();
        if (! $user->isEducator() && ! $user->isAdmin()) {
            abort(403, 'Akses terbatas');
        }

        $title = $course->title;
        $course->delete();

        return redirect()->back()->with('success', 'Kursus "' . $title . '" berhasil dihapus!');
    }

    private function buildCourseCta(Course $courseModel): array
    {
        if (auth()->check()) {
            $isEnrolled = $courseModel->enrollments()->where('user_id', auth()->id())->exists();
            if ($isEnrolled) {
                return [
                    'label' => 'Mulai Belajar',
                    'href' => route('learn', $courseModel->slug),
                    'style' => 'primary',
                ];
            }
        }

        return [
            'label' => 'Daftar Sekarang — ' . $courseModel->price_label,
            'href' => auth()->check() ? '#' : route('login'),
            'style' => 'primary',
            'is_buy' => auth()->check(),
            'course_id' => $courseModel->id,
        ];
    }
}
