@extends('layouts.public')
@section('title', $course['seo_title'])

@section('content')
@php
    $levelBadge = $levelMap[$course['level_color']] ?? ['bg' => 'rgba(12,119,121,0.15)', 'text' => '#0C7779', 'border' => 'rgba(12,119,121,0.30)'];
@endphp

<div style="background:var(--bg-page)">
    <section class="relative overflow-hidden py-16 lg:py-24">
        <div class="absolute inset-0 grid-bg opacity-30 pointer-events-none"></div>
        <div class="absolute inset-x-0 top-0 h-56 bg-gradient-to-b from-teal-500/10 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-slate-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-teal-400 transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('courses.index') }}" class="hover:text-teal-400 transition-colors">Kursus</a>
                <span>/</span>
                <span class="text-slate-300">{{ $course['title'] }}</span>
            </nav>

            <div class="grid lg:grid-cols-[minmax(0,1.65fr)_360px] gap-10 items-start">
                <div class="space-y-8">
                    <div class="glass-card rounded-3xl p-8 lg:p-10 border border-white/10">
                        <div class="flex flex-wrap items-center gap-3 mb-5">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:{{ $levelBadge['bg'] }};color:{{ $levelBadge['text'] }};border:1px solid {{ $levelBadge['border'] }};">{{ $course['level'] }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/65 text-slate-600 border border-white/20">{{ $course['stats']['lesson_count'] }} pelajaran</span>
                            @if($course['has_free_preview'])
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-teal-700 bg-teal-500/15 border border-teal-500/25">Preview gratis tersedia</span>
                            @endif
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-5" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['title'] }}</h1>
                        <p class="text-lg lg:text-xl leading-relaxed max-w-3xl text-slate-300">{{ $course['hero_blurb'] }}</p>

                        <div class="grid md:grid-cols-[minmax(0,1fr)_280px] gap-6 mt-8">
                            <div>
                                <h2 class="text-xl font-bold mb-4" style="font-family:var(--font-heading); color:var(--text-h);">Yang akan Anda pelajari</h2>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach($course['what_you_learn'] as $item)
                                        <div class="flex items-start gap-3 glass-card rounded-2xl p-4 border border-white/08">
                                            <span class="mt-0.5 w-6 h-6 rounded-full flex items-center justify-center bg-teal-500/15 text-teal-700 flex-shrink-0">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </span>
                                            <span class="text-sm leading-relaxed text-slate-300">{{ $item }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-6 p-5 rounded-3xl border border-white/10 glass-card">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 text-white font-black text-lg" style="background:{{ $course['gradient'] }};">{{ $course['instructor_avatar'] }}</div>
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-1">Instruktur</p>
                                        <p class="font-bold text-lg" style="color:var(--text-h);">{{ $course['instructor_profile']['name'] }}</p>
                                        <p class="text-sm text-slate-400">{{ $course['instructor_profile']['role'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="glass-card rounded-2xl p-4 border border-white/08">
                                    <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-2">Durasi</p>
                                    <p class="text-xl font-black" style="color:var(--text-h);">{{ $course['stats']['duration_label'] }}</p>
                                </div>
                                <div class="glass-card rounded-2xl p-4 border border-white/08">
                                    <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-2">Pelajaran</p>
                                    <p class="text-xl font-black" style="color:var(--text-h);">{{ $course['stats']['lesson_count'] }}</p>
                                </div>
                                <div class="glass-card rounded-2xl p-4 border border-white/08">
                                    <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-2">Peserta</p>
                                    <p class="text-xl font-black" style="color:var(--text-h);">{{ $course['stats']['enrolled_students'] }}</p>
                                </div>
                                <div class="glass-card rounded-2xl p-4 border border-white/08">
                                    <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-2">Diperbarui</p>
                                    <p class="text-lg font-black" style="color:var(--text-h);">{{ $course['stats']['last_updated'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <a href="{{ $course['cta']['href'] }}" class="btn-gradient inline-flex items-center justify-center px-6 py-3 rounded-2xl text-white font-semibold text-base shadow-lg shadow-teal-900/10">
                                {{ $course['cta']['label'] }}
                            </a>
                            <a href="#kurikulum" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl border border-white/10 glass-card font-semibold text-slate-300 hover:border-teal-500/30 transition-colors">Lihat Kurikulum</a>
                        </div>
                    </div>

                    <section id="kurikulum" class="space-y-4 scroll-mt-24">
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Kurikulum</p>
                                <h2 class="text-2xl font-black" style="font-family:var(--font-heading); color:var(--text-h);">Struktur modul yang bisa Anda ikuti</h2>
                            </div>
                            <p class="text-sm text-slate-500">{{ $course['stats']['lesson_count'] }} pelajaran · {{ $course['stats']['duration_label'] }}</p>
                        </div>

                        <div class="space-y-4">
                            @foreach($course['sections'] as $section)
                                <details class="accordion-item glass-card rounded-3xl overflow-hidden border border-white/10" @if($loop->first) open @endif>
                                    <summary class="cursor-pointer list-none px-6 py-5 flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <span class="w-11 h-11 rounded-2xl flex items-center justify-center text-sm font-black text-white flex-shrink-0" style="background:{{ $course['gradient'] }};">{{ $loop->iteration }}</span>
                                            <div class="min-w-0">
                                                <h3 class="font-bold text-lg truncate" style="color:var(--text-h);">{{ $section['title'] }}</h3>
                                                <p class="text-sm text-slate-500">{{ $section['lesson_count'] }} pelajaran · {{ $section['section_duration_label'] }}</p>
                                            </div>
                                        </div>
                                        <svg class="accordion-chevron w-5 h-5 text-slate-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>

                                    <div class="border-t border-white/08">
                                        @foreach($section['lessons'] as $lesson)
                                            <div class="flex items-center gap-4 px-6 py-4 border-t border-white/06 first:border-t-0 hover:bg-white/30 transition-colors">
                                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0" style="background:rgba(12,119,121,0.11);">
                                                    <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$lesson['type_icon']] }}"/>
                                                    </svg>
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <p class="text-sm sm:text-base font-semibold truncate" style="color:var(--text-h);">{{ $lesson['title'] }}</p>
                                                        @if($lesson['completed'])
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold text-emerald-700 bg-emerald-500/15 border border-emerald-500/20">
                                                                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7"/></svg>
                                                                Selesai
                                                            </span>
                                                        @elseif($lesson['is_preview'])
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold text-teal-700 bg-teal-500/15 border border-teal-500/20">Preview</span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold text-slate-500 bg-white/60 border border-white/20">
                                                                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 9V7a5 5 0 1110 0v2m-5 4v2m-5 2h10a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                                                                Terkunci
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ $lesson['type_label'] }} · {{ $section['title'] }}</p>
                                                </div>

                                                <div class="flex items-center gap-2 flex-shrink-0 text-xs text-slate-500">
                                                    <span>{{ $lesson['duration'] }}</span>
                                                    @if($lesson['locked'])
                                                        <svg class="w-4 h-4 text-slate-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 9V7a5 5 0 1110 0v2m-5 4v2m-5 2h10a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </section>

                    <section id="cohort" class="glass-card rounded-3xl p-8 border border-white/10">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                            <div class="max-w-2xl">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Cohort</p>
                                <h2 class="text-2xl font-black mb-3" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['cohort']['name'] }}</h2>
                                <p class="text-slate-300 leading-relaxed">Gabung bersama peserta lain dalam jadwal terstruktur, dengan sesi tanya jawab dan arahan belajar yang jelas setiap minggu.</p>
                                <div class="mt-5 grid sm:grid-cols-3 gap-3">
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Mulai</p>
                                        <p class="font-bold" style="color:var(--text-h);">{{ $course['cohort']['starts_at'] }}</p>
                                    </div>
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Slot tersisa</p>
                                        <p class="font-bold" style="color:var(--text-h);">{{ $course['cohort']['slots_remaining'] }} tempat</p>
                                    </div>
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Jadwal</p>
                                        <p class="font-bold" style="color:var(--text-h);">{{ $course['cohort']['schedule'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:w-72 rounded-3xl p-5 border border-teal-500/20 bg-teal-500/10">
                                <p class="text-sm font-semibold mb-2" style="color:var(--text-h);">Bergabung dengan kohor</p>
                                <p class="text-sm text-slate-500 mb-4">{{ $course['cohort']['format'] }}</p>
                                <a href="{{ $course['cta']['href'] }}" class="btn-gradient inline-flex items-center justify-center w-full px-4 py-3 rounded-2xl text-white font-semibold">
                                    Bergabung Kohor {{ $course['cohort']['name'] }}
                                </a>
                            </div>
                        </div>
                    </section>

                    <section class="glass-card rounded-3xl p-8 border border-white/10">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Instruktur</p>
                        <div class="grid lg:grid-cols-[minmax(0,1fr)_280px] gap-6">
                            <div>
                                <h2 class="text-2xl font-black mb-3" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['instructor_profile']['name'] }}</h2>
                                <p class="text-slate-300 leading-relaxed mb-5">{{ $course['instructor_profile']['bio'] }}</p>

                                <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500 mb-3">Kredensial</h3>
                                <ul class="space-y-3">
                                    @foreach($course['instructor_profile']['credentials'] as $credential)
                                        <li class="flex items-start gap-3 text-slate-300 text-sm">
                                            <span class="w-2 h-2 rounded-full mt-2 flex-shrink-0" style="background:{{ $course['gradient_from'] }};"></span>
                                            <span>{{ $credential }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="rounded-3xl p-5 bg-white/55 border border-white/20">
                                <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500 mb-4">Kursus lain dari instruktur</h3>
                                <div class="space-y-3">
                                    @foreach($course['related_courses'] as $related)
                                        <a href="{{ $related['url'] }}" class="flex items-center justify-between gap-3 rounded-2xl px-4 py-3 bg-white/70 border border-white/20 hover:border-teal-500/30 transition-colors">
                                            <span class="text-sm font-semibold" style="color:var(--text-h);">{{ $related['title'] }}</span>
                                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="glass-card rounded-3xl p-8 border border-white/10">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Ulasan</p>
                        <h2 class="text-2xl font-black mb-3" style="font-family:var(--font-heading); color:var(--text-h);">Review peserta</h2>
                        <div class="rounded-3xl p-6 border border-dashed border-white/20 bg-white/50">
                            <p class="font-semibold mb-2" style="color:var(--text-h);">{{ $course['review_placeholder']['headline'] }}</p>
                            <p class="text-slate-300 leading-relaxed">{{ $course['review_placeholder']['body'] }}</p>
                        </div>
                    </section>
                </div>

                <aside class="hidden lg:block lg:sticky lg:top-24">
                    <div class="glass-card rounded-3xl overflow-hidden border border-white/10 shadow-xl">
                        <div class="p-5" style="background:{{ $course['gradient'] }};">
                            <div class="rounded-2xl bg-white/12 border border-white/15 p-5">
                                <div class="flex items-center justify-between gap-4 mb-5">
                                    <div>
                                        <p class="text-white/80 text-xs uppercase tracking-[0.18em] mb-2">Course preview</p>
                                        <p class="text-white text-lg font-black leading-tight">{{ $course['title'] }}</p>
                                    </div>
                                    <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center text-white">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$course['icon']] }}"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="rounded-2xl overflow-hidden border border-white/20 bg-white/10 p-4">
                                    <div class="h-40 rounded-2xl flex flex-col justify-end p-4" style="background:linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.02)), {{ $course['gradient'] }};">
                                        <p class="text-white/80 text-xs uppercase tracking-[0.18em] mb-1">Thumbnail</p>
                                        <p class="text-white text-xl font-black">{{ $course['title'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-5">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Harga</p>
                                <p class="text-3xl font-black" style="color:var(--text-h);">{{ $course['price_label'] }}</p>
                            </div>

                            <a href="{{ $course['cta']['href'] }}" class="btn-gradient block w-full px-5 py-3.5 rounded-2xl text-white font-semibold text-center text-base mb-4">
                                {{ $course['cta']['label'] }}
                            </a>

                            <div class="space-y-3 mb-5">
                                @foreach($course['included_items'] as $item)
                                    <div class="flex items-start gap-3 rounded-2xl px-4 py-3 bg-white/60 border border-white/20">
                                        <div class="w-8 h-8 rounded-full bg-teal-500/15 flex items-center justify-center flex-shrink-0 text-teal-700">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold" style="color:var(--text-h);">{{ $item['label'] }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $item['detail'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-slate-500">Modul</span>
                                    <span class="font-semibold" style="color:var(--text-h);">{{ $course['stats']['lesson_count'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm mb-2">
                                    <span class="text-slate-500">Preview gratis</span>
                                    <span class="font-semibold" style="color:var(--text-h);">{{ $course['free_lessons_count'] }} pelajaran</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Kohor berikutnya</span>
                                    <span class="font-semibold" style="color:var(--text-h);">{{ $course['cohort']['starts_at'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="lg:hidden mt-10 glass-card rounded-3xl border border-white/10 p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Harga</p>
                        <p class="text-3xl font-black" style="color:var(--text-h);">{{ $course['price_label'] }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white" style="background:{{ $course['gradient'] }};">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$course['icon']] }}"/>
                        </svg>
                    </div>
                </div>

                <a href="{{ $course['cta']['href'] }}" class="btn-gradient block w-full px-5 py-3.5 rounded-2xl text-white font-semibold text-center text-base mb-4">{{ $course['cta']['label'] }}</a>

                <div class="grid grid-cols-2 gap-3">
                    @foreach($course['included_items'] as $item)
                        <div class="rounded-2xl px-4 py-3 bg-white/60 border border-white/20">
                            <p class="text-sm font-semibold" style="color:var(--text-h);">{{ $item['label'] }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $item['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('head')
<style>
summary::-webkit-details-marker { display: none; }
.accordion-chevron { transition: transform 0.2s ease; }
.accordion-item[open] .accordion-chevron { transform: rotate(180deg); }
</style>
<script type="application/ld+json">{!! json_encode($course['course_schema'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
