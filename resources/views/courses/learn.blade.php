{{-- Full-screen learning environment (no public navbar/footer) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $lesson['title'] }} – {{ $course['title'] }} | NeuroAcademy</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧠</text></svg>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,body { height:100%; margin:0; }
        .learn-wrap { display:flex; flex-direction:column; height:100vh; background:#EFF7F7; color:#1A4A52; }

        /* Top bar */
        .learn-topbar {
            flex-shrink:0;
            height:56px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 16px;
            border-bottom:1px solid rgba(12,119,121,0.12);
            background:rgba(239,247,247,0.97);
            backdrop-filter:blur(12px);
        }

        /* Body below topbar */
        .learn-body { display:flex; flex:1; overflow:hidden; }

        /* Sidebar ------------------------------------------------------ */
        .learn-sidebar {
            width:300px;
            flex-shrink:0;
            overflow-y:auto;
            border-right:1px solid rgba(255,255,255,0.06);
            background:#005461;
            display:flex;
            flex-direction:column;
        }
        .learn-sidebar::-webkit-scrollbar { width:4px; }
        .learn-sidebar::-webkit-scrollbar-thumb { background:rgba(94,206,208,0.4); border-radius:2px; }

        .learn-section-hdr {
            display:flex;
            align-items:center;
            gap:10px;
            padding:12px 16px;
            cursor:pointer;
            border-bottom:1px solid rgba(255,255,255,0.06);
            background:rgba(255,255,255,0.03);
            user-select:none;
        }
        .learn-section-hdr:hover { background:rgba(94,206,208,0.1); }

        .learn-lesson-item {
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 16px 10px 42px;
            cursor:pointer;
            border-bottom:1px solid rgba(255,255,255,0.04);
            transition:background 0.15s;
            text-decoration:none;
        }
        .learn-lesson-item:hover { background:rgba(94,206,208,0.08); }
        .learn-lesson-item.active { background:rgba(12,119,121,0.4); border-left:2px solid #5ECED0; }

        .learn-lesson-ico {
            width:22px;
            height:22px;
            border-radius:6px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
            background:rgba(94,206,208,0.15);
        }

        /* Main content ------------------------------------------------- */
        .learn-content {
            flex:1;
            overflow-y:auto;
            padding:0;
            background:#EFF7F7;
        }
        .learn-content::-webkit-scrollbar { width:5px; }
        .learn-content::-webkit-scrollbar-thumb { background:rgba(12,119,121,0.2); border-radius:2px; }

        .video-placeholder {
            width:100%;
            aspect-ratio:16/9;
            max-height:65vh;
            background:linear-gradient(135deg,#005461 0%,#0C7779 50%,#005461 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            overflow:hidden;
        }
        .video-placeholder::before {
            content:'';
            position:absolute;
            inset:0;
            background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 20'%3E%3Cpath d='M0 10 Q12 0 25 10 Q37 20 50 10 Q62 0 75 10 Q87 20 100 10' stroke='rgba(255,255,255,0.08)' fill='none' stroke-width='1'/%3E%3C/svg%3E") repeat-x center;
            background-size:200px 40px;
            animation:waveMove 5s linear infinite;
        }
        @keyframes waveMove { from{background-position-x:0} to{background-position-x:200px} }

        .mobile-sidebar { display:none; }
        @media(max-width:768px){
            .learn-sidebar { display:none; position:fixed; top:56px; left:0; bottom:0; z-index:50; }
            .learn-sidebar.open { display:flex; }
            .mobile-sidebar { display:block; }
        }

        /* ── Text & element overrides for teal palette ─────── */
        .learn-topbar .text-white,
        .learn-topbar .text-slate-400,
        .learn-topbar .text-slate-500    { color: #005461 !important; }
        .learn-topbar a                  { color: #1A4A52; transition: color 0.15s; }
        .learn-topbar a:hover            { color: #005461; }
        .learn-topbar button             { color: #4A7A82; }
        .learn-topbar button:hover svg   { color: #005461; }

        /* Sidebar is dark — keep light text */
        .learn-sidebar .text-slate-300   { color: rgba(255,255,255,0.7) !important; }
        .learn-sidebar .text-slate-400,
        .learn-sidebar .text-slate-500,
        .learn-sidebar .text-slate-600   { color: rgba(255,255,255,0.5) !important; }
        .learn-sidebar p.text-white      { color: #fff !important; }

        .learn-content .text-white       { color: #005461 !important; }
        .learn-content strong.text-white { color: #005461 !important; }
        .learn-content .text-slate-300   { color: #1A4A52 !important; }
        .learn-content .text-slate-400,
        .learn-content .text-slate-500,
        .learn-content .text-slate-700   { color: #4A7A82 !important; }
        .learn-content .text-blue-300,
        .learn-content .text-teal-300,
        .learn-content .text-teal-400    { color: #0C7779 !important; }
        .learn-content .border-white\/08 { border-color: rgba(12,119,121,0.12) !important; }
        .learn-content .border-t         { border-color: rgba(12,119,121,0.12) !important; }
        .learn-content .glass-card {
            background: rgba(255,255,255,0.88) !important;
            border-color: rgba(12,119,121,0.12) !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 4px 16px rgba(12,119,121,0.06) !important;
        }
        .learn-sidebar [class*="border-white"] { border-color: rgba(255,255,255,0.06) !important; }
        .learn-content [class*="border-white"],
        .learn-topbar  [class*="border-white"] { border-color: rgba(12,119,121,0.12) !important; }
    </style>
</head>
<body>
<div class="learn-wrap">

    {{-- Top bar --}}
    <div class="learn-topbar">
        <div class="flex items-center gap-4">
            <button class="mobile-sidebar text-slate-400 hover:text-white transition-colors" onclick="toggleLearnSidebar()">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a href="{{ route('courses.show', $course['slug']) }}" class="flex items-center gap-2 group">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background:{{ $course['gradient'] }};">🧠</div>
                <div class="hidden sm:block">
                    <p class="text-white text-sm font-semibold leading-none">{{ $course['title'] }}</p>
                    <p class="text-slate-500 text-xs">{{ $lesson['section_title'] }}</p>
                </div>
            </a>
        </div>

        {{-- Progress bar area --}}
        @php
            $total  = count($flatLessons);
            $curIdx = collect($flatLessons)->search(fn($l) => $l['slug'] === $lesson['slug']);
            $pct    = $total > 0 ? round(($curIdx / $total) * 100) : 0;
        @endphp
        <div class="hidden sm:flex items-center gap-3">
            <span class="text-slate-400 text-xs">{{ $curIdx + 1 }} / {{ $total }}</span>
            <div class="w-24 h-1.5 rounded-full bg-white/10 overflow-hidden">
                <div class="h-full rounded-full" style="width:{{ $pct }}%;background:linear-gradient(90deg,#0C7779,#5ECED0);"></div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white text-xs transition-colors hidden sm:block">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-red-400 text-xs transition-colors">Keluar</button>
            </form>
        </div>
    </div>

    {{-- Body --}}
    <div class="learn-body">

        {{-- Sidebar: curriculum tree --}}
        <aside class="learn-sidebar" id="learn-sidebar">
            <div class="p-4 border-b border-white/06">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mb-1">Kurikulum</p>
                <p class="text-white text-sm font-bold">{{ $course['title'] }}</p>
            </div>

            @foreach($course['sections'] as $si => $section)
            <div>
                <div class="learn-section-hdr" onclick="toggleLearnSection({{ $si }})">
                    <span class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                          style="background:{{ $course['gradient'] }};">{{ $si + 1 }}</span>
                    <span class="text-slate-300 text-sm font-semibold flex-1">{{ $section['title'] }}</span>
                    <svg id="ls-arrow-{{ $si }}" class="w-4 h-4 text-slate-500 transition-transform"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div id="ls-section-{{ $si }}" class="ls-group" style="display:none;">
                    @foreach($section['lessons'] as $lsn)
                    @php
                        $isActive = $lsn['slug'] === $lesson['slug'];
                        $tColor  = $lsn['type'] === 'video' ? '#0C7779' : ($lsn['type'] === 'quiz' ? '#5ECED0' : '#005461');
                    @endphp
                    <a href="{{ route('learn.lesson', [$course['slug'], $lsn['slug']]) }}"
                       class="learn-lesson-item {{ $isActive ? 'active' : '' }}">
                        <div class="learn-lesson-ico" style="background:rgba(255,255,255,0.07);">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                 style="color:{{ $tColor }};">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$lsn['type'] === 'video' ? 'video' : ($lsn['type'] === 'quiz' ? 'quiz' : 'reading')] }}"/>
                            </svg>
                        </div>
                        <span class="text-{{ $isActive ? 'white' : 'slate-400' }} text-xs leading-snug flex-1">{{ $lsn['title'] }}</span>
                        <span class="text-slate-600 text-xs flex-shrink-0">{{ $lsn['duration'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </aside>

        {{-- Main lesson content --}}
        <main class="learn-content">

            {{-- Video area --}}
            @if($lesson['type'] === 'video')
            <div class="video-placeholder">
                <div class="relative z-10 flex flex-col items-center gap-4 text-white">
                    <button class="w-20 h-20 rounded-full flex items-center justify-center transition-transform hover:scale-110"
                            style="background:rgba(12,119,121,0.8);box-shadow:0 0 40px rgba(12,119,121,0.5);">
                        <svg class="w-10 h-10 ml-1" viewBox="0 0 24 24" fill="white">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                    <div class="text-center">
                        <p class="font-bold text-lg">{{ $lesson['title'] }}</p>
                        <p class="text-teal-200 text-sm">{{ $lesson['duration'] }}</p>
                    </div>
                </div>
            </div>
            @elseif($lesson['type'] === 'quiz')
            <div class="video-placeholder" style="background:linear-gradient(135deg,#005461 0%,#0C7779 50%,#5ECED0 100%);">
                <div class="relative z-10 flex flex-col items-center gap-4 text-white">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center"
                         style="background:rgba(12,119,121,0.8);box-shadow:0 0 40px rgba(12,119,121,0.5);">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths['quiz'] }}"/>
                        </svg>
                    </div>
                    <p class="font-bold text-lg">{{ $lesson['title'] }}</p>
                    <p class="text-teal-200 text-sm">Kuis · {{ $lesson['duration'] }}</p>
                </div>
            </div>
            @else
            <div class="video-placeholder" style="background:linear-gradient(135deg,#005461 0%,#0A3D47 50%,#0C7779 100%);">
                <div class="relative z-10 flex flex-col items-center gap-4 text-white">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center"
                         style="background:rgba(0,84,97,0.8);box-shadow:0 0 40px rgba(0,84,97,0.5);">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths['reading'] }}"/>
                        </svg>
                    </div>
                    <p class="font-bold text-lg">{{ $lesson['title'] }}</p>
                    <p class="text-cyan-200 text-sm">Bacaan · {{ $lesson['duration'] }}</p>
                </div>
            </div>
            @endif

            {{-- Lesson content area --}}
            <div class="max-w-3xl mx-auto px-6 py-10">
                {{-- Meta --}}
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-slate-500 text-xs uppercase tracking-widest">{{ $lesson['section_title'] }}</span>
                    <span class="text-slate-700">·</span>
                    <span class="text-slate-500 text-xs">{{ $lesson['duration'] }}</span>
                    <span class="text-slate-700">·</span>
                    <span class="px-2 py-0.5 rounded text-xs font-medium"
                    style="background:{{ $lesson['type']==='video' ? 'rgba(12,119,121,0.12)' : ($lesson['type']==='quiz' ? 'rgba(94,206,208,0.12)' : 'rgba(0,84,97,0.12)') }};color:{{ $lesson['type']==='video' ? '#0C7779' : ($lesson['type']==='quiz' ? '#0C7779' : '#005461') }};">
                        {{ ucfirst($lesson['type']) }}
                    </span>
                </div>

                <h1 class="text-2xl font-black text-white mb-6 leading-tight" style="font-family:var(--font-heading);">
                    {{ $lesson['title'] }}
                </h1>

                {{-- Placeholder lesson body --}}
                <div class="space-y-4 text-slate-700 leading-relaxed text-base">
                    <p>Selamat datang di pelajaran <strong class="text-white">{{ $lesson['title'] }}</strong>, bagian dari modul <em>{{ $lesson['section_title'] }}</em>.</p>
                    <p>Dalam pelajaran ini, Anda akan mempelajari konsep-konsep kunci yang menjadi fondasi dari pemahaman yang lebih dalam tentang {{ $course['title'] }}. Materi dirancang agar dapat dipahami oleh siapa saja, baik yang memiliki latar belakang sains maupun tidak.</p>
                    <div class="glass-card rounded-2xl p-6 border border-white/08 my-6">
                        <p class="text-teal-300 font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Poin Pembelajaran Utama
                        </p>
                        <ul class="space-y-2 text-sm">
                            @foreach(array_slice($course['what_you_learn'], 0, 3) as $wyl)
                            <li class="flex items-start gap-2">
                                <span class="text-teal-400 mt-0.5">•</span>
                                <span>{{ $wyl }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <p>Konten materi lengkap akan tersedia setelah sistem LMS terhubung dengan basis data konten. Untuk saat ini, gunakan bagian ini untuk menavigasi kurikulum dan memahami alur pembelajaran secara keseluruhan.</p>
                </div>

                {{-- Prev / Next --}}
                <div class="flex items-center justify-between mt-12 pt-8 border-t border-white/08">
                    @if($prevLesson)
                    <a href="{{ route('learn.lesson', [$course['slug'], $prevLesson['slug']]) }}"
                       class="flex items-center gap-3 glass-card rounded-xl px-4 py-3 border border-white/08 hover:border-teal-500/30 transition-all group max-w-xs">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        <div class="text-left min-w-0">
                            <p class="text-slate-500 text-xs">Sebelumnya</p>
                            <p class="text-white text-sm font-medium truncate">{{ $prevLesson['title'] }}</p>
                        </div>
                    </a>
                    @else<div></div>@endif

                    @if($nextLesson)
                    <a href="{{ route('learn.lesson', [$course['slug'], $nextLesson['slug']]) }}"
                       class="flex items-center gap-3 glass-card rounded-xl px-4 py-3 border border-white/08 hover:border-teal-500/30 transition-all group max-w-xs text-right">
                        <div class="min-w-0">
                            <p class="text-slate-500 text-xs">Selanjutnya</p>
                            <p class="text-white text-sm font-medium truncate">{{ $nextLesson['title'] }}</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-teal-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}"
                       class="btn-gradient flex items-center gap-3 rounded-xl px-5 py-3">
                        <span class="text-white font-semibold">Selesai! Ke Dashboard</span>
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
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

// Auto-open the section containing the active lesson
document.addEventListener('DOMContentLoaded', () => {
    const active = document.querySelector('.learn-lesson-item.active');
    if (active) {
        const group = active.closest('.ls-group');
        if (group) {
            group.style.display = 'block';
            const id = group.id.replace('ls-section-', '');
            const ar = document.getElementById('ls-arrow-' + id);
            if (ar) ar.style.transform = 'rotate(180deg)';
        }
    }
});
</script>
</body>
</html>
