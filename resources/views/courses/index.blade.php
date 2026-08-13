@extends('layouts.public')
@section('title', 'Semua Kursus – SynapEd')

@section('content')
<section class="relative min-h-screen py-32 overflow-hidden" style="background:var(--bg-s1)">
    <div class="absolute inset-0 grid-bg opacity-30 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full border border-blue-500/20 mb-6">
                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths['reading'] }}"/>
                </svg>
                <span class="text-blue-300 text-sm font-medium">Kurikulum Lengkap</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-black leading-tight mb-4" style="font-family:var(--font-heading); color:var(--text-h);">
                Jelajahi <span class="text-transparent bg-clip-text" style="background-image:linear-gradient(135deg,#0C7779,#5ECED0);">Semua Kursus</span>
            </h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">{{ count($courses) }} modul terstruktur dari level dasar hingga analisis lanjutan.</p>
        </div>

        {{-- Category filter --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            @foreach($categories as $cat)
            <button data-filter="{{ $cat['slug'] }}"
                class="course-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border {{ $loop->first ? 'active-filter' : 'glass-card border-white/10 text-slate-300 hover:border-teal-500/40' }}">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>

        {{-- Course grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" id="courses-grid">
            @foreach($courses as $index => $course)
            @php
                $lm = $levelMap[$course['level_color']];
                $gradients = ['linear-gradient(135deg,#0C7779,#095E60)','linear-gradient(135deg,#5ECED0,#3AA8AA)','linear-gradient(135deg,#005461,#0A3D47)','linear-gradient(135deg,#0A6B6D,#0C7779)'];
                $grad = $gradients[$index % 4];
            @endphp
            <div class="glass-card rounded-2xl overflow-hidden border border-white/08 group hover:border-teal-500/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl flex flex-col course-card"
                 data-category="{{ $course['category'] }}">
                {{-- Accent bar --}}
                <div class="h-1 w-full" style="background:{{ $grad }};"></div>

                <div class="p-6 flex flex-col flex-1">
                    {{-- Icon + Level --}}
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background:{{ $grad }};">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$course['icon']] }}"/>
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold"
                              style="background:{{ $lm['bg'] }};color:{{ $lm['text'] }};border:1px solid {{ $lm['border'] }};">
                            {{ $course['level'] }}
                        </span>
                    </div>

                    <div class="text-slate-600 text-xs font-medium mb-1">MODUL {{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}</div>
                    <h3 class="font-bold text-lg mb-3 leading-tight group-hover:text-teal-300 transition-colors" style="color:var(--text-h);">{{ $course['title'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed flex-1 mb-4">{{ $course['short_desc'] }}</p>

                    {{-- Meta --}}
                    <div class="flex items-center gap-3 mb-3 text-slate-500 text-xs">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $course['duration'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.873v6.254a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            {{ $course['lessons_count'] }} Pelajaran
                        </span>
                    </div>

                    {{-- Rating --}}
                    @if(!empty($course['reviews_count']) && $course['reviews_count'] > 0)
                    <div class="flex items-center gap-2 mb-5">
                        <span class="text-yellow-400 font-bold text-sm">{{ $course['rating'] }}</span>
                        <div class="flex gap-0.5">
                            @for($s=1;$s<=5;$s++)<svg class="w-3 h-3 {{ $s <= round($course['rating']) ? 'text-yellow-400' : 'text-slate-600' }}" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 9.101c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>@endfor
                        </div>
                        <span class="text-slate-500 text-xs">({{ $course['reviews_count'] }})</span>
                    </div>
                    @else
                    <div class="mb-5">
                        <span class="text-slate-500 text-xs">Belum ada ulasan</span>
                    </div>
                    @endif

                    {{-- CTA --}}
                    <a href="{{ route('courses.show', $course['slug']) }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90"
                       style="background:{{ $grad }};">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection

@push('head')
<style>
.active-filter { background:linear-gradient(135deg,#0C7779,#5ECED0); color:#fff; border-color:transparent; }
.course-card.hidden-card { display:none; }
</style>
@endpush

@push('scripts')
<script>
(function(){
    const btns=document.querySelectorAll('.course-filter-btn');
    const cards=document.querySelectorAll('.course-card');
    btns.forEach(btn=>{
        btn.addEventListener('click',()=>{
            btns.forEach(b=>{ b.classList.remove('active-filter'); b.classList.add('glass-card','border-white/10','text-slate-300'); });
            btn.classList.add('active-filter'); btn.classList.remove('glass-card','border-white/10','text-slate-300');
            const f=btn.dataset.filter;
            cards.forEach(c=>{ (f==='semua'||c.dataset.category===f)?c.classList.remove('hidden-card'):c.classList.add('hidden-card'); });
        });
    });
})();
</script>
@endpush
