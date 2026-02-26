<section id="courses" class="relative py-28 overflow-hidden" style="background: linear-gradient(180deg, #0B1120 0%, #0F172A 60%, #0B1120 100%);">
    <div class="absolute inset-0 grid-bg opacity-40"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <!-- Section header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full border border-teal-500/20 mb-6">
                <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-teal-300 text-sm font-medium">Kurikulum Lengkap</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight" style="font-family: var(--font-heading);">
                Materi
                <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(135deg, #0C7779, #5ECED0);">Pembelajaran</span>
            </h2>
            <p class="text-slate-400 text-lg mt-4 max-w-2xl mx-auto">4 modul terstruktur dari level dasar hingga analisis lanjutan, dirancang untuk pengalaman belajar yang optimal.</p>
        </div>

        <!-- Category filter tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            @foreach($courseCategories as $cat)
            <button
                data-filter="{{ $cat['slug'] }}"
                class="course-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border {{ $loop->first ? 'active-filter' : 'glass-card border-white/10 text-slate-300 hover:border-teal-500/40' }}">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>

        <!-- Course cards grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" id="courses-grid">

            @php
            $iconMap = [
                'brain'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
                'wave'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />',
                'headset' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />',
                'chart'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
            ];
            $levelColorMap = [
                'green'  => ['bg' => 'rgba(16,185,129,0.15)', 'text' => '#10B981', 'border' => 'rgba(16,185,129,0.3)'],
                'yellow' => ['bg' => 'rgba(245,158,11,0.15)', 'text' => '#F59E0B', 'border' => 'rgba(245,158,11,0.3)'],
                'red'    => ['bg' => 'rgba(239,68,68,0.15)',  'text' => '#EF4444', 'border' => 'rgba(239,68,68,0.3)'],
            ];
            $cardGradients = [
                'linear-gradient(135deg, #0C7779, #095E60)',
                'linear-gradient(135deg, #5ECED0, #3AA8AA)',
                'linear-gradient(135deg, #005461, #0A3D47)',
                'linear-gradient(135deg, #0A6B6D, #095E60)',
            ];
            @endphp

            @foreach($courses as $index => $course)
            @php
                $iconSvg   = $iconMap[$course['icon']] ?? $iconMap['brain'];
                $levelMeta = $levelColorMap[$course['level_color']] ?? $levelColorMap['green'];
                $gradient  = $cardGradients[$index % count($cardGradients)];
            @endphp
            <div class="glass-card rounded-2xl overflow-hidden border border-white/08 group hover:border-teal-500/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl flex flex-col course-card"
                 data-category="{{ $course['category'] }}">

                <!-- Card top accent bar -->
                <div class="h-1 w-full" style="background: {{ $gradient }};"></div>

                <div class="p-6 flex flex-col flex-1">
                    <!-- Icon + Level badge -->
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300"
                             style="background: {{ $gradient }};">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                {!! $iconSvg !!}
                            </svg>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold"
                              style="background: {{ $levelMeta['bg'] }}; color: {{ $levelMeta['text'] }}; border: 1px solid {{ $levelMeta['border'] }};">
                            {{ $course['level'] }}
                        </span>
                    </div>

                    <!-- Course number -->
                    <div class="text-slate-600 text-xs font-medium mb-1">MODUL {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    <!-- Title -->
                    <h3 class="text-white font-bold text-lg mb-3 leading-tight group-hover:text-teal-300 transition-colors duration-200">
                        {{ $course['title'] }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-400 text-sm leading-relaxed flex-1 mb-5">
                        {{ $course['short_desc'] }}
                    </p>

                    <!-- Meta info -->
                    <div class="flex items-center gap-4 mb-3 text-slate-500 text-xs">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ $course['lessons_count'] }} Pelajaran
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $course['duration'] }}
                        </span>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mb-5">
                        <span class="text-yellow-400 font-bold text-sm">{{ $course['rating'] }}</span>
                        <div class="flex gap-0.5">
                            @for($s = 1; $s <= 5; $s++)
                            <svg class="w-3 h-3 {{ $s <= round($course['rating']) ? 'text-yellow-400' : 'text-slate-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 9.101c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-slate-500 text-xs">({{ $course['reviews'] }})</span>
                    </div>

                    <!-- CTA -->
                    <a href="#"
                       class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90"
                       style="background: {{ $gradient }};">
                        Pelajari
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

@push('head')
<style>
    .active-filter {
        background: linear-gradient(135deg, #0C7779, #5ECED0);
        color: #fff;
        border-color: transparent;
    }
    .course-card.hidden-card {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const btns  = document.querySelectorAll('.course-filter-btn');
    const cards = document.querySelectorAll('.course-card');

    btns.forEach(btn => {
        btn.addEventListener('click', () => {
            btns.forEach(b => {
                b.classList.remove('active-filter');
                b.classList.add('glass-card', 'border-white/10', 'text-slate-300');
            });
            btn.classList.add('active-filter');
            btn.classList.remove('glass-card', 'border-white/10', 'text-slate-300');

            const filter = btn.dataset.filter;
            cards.forEach(card => {
                if (filter === 'semua' || card.dataset.category === filter) {
                    card.classList.remove('hidden-card');
                } else {
                    card.classList.add('hidden-card');
                }
            });
        });
    });
})();
</script>
@endpush