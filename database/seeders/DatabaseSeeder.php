<?php

namespace Database\Seeders;

use App\Helpers\LmsData;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Required Role Accounts
        $student = User::updateOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'student',
                'password' => Hash::make('student12345'),
                'role' => 'student',
            ]
        );

        $educator = User::updateOrCreate(
            ['email' => 'educator@gmail.com'],
            [
                'name' => 'educator',
                'password' => Hash::make('educator12345'),
                'role' => 'educator',
            ]
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // 2. Seed Initial Courses & Lessons from LmsData into DB
        $staticCourses = LmsData::courses();

        foreach ($staticCourses as $index => $cData) {
            $course = Course::updateOrCreate(
                ['slug' => $cData['slug']],
                [
                    'user_id'        => $educator->id,
                    'title'          => $cData['title'],
                    'short_desc'     => $cData['short_desc'],
                    'long_desc'      => $cData['long_desc'],
                    'category'       => $cData['category'] ?? 'neuroscience',
                    'level'          => $cData['level'],
                    'level_color'    => $cData['level_color'] ?? 'green',
                    'price'          => 0,
                    'duration'       => $cData['duration'],
                    'icon'           => $cData['icon'],
                    'rating'         => $cData['rating'] ?? 4.8,
                    'reviews_count'  => $cData['reviews'] ?? 50,
                    'instructor'     => $cData['instructor'] ?? 'educator',
                    'instructor_bio' => $cData['instructor_bio'] ?? 'Pengajar Spesialis Neurosains',
                    'what_you_learn' => $cData['what_you_learn'] ?? [],
                    'requirements'   => $cData['requirements'] ?? [],
                    'thumbnail'      => $cData['thumbnail'] ?? null,
                    'is_published'   => true,
                ]
            );

            // Seed Lessons for this course
            if (isset($cData['sections'])) {
                $order = 1;
                foreach ($cData['sections'] as $sec) {
                    foreach ($sec['lessons'] as $les) {
                        Lesson::updateOrCreate(
                            [
                                'course_id' => $course->id,
                                'slug'      => $les['slug'],
                            ],
                            [
                                'title'         => $les['title'],
                                'section_title' => $sec['title'],
                                'type'          => $les['type'] ?? 'video',
                                'duration'      => $les['duration'] ?? '15 menit',
                                'content'       => 'Materi pembelajaran untuk ' . $les['title'] . '. Jelajahi konsep neuroscience terapan dengan pembahasan komprehensif.',
                                'free'          => !empty($les['free']),
                                'sort_order'    => $order++,
                            ]
                        );
                    }
                }
            }
        }

        // 3. Seed Initial Enrollment for Student (Starting at 0% Progress) — all courses are free
        $firstCourse = Course::where('slug', 'dasar-neuroscience')->first();
        if ($firstCourse && $student) {
            Enrollment::updateOrCreate(
                [
                    'user_id'   => $student->id,
                    'course_id' => $firstCourse->id,
                ],
                [
                    'progress'          => 0,
                    'status'            => 'active',
                    'last_lesson_slug'  => 'apa-itu-neuroscience',
                    'completed_lessons' => [],
                ]
            );
        }

        $secondCourse = Course::where('slug', 'pengenalan-eeg')->first();
        if ($secondCourse && $student) {
            Enrollment::updateOrCreate(
                [
                    'user_id'   => $student->id,
                    'course_id' => $secondCourse->id,
                ],
                [
                    'progress'          => 0,
                    'status'            => 'active',
                    'last_lesson_slug'  => 'potensial-listrik-otak',
                    'completed_lessons' => [],
                ]
            );
        }
    }
}
