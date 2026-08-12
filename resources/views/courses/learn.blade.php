<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $lesson['title'] }} – {{ $course['title'] }} | SynapEd LMS</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧠</text></svg>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,body { height:100%; margin:0; }
        .learn-wrap { display:flex; flex-direction:column; height:100vh; background:#0B132B; color:#E0E1DD; font-family:'Poppins', sans-serif; }

        .learn-topbar {
            flex-shrink:0;
            height:60px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 20px;
            border-bottom:1px solid rgba(255, 255, 255, 0.1);
            background:rgba(11, 19, 43, 0.95);
            backdrop-filter:blur(12px);
            z-index: 30;
        }

        .learn-body { display:flex; flex:1; overflow:hidden; }

        .learn-sidebar {
            width:320px;
            flex-shrink:0;
            overflow-y:auto;
            border-right:1px solid rgba(255,255,255,0.08);
            background:#1C2541;
            display:flex;
            flex-direction:column;
        }
        .learn-sidebar::-webkit-scrollbar { width:4px; }
        .learn-sidebar::-webkit-scrollbar-thumb { background:rgba(72, 202, 228, 0.3); border-radius:2px; }

        .learn-section-hdr {
            display:flex;
            align-items:center;
            gap:10px;
            padding:14px 16px;
            cursor:pointer;
            border-bottom:1px solid rgba(255,255,255,0.06);
            background:rgba(255,255,255,0.02);
            user-select:none;
        }
        .learn-section-hdr:hover { background:rgba(72,202,228,0.1); }

        .learn-lesson-item {
            display:flex;
            align-items:center;
            gap:10px;
            padding:12px 16px 12px 20px;
            cursor:pointer;
            border-bottom:1px solid rgba(255,255,255,0.04);
            transition:all 0.15s;
            text-decoration:none;
        }
        .learn-lesson-item:hover { background:rgba(255, 255, 255, 0.05); }
        .learn-lesson-item.active { background:rgba(72, 202, 228, 0.15); border-left:3px solid #48CAE4; }

        .learn-content {
            flex:1;
            overflow-y:auto;
            padding:0;
            background:#0B132B;
        }
        .learn-content::-webkit-scrollbar { width:6px; }
        .learn-content::-webkit-scrollbar-thumb { background:rgba(72, 202, 228, 0.2); border-radius:3px; }

        .video-placeholder {
            width:100%;
            aspect-ratio:16/9;
            max-height:60vh;
            background:linear-gradient(135deg,#001233 0%,#1C2541 50%,#0B132B 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            overflow:hidden;
        }

        .mobile-sidebar { display:none; }
        @media(max-width:768px){
            .learn-sidebar { display:none; position:fixed; top:60px; left:0; bottom:0; z-index:50; }
            .learn-sidebar.open { display:flex; }
            .mobile-sidebar { display:block; }
        }
    </style>
</head>
<body>
<div class="learn-wrap">

    {{-- Top bar --}}
    <div class="learn-topbar">
        <div class="flex items-center gap-4">
            <button class="mobile-sidebar text-slate-300 hover:text-white" onclick="toggleLearnSidebar()">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a href="{{ route('courses.show', $course['slug']) }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0 bg-blue-600">🧠</div>
                <div class="hidden sm:block">
                    <p class="text-white text-sm font-bold leading-none">{{ $course['title'] }}</p>
                    <p class="text-slate-400 text-xs mt-0.5">{{ $lesson['section_title'] }}</p>
                </div>
            </a>
        </div>

        {{-- Real Progress Header starting from 0% --}}
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col items-end">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Kemajuan Belajar:</span>
                    <span id="topProgressText" class="text-xs font-bold text-cyan-400 font-mono">{{ $course['progress_pct'] }}%</span>
                    <span id="topCompletedCount" class="text-xs text-slate-500">({{ $course['completed_count'] }}/{{ $course['total_lessons'] }} Selesai)</span>
                </div>
                <div class="w-36 h-2 rounded-full bg-slate-800 overflow-hidden mt-1 border border-white/10">
                    <div id="topProgressBar" class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full transition-all duration-500" style="width:{{ $course['progress_pct'] }}%;"></div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition-colors">
                ← Dashboard
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="learn-body">

        {{-- Sidebar: curriculum tree with real completion status --}}
        <aside class="learn-sidebar" id="learn-sidebar">
            <div class="p-4 border-b border-white/10 bg-slate-900/50">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Daftar Modul & Materi</p>
                <p class="text-white text-sm font-bold truncate">{{ $course['title'] }}</p>
                <div class="mt-2 flex items-center justify-between text-xs text-slate-400">
                    <span id="sbCompletedCount">Selesai: {{ $course['completed_count'] }} / {{ $course['total_lessons'] }}</span>
                    <span id="sbProgressPct" class="text-cyan-400 font-mono font-bold">{{ $course['progress_pct'] }}%</span>
                </div>
            </div>

            @foreach($course['sections'] as $si => $section)
            <div>
                <div class="learn-section-hdr" onclick="toggleLearnSection({{ $si }})">
                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold text-white flex-shrink-0 bg-blue-600">{{ $si + 1 }}</span>
                    <span class="text-slate-200 text-xs font-bold flex-1 truncate">{{ $section['title'] }}</span>
                    <svg id="ls-arrow-{{ $si }}" class="w-4 h-4 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div id="ls-section-{{ $si }}" class="ls-group">
                    @foreach($section['lessons'] as $lsn)
                    @php
                        $isActive = $lsn['slug'] === $lesson['slug'];
                        $isComp = !empty($lsn['is_completed']);
                    @endphp
                    <a href="{{ route('learn.lesson', [$course['slug'], $lsn['slug']]) }}"
                       id="sb-lesson-{{ $lsn['slug'] }}"
                       class="learn-lesson-item {{ $isActive ? 'active' : '' }}">
                        <div class="w-5 h-5 rounded flex items-center justify-center flex-shrink-0 {{ $isComp ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-800 text-slate-400' }}">
                            @if($isComp)
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$lsn['type'] === 'video' ? 'video' : ($lsn['type'] === 'quiz' ? 'quiz' : 'reading')] }}"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium truncate {{ $isActive ? 'text-cyan-300 font-bold' : ($isComp ? 'text-slate-300' : 'text-slate-400') }}">
                                {{ $lsn['title'] }}
                            </p>
                            <span class="text-[10px] text-slate-500 uppercase">{{ $lsn['type'] }} · {{ $lsn['duration'] }}</span>
                        </div>
                        @if($isComp)
                            <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded border border-emerald-500/20">✓</span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </aside>

        {{-- Main lesson content --}}
        <main class="learn-content">

            {{-- Auto Completion Toast Notification --}}
            <div id="toastAutoSuccess" class="hidden m-6 p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-2xl animate-bounce">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <div>
                        <p class="text-sm font-bold text-emerald-300" id="toastMessage">Materi diselesaikan! Progress Anda bertambah secara otomatis.</p>
                        <p class="text-xs text-emerald-400/80">Telah tersimpan di database.</p>
                    </div>
                </div>
                <button onclick="document.getElementById('toastAutoSuccess').classList.add('hidden')" class="text-emerald-400 hover:text-white font-bold">&times;</button>
            </div>

            @if(session('success'))
            <div class="m-6 p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎉</span>
                    <div>
                        <p class="text-sm font-bold text-emerald-300">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white font-bold">&times;</button>
            </div>
            @endif

            {{-- VIDEO PLAYER (REAL EMBED OR SIMULATED WITH AUTO COMPLETE ON END) --}}
            @if($lesson['type'] === 'video')
            <div class="video-placeholder">
                @if(!empty($lesson['video_url']))
                    @php
                        $vUrl = $lesson['video_url'];
                        if (str_contains($vUrl, 'watch?v=')) {
                            $vUrl = str_replace('watch?v=', 'embed/', $vUrl);
                        }
                    @endphp
                    @if(str_contains($vUrl, 'youtube.com') || str_contains($vUrl, 'youtu.be'))
                        <iframe id="ytVideoIframe" src="{{ $vUrl }}?enablejsapi=1" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <video id="realHtml5Video" src="{{ $vUrl }}" controls class="w-full h-full object-contain" onended="autoMarkComplete()"></video>
                    @endif
                @else
                    {{-- Simulated Player with Auto Complete --}}
                    <div class="relative z-10 flex flex-col items-center gap-4 text-white max-w-md text-center p-6">
                        <div class="relative">
                            <button id="btnPlayVideo" onclick="simulatePlayVideo()" class="w-20 h-20 rounded-full flex items-center justify-center bg-blue-600 hover:bg-blue-500 text-white shadow-2xl transition-all transform hover:scale-110">
                                <svg id="playIcon" class="w-10 h-10 ml-1" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </div>
                        <div>
                            <p class="font-bold text-white text-lg">{{ $lesson['title'] }}</p>
                            <p class="text-slate-300 text-xs mt-1">Pemutar Video Interaktif SynapEd · {{ $lesson['duration'] }}</p>
                        </div>

                        <div class="w-full bg-slate-900/80 backdrop-blur border border-white/10 rounded-xl p-3 space-y-2 text-xs">
                            <div class="flex items-center justify-between text-slate-400 font-mono">
                                <span id="vidTimer">00:00</span>
                                <span id="vidDuration">15:00</span>
                            </div>
                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden cursor-pointer" onclick="scrubVideo(event)">
                                <div id="vidProgressBar" class="h-full bg-cyan-400 rounded-full transition-all" style="width:0%;"></div>
                            </div>
                            <p id="vidStatusText" class="text-[11px] text-cyan-300 font-semibold">▶ Putar video hingga selesai untuk menaikkan progress otomatis.</p>
                        </div>
                    </div>
                @endif
            </div>

            @elseif($lesson['type'] === 'quiz')
            {{-- Interactive Quiz / Google Form Banner --}}
            <div class="video-placeholder" style="background:linear-gradient(135deg,#0d1b2a 0%,#1b263b 50%,#415a77 100%);">
                <div class="relative z-10 flex flex-col items-center gap-3 text-white text-center p-6">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-300 text-2xl font-bold">
                        📝
                    </div>
                    <h2 class="text-xl font-bold text-white">{{ $lesson['title'] }}</h2>
                    <p class="text-xs text-slate-300">Form Kuis & Evaluasi Pembelajaran (Google Form Style) · {{ $lesson['duration'] }}</p>
                </div>
            </div>

            @else
            {{-- Reading Canvas --}}
            <div class="video-placeholder" style="background:linear-gradient(135deg,#0b132b 0%,#1c2541 50%,#3a506b 100%);">
                <div class="relative z-10 flex flex-col items-center gap-3 text-white text-center p-6">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-300 text-2xl font-bold">
                        📖
                    </div>
                    <h2 class="text-xl font-bold text-white">{{ $lesson['title'] }}</h2>
                    <p class="text-xs text-slate-300">Modul Artikel & Materi Pemahaman Real · {{ $lesson['duration'] }}</p>
                </div>
            </div>
            @endif

            {{-- LESSON DETAILS & CONTENT --}}
            <div class="max-w-3xl mx-auto px-6 py-8">
                <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-6 border-b border-white/10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold text-cyan-400 uppercase tracking-wider">{{ $lesson['section_title'] }}</span>
                            <span class="text-slate-600">·</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-white/10 text-slate-300 border border-white/10">
                                {{ $lesson['type'] }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-white">{{ $lesson['title'] }}</h1>
                    </div>

                    <div>
                        <button id="btnManualMark" onclick="autoMarkComplete()" class="px-5 py-2.5 rounded-xl border text-xs font-bold flex items-center gap-2 transition-all {{ !empty($lesson['is_completed']) ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-300' : 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-lg' }}">
                            <span id="btnMarkIcon">✓</span> <span id="btnMarkText">{{ !empty($lesson['is_completed']) ? 'Pelajaran Telah Selesai' : 'Tandai Selesai' }}</span>
                        </button>
                    </div>
                </div>

                {{-- GOOGLE FORM STYLE QUIZ EXPERIENCE FOR STUDENT --}}
                @if($lesson['type'] === 'quiz')
                @php
                    $qList = !empty($lesson['quiz_data']) ? $lesson['quiz_data'] : [
                        [
                            'id' => 1,
                            'question' => 'Apa komponen utama dalam pengukuran gelombang elektrik otak?',
                            'type' => 'pilihan_ganda',
                            'points' => 50,
                            'options' => ['Elektroda EEG dan Penguat Sinyal', 'Sensor Suhu Tubuh', 'Kamera Optik', 'Perangkat Magnetik Statis'],
                            'correct_answer' => 0
                        ],
                        [
                            'id' => 2,
                            'question' => 'Jelaskan perbedaan mendasar gelombang Alpha dan Beta!',
                            'type' => 'uraian',
                            'points' => 50,
                            'options' => ['', '', '', ''],
                            'correct_answer' => 0
                        ]
                    ];
                @endphp
                <div class="mb-8 bg-slate-900/90 border border-amber-500/30 rounded-2xl p-6 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <h3 class="text-base font-bold text-white flex items-center gap-2">
                                📝 Lembar Kuis (Google Form Experience)
                            </h3>
                            <p class="text-xs text-slate-400">Kerjakan kuis di bawah ini. Skor dan penilaiaan otomatis akan langsung dihitung.</p>
                        </div>
                        <span id="scoreBadge" class="hidden px-3 py-1 bg-emerald-500/20 text-emerald-300 font-bold text-xs rounded-lg border border-emerald-500/30">
                            Skor: 100/100
                        </span>
                    </div>

                    <form id="studentQuizForm" onsubmit="evaluateStudentQuiz(event)" class="space-y-6">
                        @foreach($qList as $qIndex => $q)
                        <div class="p-5 rounded-xl bg-slate-800/70 border border-white/05 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-bold text-white">{{ $qIndex + 1 }}. {{ $q['question'] }}</p>
                                <span class="text-[10px] font-mono text-amber-400 font-bold bg-amber-500/10 px-2 py-0.5 rounded">
                                    {{ $q['points'] ?? 50 }} Poin
                                </span>
                            </div>

                            @if(($q['type'] ?? 'pilihan_ganda') === 'pilihan_ganda')
                                <div class="space-y-2 text-xs text-slate-300 pt-1">
                                    @foreach($q['options'] as $optIndex => $optionText)
                                    @if(!empty($optionText))
                                    <label id="opt-lbl-{{ $qIndex }}-{{ $optIndex }}" class="flex items-center gap-3 p-3 rounded-xl bg-slate-900/50 hover:bg-slate-700/50 cursor-pointer border border-white/05 transition-all">
                                        <input type="radio" name="student_q_{{ $qIndex }}" value="{{ $optIndex }}" required class="text-amber-500 focus:ring-0">
                                        <span class="font-bold text-slate-400">{{ chr(65 + $optIndex) }}.</span>
                                        <span class="flex-1">{{ $optionText }}</span>
                                    </label>
                                    @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="pt-1">
                                    <textarea name="student_q_{{ $qIndex }}_essay" rows="3" required placeholder="Ketikkan jawaban uraian Anda di sini..." class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-amber-400"></textarea>
                                </div>
                            @endif
                        </div>
                        @endforeach

                        <div class="pt-2">
                            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-bold text-xs rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                                🚀 Kirim Jawaban Kuis & Hitung Skor Otomatis
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                {{-- VIDEO TRANSCRIPT AREA --}}
                @if($lesson['type'] === 'video' && !empty($lesson['transcript']))
                <div class="p-5 rounded-2xl bg-slate-900/80 border border-white/10 space-y-3 mb-8">
                    <h4 class="font-bold text-white flex items-center gap-2 text-xs uppercase tracking-wider text-cyan-400">
                        📝 Transkrip Teks Lengkap Video
                    </h4>
                    <div class="text-xs text-slate-300 leading-relaxed font-mono whitespace-pre-line bg-slate-950 p-4 rounded-xl border border-white/05 max-h-60 overflow-y-auto">
                        {{ $lesson['transcript'] }}
                    </div>
                </div>
                @endif

                {{-- READING FILE ATTACHMENT AREA --}}
                @if($lesson['type'] === 'reading' && !empty($lesson['attachment_path']))
                <div class="p-5 rounded-2xl bg-blue-950/40 border border-blue-500/30 space-y-3 mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">📎</span>
                        <div>
                            <p class="text-xs font-bold text-white">File Lampiran Dokumen Materi</p>
                            <p class="text-[10px] text-blue-300">{{ basename($lesson['attachment_path']) }}</p>
                        </div>
                    </div>
                    <a href="{{ $lesson['attachment_path'] }}" download target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition-all shadow-md">
                        📥 Download File
                    </a>
                </div>
                @endif

                {{-- REAL LESSON CONTENT BODY --}}
                <div class="space-y-5 text-slate-300 text-sm leading-relaxed mb-8">
                    <div class="p-5 rounded-2xl bg-slate-900/70 border border-white/10 space-y-2">
                        <h4 class="font-bold text-white flex items-center gap-2 text-xs uppercase tracking-wider text-cyan-400">
                            📄 Isi Materi Pelajaran Real
                        </h4>
                        <div class="text-xs leading-relaxed text-slate-200 whitespace-pre-line">
                            {{ $lesson['content'] }}
                        </div>
                    </div>
                </div>

                {{-- PREV / NEXT NAVIGATION --}}
                <div class="flex items-center justify-between pt-6 border-t border-white/10">
                    @if($prevLesson)
                    <a href="{{ route('learn.lesson', [$course['slug'], $prevLesson['slug']]) }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors flex items-center gap-2">
                        ← {{ $prevLesson['title'] }}
                    </a>
                    @else<div></div>@endif

                    @if($nextLesson)
                    <a href="{{ route('learn.lesson', [$course['slug'], $nextLesson['slug']]) }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold transition-colors flex items-center gap-2">
                        Lanjut ke: {{ $nextLesson['title'] }} →
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition-all shadow-lg flex items-center gap-2">
                        🎉 Ke Dashboard
                    </a>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleLearnSidebar() {
    document.getElementById('learn-sidebar').classList.toggle('open');
}

function toggleLearnSection(i) {
    const el = document.getElementById('ls-section-' + i);
    const ar = document.getElementById('ls-arrow-' + i);
    const open = el.style.display !== 'none';
    el.style.display = open ? 'none' : 'block';
    ar.style.transform = open ? '' : 'rotate(180deg)';
}

// AUTO MARK COMPLETE VIA AJAX WHEN VIDEO FINISHES OR QUIZ SUBMITTED
let hasAutoCompleted = false;

function autoMarkComplete() {
    if (hasAutoCompleted) return;

    const courseSlug = '{{ $course["slug"] }}';
    const lessonSlug = '{{ $lesson["slug"] }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/courses/' + courseSlug + '/lessons/' + lessonSlug + '/complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            hasAutoCompleted = true;
            const topText = document.getElementById('topProgressText');
            const topBar = document.getElementById('topProgressBar');
            const sbPct = document.getElementById('sbProgressPct');

            if (topText) topText.innerText = data.progress + '%';
            if (topBar) topBar.style.width = data.progress + '%';
            if (sbPct) sbPct.innerText = data.progress + '%';

            const toast = document.getElementById('toastAutoSuccess');
            const toastMsg = document.getElementById('toastMessage');
            if (toast && toastMsg) {
                toastMsg.innerText = '✓ Materi Selesai! Progress Anda bertambah menjadi ' + data.progress + '% secara otomatis.';
                toast.classList.remove('hidden');
            }

            const btnMarkText = document.getElementById('btnMarkText');
            if (btnMarkText) btnMarkText.innerText = 'Pelajaran Telah Selesai (Disimpan)';
        }
    })
    .catch(err => console.error('Error auto marking complete:', err));
}

// EVALUATE STUDENT QUIZ ANSWERS WITH REAL SCORING
function evaluateStudentQuiz(e) {
    e.preventDefault();
    const quizData = @json(!empty($lesson['quiz_data']) ? $lesson['quiz_data'] : []);
    let earnedPoints = 0;
    let totalPoints = 0;

    quizData.forEach((q, qIdx) => {
        const pts = parseInt(q.points || 50);
        totalPoints += pts;

        if ((q.type || 'pilihan_ganda') === 'pilihan_ganda') {
            const selected = document.querySelector(`input[name="student_q_${qIdx}"]:checked`);
            const correctOpt = parseInt(q.correct_answer || 0);

            if (selected && parseInt(selected.value) === correctOpt) {
                earnedPoints += pts;
                const lbl = document.getElementById(`opt-lbl-${qIdx}-${selected.value}`);
                if (lbl) {
                    lbl.classList.remove('bg-slate-900/50');
                    lbl.classList.add('bg-emerald-500/20', 'border-emerald-500');
                }
            }
        } else {
            // Essay question gets default rubric score upon response
            const essayInput = document.querySelector(`textarea[name="student_q_${qIdx}_essay"]`);
            if (essayInput && essayInput.value.trim().length > 5) {
                earnedPoints += pts;
            }
        }
    });

    const finalScore = totalPoints > 0 ? Math.round((earnedPoints / totalPoints) * 100) : 100;
    const scoreBadge = document.getElementById('scoreBadge');
    if (scoreBadge) {
        scoreBadge.innerText = `Skor Kuis Anda: ${finalScore}/100`;
        scoreBadge.classList.remove('hidden');
    }

    autoMarkComplete();
}

// Simulated Video Player Logic
let isPlaying = false;
let vidProgress = 0;
let vidInterval = null;

function simulatePlayVideo() {
    isPlaying = !isPlaying;
    const playIcon = document.getElementById('playIcon');
    const statusText = document.getElementById('vidStatusText');

    if (isPlaying) {
        if (playIcon) playIcon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>';
        if (statusText) statusText.innerText = '▶ Video sedang diputar...';
        vidInterval = setInterval(() => {
            if (vidProgress < 100) {
                vidProgress += 4;
                const pBar = document.getElementById('vidProgressBar');
                if (pBar) pBar.style.width = vidProgress + '%';

                let currentSec = Math.floor((vidProgress / 100) * 300);
                let mins = Math.floor(currentSec / 60);
                let secs = currentSec % 60;
                const timer = document.getElementById('vidTimer');
                if (timer) timer.innerText = (mins < 10 ? '0' + mins : mins) + ':' + (secs < 10 ? '0' + secs : secs);
            } else {
                clearInterval(vidInterval);
                if (statusText) statusText.innerText = '✓ Video Selesai! Progress otomatis bertambah.';
                autoMarkComplete();
            }
        }, 200);
    } else {
        if (playIcon) playIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
        if (statusText) statusText.innerText = '⏸ Video di-pause.';
        clearInterval(vidInterval);
    }
}

function scrubVideo(e) {
    const rect = e.currentTarget.getBoundingClientRect();
    const clickX = e.clientX - rect.left;
    vidProgress = Math.round((clickX / rect.width) * 100);
    const pBar = document.getElementById('vidProgressBar');
    if (pBar) pBar.style.width = vidProgress + '%';
}
</script>
</body>
</html>
