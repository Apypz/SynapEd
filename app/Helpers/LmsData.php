<?php

namespace App\Helpers;

class LmsData
{
    // ──────────────────────────────────────────────────────────────────
    //  COURSES
    // ──────────────────────────────────────────────────────────────────

    public static function courses(): array
    {
        return [
            [
                'id'               => 1,
                'slug'             => 'dasar-neuroscience',
                'title'            => 'Dasar Neuroscience',
                'short_desc'       => 'Pelajari struktur neuron, sinapsis, dan cara otak memproses informasi dari level seluler hingga sistem.',
                'long_desc'        => 'Modul ini merupakan fondasi dari seluruh kurikulum NeuroAcademy. Anda akan memulai dari konsep paling dasar tentang sistem saraf, memahami bagaimana neuron berkomunikasi melalui sinapsis, hingga mempelajari arsitektur otak manusia secara menyeluruh. Tidak diperlukan latar belakang medis; semua materi dirancang agar dapat dipahami oleh siapa saja.',
                'level'            => 'Pemula',
                'level_color'      => 'green',
                'category'         => 'neuroscience',
                'icon'             => 'brain',
                'lessons_count'    => 12,
                'duration'         => '6 Jam',
                'rating'           => 4.8,
                'reviews'          => 124,
                'gradient'         => 'linear-gradient(135deg, #2563EB, #1D4ED8)',
                'gradient_from'    => '#2563EB',
                'gradient_to'      => '#1D4ED8',
                'badge_color'      => '#3B82F6',
                'instructor'       => 'Tim Pengajar NeuroAcademy',
                'instructor_bio'   => 'Spesialis Neurosains Kognitif dan Neuroplastisitas.',
                'what_you_learn'   => [
                    'Memahami struktur neuron dan fungsinya',
                    'Mengenal berbagai jenis sinapsis dan neurotransmitter',
                    'Mempelajari anatomi otak manusia secara sistematis',
                    'Memahami bagaimana sinyal listrik mengalir di neuron',
                    'Mengenal lobus-lobus otak dan fungsinya',
                    'Fondasi untuk mempelajari teknologi EEG',
                ],
                'requirements'     => [
                    'Tidak diperlukan pengetahuan medis sebelumnya',
                    'Kemampuan membaca teks akademik dasar',
                    'Rasa ingin tahu yang tinggi',
                ],
                'sections'         => [
                    [
                        'id'    => 1,
                        'title' => 'Pengantar Neuroscience',
                        'lessons' => [
                            ['id' => 1, 'slug' => 'apa-itu-neuroscience',           'title' => 'Apa itu Neuroscience?',                    'type' => 'video',   'duration' => '18 menit', 'free' => true],
                            ['id' => 2, 'slug' => 'sejarah-neuroscience',            'title' => 'Sejarah Singkat Neuroscience',              'type' => 'video',   'duration' => '14 menit', 'free' => true],
                            ['id' => 3, 'slug' => 'neuroscience-kehidupan',          'title' => 'Neuroscience dalam Kehidupan Sehari-hari',  'type' => 'reading', 'duration' => '10 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 2,
                        'title' => 'Anatomi Neuron',
                        'lessons' => [
                            ['id' => 4, 'slug' => 'struktur-neuron',                'title' => 'Struktur Dasar Neuron',                    'type' => 'video',   'duration' => '22 menit', 'free' => false],
                            ['id' => 5, 'slug' => 'sinapsis-transmisi-sinyal',      'title' => 'Sinapsis dan Transmisi Sinyal',             'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 6, 'slug' => 'neurotransmitter',               'title' => 'Jenis-jenis Neurotransmitter',              'type' => 'reading', 'duration' => '12 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 3,
                        'title' => 'Otak Manusia',
                        'lessons' => [
                            ['id' => 7, 'slug' => 'struktur-otak',                  'title' => 'Struktur Makroskopik Otak',                 'type' => 'video',   'duration' => '25 menit', 'free' => false],
                            ['id' => 8, 'slug' => 'lobus-otak',                     'title' => 'Lobus-lobus Otak',                         'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 9, 'slug' => 'korteks-serebral',               'title' => 'Fungsi Korteks Serebral',                   'type' => 'reading', 'duration' => '15 menit', 'free' => false],
                            ['id' => 10, 'slug' => 'sistem-limbik',                 'title' => 'Sistem Limbik & Emosi',                    'type' => 'video',   'duration' => '18 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 4,
                        'title' => 'Evaluasi Modul',
                        'lessons' => [
                            ['id' => 11, 'slug' => 'kuis-neuroscience-dasar',       'title' => 'Kuis: Neuroscience Dasar',                  'type' => 'quiz',    'duration' => '20 menit', 'free' => false],
                            ['id' => 12, 'slug' => 'tugas-akhir-modul-1',           'title' => 'Tugas Akhir Modul 1',                      'type' => 'reading', 'duration' => '30 menit', 'free' => false],
                        ],
                    ],
                ],
            ],

            // ── COURSE 2 ────────────────────────────────────────────────────
            [
                'id'               => 2,
                'slug'             => 'pengenalan-eeg',
                'title'            => 'Pengenalan EEG',
                'short_desc'       => 'Memahami prinsip dasar Electroencephalography, jenis gelombang otak, dan setup perangkat EEG.',
                'long_desc'        => 'Modul ini memperkenalkan Anda pada dunia Electroencephalography (EEG) dari sudut pandang yang mudah dipahami. Anda akan belajar tentang bagaimana otak menghasilkan sinyal listrik, apa saja jenis gelombang otak yang diukur EEG, serta bagaimana perangkat EEG modern bekerja. Modul ini menjadi jembatan antara neuroscience dasar dan implementasi teknologi EEG.',
                'level'            => 'Pemula',
                'level_color'      => 'green',
                'category'         => 'eeg',
                'icon'             => 'wave',
                'lessons_count'    => 10,
                'duration'         => '5 Jam',
                'rating'           => 4.7,
                'reviews'          => 98,
                'gradient'         => 'linear-gradient(135deg, #7C3AED, #6D28D9)',
                'gradient_from'    => '#7C3AED',
                'gradient_to'      => '#6D28D9',
                'badge_color'      => '#8B5CF6',
                'instructor'       => 'Tim Pengajar NeuroAcademy',
                'instructor_bio'   => 'Spesialis Teknik Biomedik dan Biosignal Processing.',
                'what_you_learn'   => [
                    'Memahami bagaimana otak menghasilkan sinyal listrik',
                    'Mengenal 5 jenis gelombang otak (Delta, Theta, Alpha, Beta, Gamma)',
                    'Memahami cara kerja perangkat EEG',
                    'Mengenal sistem penempatan elektroda 10-20',
                    'Membedakan EEG klinis dan EEG consumer',
                    'Persiapan untuk penggunaan perangkat EEG praktis',
                ],
                'requirements'     => [
                    'Direkomendasikan: sudah menyelesaikan Modul Dasar Neuroscience',
                    'Tidak diperlukan pengetahuan teknik elektronika',
                ],
                'sections'         => [
                    [
                        'id'    => 1,
                        'title' => 'Dasar Elektrofisiologi',
                        'lessons' => [
                            ['id' => 1, 'slug' => 'potensial-listrik-otak',         'title' => 'Potensial Listrik pada Neuron',             'type' => 'video',   'duration' => '20 menit', 'free' => true],
                            ['id' => 2, 'slug' => 'gelombang-otak',                 'title' => 'Jenis Gelombang Otak',                     'type' => 'video',   'duration' => '25 menit', 'free' => true],
                            ['id' => 3, 'slug' => 'cara-kerja-eeg',                 'title' => 'Bagaimana EEG Mengukur Aktivitas Otak',    'type' => 'video',   'duration' => '18 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 2,
                        'title' => 'Perangkat EEG',
                        'lessons' => [
                            ['id' => 4, 'slug' => 'jenis-elektroda',                'title' => 'Jenis-jenis Elektroda EEG',                'type' => 'reading', 'duration' => '12 menit', 'free' => false],
                            ['id' => 5, 'slug' => 'sistem-10-20',                   'title' => 'Sistem Penempatan Elektroda 10-20',        'type' => 'video',   'duration' => '22 menit', 'free' => false],
                            ['id' => 6, 'slug' => 'consumer-vs-clinical-eeg',       'title' => 'Consumer EEG vs Clinical EEG',             'type' => 'reading', 'duration' => '10 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 3,
                        'title' => 'Pembacaan Sinyal EEG',
                        'lessons' => [
                            ['id' => 7, 'slug' => 'membaca-sinyal-eeg',             'title' => 'Cara Membaca Sinyal EEG',                  'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 8, 'slug' => 'artefak-eeg',                    'title' => 'Mengenali Artefak pada Sinyal EEG',        'type' => 'video',   'duration' => '15 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 4,
                        'title' => 'Evaluasi Modul',
                        'lessons' => [
                            ['id' => 9, 'slug' => 'kuis-eeg-dasar',                 'title' => 'Kuis: Pengenalan EEG',                     'type' => 'quiz',    'duration' => '15 menit', 'free' => false],
                            ['id' => 10, 'slug' => 'tugas-akhir-modul-2',           'title' => 'Tugas Akhir Modul 2',                     'type' => 'reading', 'duration' => '25 menit', 'free' => false],
                        ],
                    ],
                ],
            ],

            // ── COURSE 3 ────────────────────────────────────────────────────
            [
                'id'               => 3,
                'slug'             => 'implementasi-eeg-muse',
                'title'            => 'Implementasi EEG dengan Muse',
                'short_desc'       => 'Panduan praktis menggunakan headband Muse untuk merekam dan memvisualisasikan data EEG secara real-time.',
                'long_desc'        => 'Modul ini adalah modul paling praktis di kurikulum NeuroAcademy. Anda akan belajar cara menggunakan perangkat EEG consumer headband Muse, mulai dari setup perangkat, koneksi via Bluetooth, perekaman data real-time, hingga visualisasi sinyal otak langsung di layar komputer. Modul ini sangat direkomendasikan bagi yang memiliki akses ke perangkat Muse.',
                'level'            => 'Menengah',
                'level_color'      => 'yellow',
                'category'         => 'eeg',
                'icon'             => 'headset',
                'lessons_count'    => 14,
                'duration'         => '8 Jam',
                'rating'           => 4.9,
                'reviews'          => 76,
                'gradient'         => 'linear-gradient(135deg, #0891B2, #0E7490)',
                'gradient_from'    => '#0891B2',
                'gradient_to'      => '#0E7490',
                'badge_color'      => '#06B6D4',
                'instructor'       => 'Tim Pengajar NeuroAcademy',
                'instructor_bio'   => 'R&D Engineer spesialis Brain-Computer Interface berbasis EEG.',
                'what_you_learn'   => [
                    'Setup perangkat Muse headband dari awal',
                    'Koneksi perangkat via Bluetooth ke komputer',
                    'Merekam data EEG secara real-time',
                    'Memvisualisasikan gelombang otak live',
                    'Menggunakan Mind Monitor dan aplikasi pendamping',
                    'Ekspor data untuk analisis lebih lanjut',
                ],
                'requirements'     => [
                    'Wajib: sudah menyelesaikan Modul Pengenalan EEG',
                    'Direkomendasikan: memiliki perangkat Muse headband',
                    'Laptop dengan Bluetooth dan OS Windows/Mac/Linux',
                ],
                'sections'         => [
                    [
                        'id'    => 1,
                        'title' => 'Persiapan Perangkat',
                        'lessons' => [
                            ['id' => 1, 'slug' => 'pengenalan-muse',                'title' => 'Mengenal Perangkat Muse Headband',         'type' => 'video',   'duration' => '15 menit', 'free' => true],
                            ['id' => 2, 'slug' => 'setup-muse',                     'title' => 'Setup Awal Perangkat Muse',                'type' => 'video',   'duration' => '20 menit', 'free' => true],
                            ['id' => 3, 'slug' => 'koneksi-bluetooth',              'title' => 'Koneksi Bluetooth dan Pairing',            'type' => 'video',   'duration' => '12 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 2,
                        'title' => 'Perekaman Data Real-time',
                        'lessons' => [
                            ['id' => 4, 'slug' => 'rekam-data-eeg',                 'title' => 'Merekam Sesi EEG Pertama Anda',            'type' => 'video',   'duration' => '25 menit', 'free' => false],
                            ['id' => 5, 'slug' => 'visualisasi-sinyal',             'title' => 'Visualisasi Sinyal Otak Real-time',        'type' => 'video',   'duration' => '22 menit', 'free' => false],
                            ['id' => 6, 'slug' => 'kualitas-sinyal',                'title' => 'Memastikan Kualitas Sinyal Optimal',       'type' => 'video',   'duration' => '18 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 3,
                        'title' => 'Aplikasi dan Tools',
                        'lessons' => [
                            ['id' => 7, 'slug' => 'mind-monitor',                   'title' => 'Menggunakan Mind Monitor',                 'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 8, 'slug' => 'muse-direct',                    'title' => 'Muse Direct & OSC Protocol',               'type' => 'video',   'duration' => '25 menit', 'free' => false],
                            ['id' => 9, 'slug' => 'ekspor-data',                    'title' => 'Ekspor Data CSV untuk Analisis',           'type' => 'reading', 'duration' => '10 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 4,
                        'title' => 'Eksperimen Neurofeedback',
                        'lessons' => [
                            ['id' => 10, 'slug' => 'eksperimen-relaksasi',          'title' => 'Eksperimen: Meditasi & Alpha Wave',        'type' => 'video',   'duration' => '22 menit', 'free' => false],
                            ['id' => 11, 'slug' => 'eksperimen-fokus',              'title' => 'Eksperimen: Fokus & Beta Wave',            'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 12, 'slug' => 'neurofeedback-dasar',           'title' => 'Konsep Dasar Neurofeedback',               'type' => 'reading', 'duration' => '15 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 5,
                        'title' => 'Evaluasi Modul',
                        'lessons' => [
                            ['id' => 13, 'slug' => 'kuis-implementasi-eeg',         'title' => 'Kuis: Implementasi EEG',                   'type' => 'quiz',    'duration' => '15 menit', 'free' => false],
                            ['id' => 14, 'slug' => 'laporan-eksperimen',            'title' => 'Laporan Eksperimen Akhir',                 'type' => 'reading', 'duration' => '45 menit', 'free' => false],
                        ],
                    ],
                ],
            ],

            // ── COURSE 4 ────────────────────────────────────────────────────
            [
                'id'               => 4,
                'slug'             => 'analisis-data-eeg',
                'title'            => 'Analisis Data EEG',
                'short_desc'       => 'Teknik pemrosesan sinyal, filtering, artifact removal, dan interpretasi data EEG menggunakan Python.',
                'long_desc'        => 'Modul tingkat lanjut ini mengajarkan Anda cara mengolah dan menganalisis data EEG menggunakan Python dengan library MNE-Python. Anda akan mempelajari teknik pemrosesan sinyal digital, cara menghilangkan artefak, mengekstrak fitur dari gelombang otak, dan menginterpretasikan hasil analisis untuk keperluan riset maupun aplikasi BCI.',
                'level'            => 'Lanjut',
                'level_color'      => 'red',
                'category'         => 'analisis',
                'icon'             => 'chart',
                'lessons_count'    => 16,
                'duration'         => '10 Jam',
                'rating'           => 4.9,
                'reviews'          => 54,
                'gradient'         => 'linear-gradient(135deg, #BE185D, #9D174D)',
                'gradient_from'    => '#BE185D',
                'gradient_to'      => '#9D174D',
                'badge_color'      => '#EC4899',
                'instructor'       => 'Tim Pengajar NeuroAcademy',
                'instructor_bio'   => 'Spesialis Computational Neuroscience dan Machine Learning untuk biosignal.',
                'what_you_learn'   => [
                    'Setup environment Python untuk analisis EEG (MNE, NumPy, SciPy)',
                    'Import dan visualisasi data EEG mentah',
                    'Teknik filtering sinyal (bandpass, notch filter)',
                    'Artifact removal: ocular dan muscular artifact',
                    'Ekstraksi fitur spektral (Power Spectral Density)',
                    'Analisis Event-Related Potential (ERP)',
                ],
                'requirements'     => [
                    'Wajib: sudah menyelesaikan Modul Pengenalan EEG',
                    'Pengetahuan dasar Python (variabel, loop, fungsi)',
                    'Anaconda atau lingkungan Python 3.8+ terinstal',
                ],
                'sections'         => [
                    [
                        'id'    => 1,
                        'title' => 'Setup Lingkungan Analisis',
                        'lessons' => [
                            ['id' => 1, 'slug' => 'instalasi-mne-python',           'title' => 'Instalasi MNE-Python & Dependencies',      'type' => 'video',   'duration' => '15 menit', 'free' => true],
                            ['id' => 2, 'slug' => 'import-data-eeg',                'title' => 'Import Data EEG ke MNE',                   'type' => 'video',   'duration' => '20 menit', 'free' => true],
                            ['id' => 3, 'slug' => 'visualisasi-raw',                'title' => 'Visualisasi Data EEG Mentah',              'type' => 'video',   'duration' => '18 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 2,
                        'title' => 'Preprocessing Sinyal',
                        'lessons' => [
                            ['id' => 4, 'slug' => 'filtering-sinyal',               'title' => 'Filtering: Bandpass & Notch Filter',        'type' => 'video',   'duration' => '25 menit', 'free' => false],
                            ['id' => 5, 'slug' => 'referencing',                    'title' => 'Re-referencing Elektroda',                 'type' => 'video',   'duration' => '15 menit', 'free' => false],
                            ['id' => 6, 'slug' => 'segmentasi-epoch',               'title' => 'Segmentasi Epoch',                         'type' => 'video',   'duration' => '20 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 3,
                        'title' => 'Artifact Removal',
                        'lessons' => [
                            ['id' => 7, 'slug' => 'deteksi-artefak',                'title' => 'Deteksi Artefak Manual',                   'type' => 'video',   'duration' => '22 menit', 'free' => false],
                            ['id' => 8, 'slug' => 'ica-artifact',                   'title' => 'ICA untuk Artifact Removal',               'type' => 'video',   'duration' => '30 menit', 'free' => false],
                            ['id' => 9, 'slug' => 'validasi-bersih',                'title' => 'Validasi Data Pasca-Cleaning',             'type' => 'reading', 'duration' => '12 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 4,
                        'title' => 'Analisis Spektral',
                        'lessons' => [
                            ['id' => 10, 'slug' => 'power-spectral-density',        'title' => 'Power Spectral Density (PSD)',              'type' => 'video',   'duration' => '25 menit', 'free' => false],
                            ['id' => 11, 'slug' => 'band-power',                    'title' => 'Ekstraksi Band Power per Kanal',           'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 12, 'slug' => 'topographic-map',               'title' => 'Visualisasi Topographic Map',              'type' => 'video',   'duration' => '22 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 5,
                        'title' => 'Event-Related Potential',
                        'lessons' => [
                            ['id' => 13, 'slug' => 'konsep-erp',                    'title' => 'Konsep Event-Related Potential',           'type' => 'video',   'duration' => '20 menit', 'free' => false],
                            ['id' => 14, 'slug' => 'analisis-p300',                 'title' => 'Analisis Komponen P300',                   'type' => 'video',   'duration' => '25 menit', 'free' => false],
                        ],
                    ],
                    [
                        'id'    => 6,
                        'title' => 'Evaluasi Modul',
                        'lessons' => [
                            ['id' => 15, 'slug' => 'kuis-analisis-eeg',             'title' => 'Kuis: Analisis Data EEG',                  'type' => 'quiz',    'duration' => '20 menit', 'free' => false],
                            ['id' => 16, 'slug' => 'proyek-akhir-analisis',         'title' => 'Proyek Akhir: Pipeline Analisis EEG',      'type' => 'reading', 'duration' => '60 menit', 'free' => false],
                        ],
                    ],
                ],
            ],
        ];
    }

    // ──────────────────────────────────────────────────────────────────
    //  HELPERS
    // ──────────────────────────────────────────────────────────────────

    public static function findCourse(string $slug): ?array
    {
        foreach (self::courses() as $course) {
            if ($course['slug'] === $slug) {
                return $course;
            }
        }
        return null;
    }

    public static function findLesson(array $course, string $lessonSlug): ?array
    {
        foreach ($course['sections'] as $section) {
            foreach ($section['lessons'] as $lesson) {
                if ($lesson['slug'] === $lessonSlug) {
                    return array_merge($lesson, ['section_title' => $section['title']]);
                }
            }
        }
        return null;
    }

    /** Returns a flat ordered list of all lessons in a course. */
    public static function flatLessons(array $course): array
    {
        $flat = [];
        foreach ($course['sections'] as $section) {
            foreach ($section['lessons'] as $lesson) {
                $flat[] = array_merge($lesson, ['section_title' => $section['title']]);
            }
        }
        return $flat;
    }

    public static function levelColorMap(): array
    {
        return [
            'green'  => ['bg' => 'rgba(16,185,129,0.15)',  'text' => '#10B981', 'border' => 'rgba(16,185,129,0.30)'],
            'yellow' => ['bg' => 'rgba(245,158,11,0.15)',  'text' => '#F59E0B', 'border' => 'rgba(245,158,11,0.30)'],
            'red'    => ['bg' => 'rgba(239,68,68,0.15)',   'text' => '#EF4444', 'border' => 'rgba(239,68,68,0.30)'],
        ];
    }

    public static function iconPaths(): array
    {
        return [
            'brain'   => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
            'wave'    => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
            'headset' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'chart'   => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'video'   => 'M15 10l4.553-2.069A1 1 0 0121 8.873v6.254a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
            'reading' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'quiz'    => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ];
    }
}
