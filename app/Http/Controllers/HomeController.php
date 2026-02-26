<?php

namespace App\Http\Controllers;

use App\Helpers\LmsData;

class HomeController extends Controller
{
    public function index()
    {
        $allCourses = LmsData::courses();

        // Landing page uses first 4 courses (all of them)
        $courses = $allCourses;

        $courseCategories = [
            ['slug' => 'semua',        'label' => 'Semua Materi'],
            ['slug' => 'neuroscience', 'label' => 'Neuroscience'],
            ['slug' => 'eeg',          'label' => 'Teknologi EEG'],
            ['slug' => 'analisis',     'label' => 'Analisis Data'],
        ];

        $stats = [
            ['value' => '500+',  'label' => 'Pelajar Terdaftar',    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['value' => '4',     'label' => 'Modul Terstruktur',    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['value' => '29+',   'label' => 'Jam Konten Video',     'icon' => 'M15 10l4.553-2.069A1 1 0 0121 8.873v6.254a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
            ['value' => '4.8★', 'label' => 'Rating Rata-rata',     'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
        ];

        $partners = [
            ['name' => 'Universitas Indonesia',           'abbr' => 'UI'],
            ['name' => 'Institut Teknologi Bandung',      'abbr' => 'ITB'],
            ['name' => 'Universitas Gadjah Mada',         'abbr' => 'UGM'],
            ['name' => 'BRIN',                            'abbr' => 'BRIN'],
            ['name' => 'Institut Teknologi Sepuluh Nov.', 'abbr' => 'ITS'],
            ['name' => 'Universitas Brawijaya',           'abbr' => 'UB'],
            ['name' => 'Universitas Diponegoro',          'abbr' => 'UNDIP'],
            ['name' => 'Universitas Airlangga',           'abbr' => 'UNAIR'],
        ];

        $testimonials = [
            [
                'name'     => 'Pelajar Mandiri',
                'position' => 'Mahasiswa Teknik Biomedik',
                'content'  => 'Materi neuroscience di sini disajikan dengan sangat sistematis. Saya yang dari teknik pun bisa memahami cara kerja otak dan sinyal EEG dari nol.',
                'rating'   => 5,
                'initials' => 'PM',
                'color'    => '#2563EB',
            ],
            [
                'name'     => 'Pengguna Aktif',
                'position' => 'Tenaga Pendidik',
                'content'  => 'Kontennya informatif dan terstruktur. Sangat membantu saya dalam mempersiapkan materi pembelajaran neurosains untuk siswa SMA.',
                'rating'   => 5,
                'initials' => 'PA',
                'color'    => '#7C3AED',
            ],
            [
                'name'     => 'Alumni Kursus',
                'position' => 'Peneliti & Praktisi',
                'content'  => 'Modul analisis data EEG sangat praktis. Panduan Python-nya langsung bisa diterapkan pada dataset riset saya. Sangat direkomendasikan.',
                'rating'   => 5,
                'initials' => 'AK',
                'color'    => '#0891B2',
            ],
        ];

        $faqs = [
            [
                'question' => 'Siapa saja yang dapat menggunakan platform NeuroAcademy?',
                'answer'   => 'NeuroAcademy terbuka untuk semua kalangan — pelajar SMA, SMK, mahasiswa, hingga profesional yang ingin memahami neuroscience dan teknologi EEG. Tidak diperlukan latar belakang medis atau teknik.',
            ],
            [
                'question' => 'Apakah saya perlu latar belakang medis atau teknik untuk memulai?',
                'answer'   => 'Tidak sama sekali. Kurikulum NeuroAcademy dirancang mulai dari level pemula yang tidak mengasumsikan pengetahuan medis atau teknik sebelumnya. Semua orang bisa belajar.',
            ],
            [
                'question' => 'Apakah saya perlu memiliki perangkat EEG untuk mengikuti kursus?',
                'answer'   => 'Untuk modul dasar dan teori, tidak diperlukan perangkat EEG. Namun untuk modul implementasi, disarankan memiliki akses ke headband Muse atau perangkat EEG lainnya. Kami juga menyediakan dataset simulasi.',
            ],
            [
                'question' => 'Berapa lama waktu yang dibutuhkan untuk menyelesaikan semua materi?',
                'answer'   => 'Rata-rata 4–6 minggu jika belajar 1–2 jam per hari. Namun karena bersifat self-paced, Anda bisa mengatur waktu sesuai kenyamanan Anda sendiri.',
            ],
            [
                'question' => 'Apakah ada sertifikat setelah menyelesaikan kursus?',
                'answer'   => 'Ya, peserta yang menyelesaikan seluruh modul dan lulus evaluasi akan mendapatkan sertifikat digital dari NeuroAcademy yang dapat dibagikan di LinkedIn atau portofolio Anda.',
            ],
        ];

        return view('landing', compact(
            'courses', 'courseCategories', 'stats', 'partners', 'testimonials', 'faqs'
        ));
    }
}