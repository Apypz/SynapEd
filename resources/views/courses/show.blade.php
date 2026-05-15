@extends('layouts.public')
@section('title', $course['seo_title'])

@section('content')
@php
    $levelBadge = $levelMap[$course['level_color']] ?? ['bg' => 'rgba(12,119,121,0.15)', 'text' => '#0C7779', 'border' => 'rgba(12,119,121,0.30)'];
@endphp

<div style="background:var(--bg-page)">
@section('body-class', 'page-light-nav')
@push('head')
<style>
    /* Force navbar appearance for this page before JS runs */
    body.page-light-nav #navbar {
        background: rgba(255, 255, 255, 0.98) !important;
        border-bottom: 1px solid rgba(0,0,0,0.08) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
    }

    body.page-light-nav #logo-white { display: none !important; }
    body.page-light-nav #logo-dark  { display: block !important; }

    body.page-light-nav .public-nav-link { color: #0b0b0b !important; }
    body.page-light-nav .nav-cta-dynamic { color: #0b0b0b !important; }

    /* Make primary CTA prominent blue on this page */
    body.page-light-nav .nav-cta-dynamic:not(.glass-card) {
        background: linear-gradient(135deg, var(--brand-900), var(--brand-800)) !important;
        color: #ffffff !important;
        padding: 8px 14px !important;
        border-radius: 10px !important;
    }

    body.page-light-nav .nav-mobile-btn { color: #0b0b0b !important; border-color: rgba(0,0,0,0.08) !important; }
</style>
@endpush
    <section class="relative overflow-hidden py-14 lg:py-20">
        <div class="absolute inset-0 grid-bg opacity-20 pointer-events-none"></div>
        <div class="absolute inset-x-0 top-0 h-52 bg-gradient-to-b from-blue-500/10 to-transparent pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('courses.index') }}" class="hover:text-blue-400 transition-colors">Kursus</a>
                <span>/</span>
                <span class="text-slate-300">{{ $course['title'] }}</span>
            </nav>

            <div class="grid lg:grid-cols-[minmax(0,1.7fr)_320px] gap-8 lg:gap-10 items-start">
                <div class="space-y-8">
                    <div class="glass-card rounded-3xl p-7 lg:p-9 border border-white/10">
                        <div class="flex flex-wrap items-center gap-2 mb-5">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background:rgb(211, 221, 255);color:blue;border:1px solid {{ $levelBadge['border'] }};">{{ $course['level'] }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/60 text-slate-600 border border-white/20">{{ $course['stats']['lesson_count'] }} pelajaran</span>
                            @if($course['has_free_preview'])
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-blue-700 bg-blue-500/15 border border-teal-500/25">Preview gratis</span>
                            @endif
                        </div>

                        <div class="grid gap-6 items-start">
                            <div>
                                <h1 class="text-4xl sm:text-5xl font-black leading-tight mb-4" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['title'] }}</h1>
                                <p class="text-lg leading-relaxed text-slate-300 max-w-2xl">{{ $course['hero_blurb'] }}</p>

                                <div class="flex items-center gap-4 mt-6 p-4 rounded-2xl bg-white/55 border border-white/20 max-w-xl">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-black text-lg flex-shrink-0" style="background:{{ $course['gradient'] }};">{{ $course['instructor_avatar'] }}</div>
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-1">Instruktur</p>
                                        <p class="font-bold" style="color:var(--text-h);">{{ $course['instructor_profile']['name'] }}</p>
                                        <p class="text-sm text-slate-400">{{ $course['instructor_profile']['role'] }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3 mt-6">
                                    <a href="{{ $course['cta']['href'] }}" class="btn-gradient inline-flex items-center justify-center px-6 py-3 rounded-2xl text-white font-semibold">
                                        {{ $course['cta']['label'] }}
                                    </a>
                                    <a href="#kurikulum" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl border border-white/10 glass-card font-semibold text-slate-300 hover:border-teal-500/30 transition-colors">Lihat Kurikulum</a>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-7">
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Durasi</p>
                                        <p class="font-black" style="color:var(--text-h);">{{ $course['stats']['duration_label'] }}</p>
                                    </div>
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Pelajaran</p>
                                        <p class="font-black" style="color:var(--text-h);">{{ $course['stats']['lesson_count'] }}</p>
                                    </div>
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Peserta</p>
                                        <p class="font-black" style="color:var(--text-h);">{{ $course['stats']['enrolled_students'] }}</p>
                                    </div>
                                    <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                        <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Diperbarui</p>
                                        <p class="font-semibold" style="color:var(--text-h);">{{ $course['stats']['last_updated'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section id="kurikulum" class="scroll-mt-24 space-y-4">
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Kurikulum</p>
                                <h2 class="text-2xl font-black" style="font-family:var(--font-heading); color:var(--text-h);">Struktur modul</h2>
                            </div>
                            <p class="text-sm text-slate-500">{{ $course['stats']['lesson_count'] }} pelajaran · {{ $course['stats']['duration_label'] }}</p>
                        </div>

                        <div class="space-y-3">
                            @foreach($course['sections'] as $section)
                                <details class="accordion-item rounded-3xl border border-white/10 bg-white/70 overflow-hidden" @if($loop->first) open @endif>
                                    <summary class="cursor-pointer list-none px-5 sm:px-6 py-4 flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <span class="w-10 h-10 rounded-2xl flex items-center justify-center text-sm font-black text-white flex-shrink-0" style="background:{{ $course['gradient'] }};">{{ $loop->iteration }}</span>
                                            <div class="min-w-0">
                                                <h3 class="font-bold text-base sm:text-lg truncate" style="color:var(--text-h);">{{ $section['title'] }}</h3>
                                                <p class="text-sm text-slate-500">{{ $section['lesson_count'] }} pelajaran · {{ $section['section_duration_label'] }}</p>
                                            </div>
                                        </div>
                                        <svg class="accordion-chevron w-5 h-5 text-slate-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </summary>

                                    <div class="border-t border-white/08 divide-y divide-white/08">
                                        @foreach($section['lessons'] as $lesson)
                                            <div class="flex items-center gap-4 px-5 sm:px-6 py-4">
                                                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(12,119,121,0.10);">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$lesson['type_icon']] }}"/></svg>
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <p class="font-semibold truncate" style="color:var(--text-h);">{{ $lesson['title'] }}</p>
                                                        @if($lesson['completed'])
                                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold text-blue-700 bg-blue-500/15 border border-emerald-500/20">Selesai</span>
                                                        @elseif($lesson['is_preview'])
                                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold text-blue-700 bg-blue-500/15 border border-teal-500/20">Preview</span>
                                                        @else
                                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold text-slate-500 bg-white/60 border border-white/20">Terkunci</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-xs text-slate-500 mt-1">{{ $lesson['type_label'] }} · {{ $lesson['duration'] }}</p>
                                                </div>

                                                <div class="flex items-center gap-2 flex-shrink-0 text-xs text-slate-500">
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

                    <section id="cohort" class="rounded-3xl bg-white/70 border border-white/10 p-6 sm:p-7">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                            <div class="max-w-2xl">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Jadwal Kelas</p>
                                <h2 class="text-2xl font-black mb-2" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['cohort']['name'] }}</h2>
                                <p class="text-slate-300 leading-relaxed">Jadwal terstruktur dengan slot yang masih tersedia. Cocok jika Anda ingin belajar dengan ritme yang jelas.</p>
                            </div>
                            <a href="{{ auth()->check() ? $course['cta']['href'] : route('login') }}" class="btn-gradient inline-flex items-center justify-center px-5 py-3 rounded-2xl text-white font-semibold whitespace-nowrap">
                                Bergabung Kelas {{ $course['cohort']['name'] }}
                            </a>
                        </div>

                        <div class="grid sm:grid-cols-3 gap-3 mt-5">
                            <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Mulai</p>
                                <p class="font-semibold" style="color:var(--text-h);">{{ $course['cohort']['starts_at'] }}</p>
                            </div>
                            <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Slot tersisa</p>
                                <p class="font-semibold" style="color:var(--text-h);">{{ $course['cohort']['slots_remaining'] }} tempat</p>
                            </div>
                            <div class="rounded-2xl p-4 bg-white/55 border border-white/20">
                                <p class="text-xs uppercase tracking-[0.16em] text-slate-500 mb-1">Jadwal</p>
                                <p class="font-semibold" style="color:var(--text-h);">{{ $course['cohort']['schedule'] }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl bg-white/70 border border-white/10 p-6 sm:p-7">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Instruktur</p>
                        <div class="grid lg:grid-cols-[minmax(0,1fr)_260px] gap-6">
                            <div>
                                <h2 class="text-2xl font-black mb-3" style="font-family:var(--font-heading); color:var(--text-h);">{{ $course['instructor_profile']['name'] }}</h2>
                                <p class="text-slate-300 leading-relaxed mb-5">{{ $course['instructor_profile']['bio'] }}</p>
                                <div class="space-y-3">
                                    @foreach($course['instructor_profile']['credentials'] as $credential)
                                        <div class="flex items-start gap-3 text-sm text-slate-300">
                                            <span class="mt-1 w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $course['gradient_from'] }};"></span>
                                            <span>{{ $credential }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-2xl p-5 bg-white/55 border border-white/20">
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-3">Kursus lain</p>
                                <div class="space-y-2">
                                    @foreach($course['related_courses'] as $related)
                                        <a href="{{ $related['url'] }}" class="flex items-center justify-between gap-3 rounded-xl px-4 py-3 bg-white/70 border border-white/20 hover:border-teal-500/30 transition-colors">
                                            <span class="text-sm font-semibold" style="color:var(--text-h);">{{ $related['title'] }}</span>
                                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-3xl bg-white/70 border border-dashed border-white/20 p-6 sm:p-7">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Ulasan</p>
                        <h2 class="text-2xl font-black mb-2" style="font-family:var(--font-heading); color:var(--text-h);">Review peserta</h2>
                        <p class="text-slate-300 leading-relaxed">{{ $course['review_placeholder']['headline'] }} {{ $course['review_placeholder']['body'] }}</p>
                    </section>
                </div>

                <aside class="hidden lg:block lg:sticky lg:top-24">
                    <div class="rounded-3xl bg-white/75 border border-white/15 overflow-hidden shadow-lg">
                        <div class="p-4 bg-white/70">
                            <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-3">Course preview</p>
                            <div class="rounded-2xl overflow-hidden border border-white/20 bg-white">
                                <img
                                    src="{{ asset($course['thumbnail']) }}"
                                    alt="Thumbnail kursus {{ $course['title'] }}"
                                    class="w-full aspect-[4/3] object-contain p-6"
                                >
                            </div>
                        </div>

                        <div class="p-5 space-y-5">
                            <div>
                                <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-2">Harga</p>
                                <p class="text-3xl font-black" style="color:blue">{{ $course['price_label'] }}</p>
                            </div>

                            <a href="{{ $course['cta']['href'] }}" class="btn-gradient block w-full px-5 py-3.5 rounded-2xl text-white font-semibold text-center">
                                {{ $course['cta']['label'] }}
                            </a>

                            <div class="space-y-3">
                                @foreach($course['included_items'] as $item)
                                    <div class="flex items-start gap-3 rounded-2xl px-4 py-3 bg-white/65 border border-white/20">
                                        <div class="w-8 h-8 rounded-full bg-blue-500/15 flex items-center justify-center flex-shrink-0 text-blue-700">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold" style="color:rgb(31, 31, 165)">{{ $item['label'] }}</p>
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
                                    <span class="text-slate-500">Jadwal berikutnya</span>
                                    <span class="font-semibold" style="color:var(--text-h);">{{ $course['cohort']['starts_at'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="lg:hidden mt-8 rounded-3xl bg-white/75 border border-white/15 p-5">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500 mb-1">Harga</p>
                        <p class="text-2xl font-black" style="color:var(--text-h);">{{ $course['price_label'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white" style="background:{{ $course['gradient'] }};">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$course['icon']] }}"/></svg>
                    </div>
                </div>
                <a href="{{ $course['cta']['href'] }}" class="btn-gradient block w-full px-5 py-3.5 rounded-2xl text-white font-semibold text-center mb-4">{{ $course['cta']['label'] }}</a>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($course['included_items'] as $item)
                        <div class="rounded-2xl px-4 py-3 bg-white/65 border border-white/20">
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
