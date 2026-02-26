<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $courses    = LmsData::courses();
        $levelMap   = LmsData::levelColorMap();
        $iconPaths  = LmsData::iconPaths();
        $user       = Auth::user();

        // Simulate enrolled courses (first 2) and progress (static)
        $enrolled = [
            ['course' => $courses[0], 'progress' => 65, 'last_lesson' => 'struktur-otak'],
            ['course' => $courses[1], 'progress' => 30, 'last_lesson' => 'cara-kerja-eeg'],
        ];

        $stats = [
            ['label' => 'Kursus Diikuti',    'value' => '2',   'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['label' => 'Pelajaran Selesai', 'value' => '11',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Jam Belajar',       'value' => '5.5', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Streak Hari',       'value' => '4',   'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
        ];

        return view('dashboard', compact('courses', 'levelMap', 'iconPaths', 'user', 'enrolled', 'stats'));
    }
}
