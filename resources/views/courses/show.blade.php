@extends('layouts.public')
@section('title', $course['title'] . ' – NeuroAcademy')

@section('content')
@php $lm = $levelMap[$course['level_color']]; @endphp
<div style="background:var(--bg-page)">

{{-- Hero --}}
<section class="relative py-28 overflow-hidden">
    <div class="absolute inset-0 grid-bg opacity-20 pointer-events-none"></div>
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute w-96 h-96 top-0 right-0 rounded-full opacity-15" style="background:radial-gradient(circle,{{ $course['gradient_from'] }} 0%,transparent 70%);filter:blur(80px);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-teal-400 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('courses.index') }}" class="hover:text-teal-400 transition-colors">Kursus</a>
            <span>/</span>
            <span class="text-slate-300">{{ $course['title'] }}</span>
        </nav>

        <div class="grid lg:grid-cols-3 gap-10">
            {{-- Course Info (left 2/3) --}}
            <div class="lg:col-span-2">
                {{-- Badge --}}
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold"
                          style="background:{{ $lm['bg'] }};color:{{ $lm['text'] }};border:1px solid {{ $lm['border'] }};">
                        {{ $course['level'] }}
                    </span>
                    <span class="text-slate-500 text-sm">{{ $course['lessons_count'] }} pelajaran · {{ $course['duration'] }}</span>
                </div>

                <h1 class="text-4xl font-black text-white mb-5 leading-tight" style="font-family:var(--font-heading);">{{ $course['title'] }}</h1>
                <p class="text-slate-300 text-lg leading-relaxed mb-8">{{ $course['long_desc'] }}</p>

                {{-- Instructor --}}
                <div class="flex items-center gap-4 mb-10 glass-card p-4 rounded-2xl border border-white/08">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 text-sm"
                         style="background:{{ $course['gradient'] }};">
                        {{ strtoupper(substr($course['instructor'], 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs mb-0.5">Instruktur</p>
                        <p class="text-white font-semibold">{{ $course['instructor'] }}</p>
                        <p class="text-slate-400 text-sm">{{ $course['instructor_bio'] }}</p>
                    </div>
                </div>

                {{-- What you'll learn --}}
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-white mb-5" style="font-family:var(--font-heading);">Yang Akan Anda Pelajari</h2>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($course['what_you_learn'] as $item)
                        <div class="flex items-start gap-3 glass-card rounded-xl p-3 border border-white/05">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="none" stroke="#10B981" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-slate-300 text-sm leading-relaxed">{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Requirements --}}
                @if(!empty($course['requirements']))
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-white mb-5" style="font-family:var(--font-heading);">Prasyarat</h2>
                    <ul class="space-y-2">
                        @foreach($course['requirements'] as $req)
                        <li class="flex items-start gap-3 text-slate-300 text-sm">
                            <span class="w-1.5 h-1.5 rounded-full mt-2 flex-shrink-0" style="background:{{ $course['gradient_from'] }};"></span>
                            {{ $req }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Curriculum --}}
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-xl font-bold text-white" style="font-family:var(--font-heading);">Kurikulum</h2>
                        <span class="text-slate-400 text-sm">{{ $course['lessons_count'] }} pelajaran · {{ $course['duration'] }}</span>
                    </div>

                    <div class="space-y-3" id="curriculum">
                        @foreach($course['sections'] as $si => $section)
                        <div class="glass-card rounded-2xl border border-white/08 overflow-hidden">
                            {{-- Section header --}}
                            <button onclick="toggleSection({{ $si }})"
                                    class="w-full flex items-center justify-between px-5 py-4 text-left group">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                          style="background:{{ $course['gradient'] }};">{{ $si + 1 }}</span>
                                    <span class="text-white font-semibold group-hover:text-teal-300 transition-colors">{{ $section['title'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 text-xs">{{ count($section['lessons']) }} pelajaran</span>
                                    <svg id="arrow-{{ $si }}" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            {{-- Lessons --}}
                            <div id="section-{{ $si }}" class="section-lessons border-t border-white/05">
                                @foreach($section['lessons'] as $lesson)
                                @php
                                    $typeIcon = $lesson['type'] === 'video' ? 'video' : ($lesson['type'] === 'quiz' ? 'quiz' : 'reading');
                                    $typeBg   = $lesson['type'] === 'video' ? '#0C7779' : ($lesson['type'] === 'quiz' ? '#5ECED0' : '#005461');
                                @endphp
                                <div class="flex items-center gap-4 px-5 py-3 hover:bg-white/03 transition-colors border-b border-white/03 last:border-0">
                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background:rgba({{ hex2rgb($typeBg) }},0.15);">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:{{ $typeBg }};">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$typeIcon] }}"/>
                                        </svg>
                                    </div>
                                    <span class="flex-1 text-slate-300 text-sm">{{ $lesson['title'] }}</span>
                                    @if($lesson['free'])
                                    <span class="text-xs px-2 py-0.5 rounded-full text-teal-400 border border-teal-500/30 bg-teal-500/10">Pratinjau</span>
                                    @endif
                                    <span class="text-slate-500 text-xs flex-shrink-0">{{ $lesson['duration'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sticky CTA card (right 1/3) --}}
            <div class="hidden lg:block">
                <div class="sticky top-24 glass-card rounded-2xl border border-white/10 overflow-hidden">
                    {{-- Gradient header --}}
                    <div class="h-2" style="background:{{ $course['gradient'] }};"></div>
                    <div class="p-6">
                        {{-- Course icon --}}
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                             style="background:{{ $course['gradient'] }};">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$course['icon']] }}"/>
                            </svg>
                        </div>

                        <h3 class="text-white font-bold text-lg mb-4 leading-tight">{{ $course['title'] }}</h3>

                        {{-- Stats --}}
                        <div class="space-y-3 mb-6">
                            @foreach([['Tingkat', $course['level']], ['Durasi', $course['duration']], ['Pelajaran', $course['lessons_count'].' modul'], ['Rating', $course['rating'].'★ ('.$course['reviews'].' ulasan)']] as [$label,$val])
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-400">{{ $label }}</span>
                                <span class="text-white font-medium">{{ $val }}</span>
                            </div>
                            @endforeach
                        </div>

                        {{-- CTA --}}
                        @auth
                            <a href="{{ route('learn', $course['slug']) }}"
                               class="btn-gradient block w-full py-3 rounded-xl text-white font-semibold text-center text-base transition-all hover:opacity-90">
                                Mulai Belajar
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="btn-gradient block w-full py-3 rounded-xl text-white font-semibold text-center text-base transition-all hover:opacity-90 mb-3">
                                Daftar & Mulai Belajar
                            </a>
                            <a href="{{ route('login') }}"
                               class="glass-card block w-full py-3 rounded-xl text-slate-300 font-semibold text-center text-base border border-white/10 hover:border-teal-500/30 transition-all">
                                Sudah punya akun? Masuk
                            </a>
                        @endauth

                        <p class="text-center text-slate-500 text-xs mt-4">Akses penuh setelah mendaftar</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile CTA --}}
        <div class="lg:hidden mt-10">
            @auth
                <a href="{{ route('learn', $course['slug']) }}"
                   class="btn-gradient block w-full py-4 rounded-xl text-white font-semibold text-center text-lg">
                    Mulai Belajar
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="btn-gradient block w-full py-4 rounded-xl text-white font-semibold text-center text-lg mb-3">
                    Daftar & Mulai Belajar
                </a>
            @endauth
        </div>
    </div>
</section>
</div>

@php
function hex2rgb($hex) {
    $hex = ltrim($hex,'#');
    return implode(',', [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))]);
}
@endphp

@endsection

@push('head')
<style>
.section-lessons { display: none; }
.section-lessons.open { display: block; }
</style>
@endpush

@push('scripts')
<script>
function toggleSection(i) {
    const el = document.getElementById('section-' + i);
    const ar = document.getElementById('arrow-' + i);
    el.classList.toggle('open');
    ar.style.transform = el.classList.contains('open') ? 'rotate(180deg)' : '';
}
// Open first section by default
document.addEventListener('DOMContentLoaded', () => toggleSection(0));
</script>
@endpush
