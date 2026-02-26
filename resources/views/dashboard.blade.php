<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    {{-- Stats row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($stats as $stat)
        <div class="glass-card rounded-2xl p-5 flex flex-col gap-3 border border-white/08">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,rgba(12,119,121,0.2),rgba(94,206,208,0.2));border:1px solid rgba(12,119,121,0.25);">
                <svg class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white font-mono leading-none" style="background:linear-gradient(135deg,#60A5FA,#A78BFA);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $stat['value'] }}</p>
                <p class="text-slate-400 text-xs mt-1">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Enrolled courses --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold" style="font-family:var(--font-heading); color:var(--text-h);">Kursus Saya</h2>
            <a href="{{ route('courses.index') }}" class="text-teal-400 text-sm hover:text-teal-300 transition-colors">Jelajahi kursus lain →</a>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
            @foreach($enrolled as $e)
            @php $c = $e['course']; @endphp
            <div class="glass-card rounded-2xl p-5 border border-white/08 hover:border-teal-500/20 transition-all group">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $c['gradient'] }};">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$c['icon']] }}"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-base leading-tight mb-1 group-hover:text-teal-300 transition-colors" style="color:var(--text-h);">{{ $c['title'] }}</p>
                        <p class="text-slate-400 text-xs">{{ $c['lessons_count'] }} pelajaran · {{ $c['duration'] }}</p>
                    </div>
                    @php $lm = $levelMap[$c['level_color']]; @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0"
                          style="background:{{ $lm['bg'] }};color:{{ $lm['text'] }};border:1px solid {{ $lm['border'] }};">{{ $c['level'] }}</span>
                </div>
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-slate-400 text-xs">Kemajuan</span>
                        <span class="text-xs font-semibold" style="color:var(--text-h);">{{ $e['progress'] }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-white/08 overflow-hidden">
                        <div class="h-full rounded-full" style="width:{{ $e['progress'] }}%;background:{{ $c['gradient'] }};"></div>
                    </div>
                </div>
                <a href="{{ route('learn.lesson', [$c['slug'], $e['last_lesson']]) }}"
                   class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-all"
                   style="background:{{ $c['gradient'] }};">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Lanjutkan Belajar
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- All courses --}}
    <div>
        <h2 class="text-lg font-bold mb-5" style="font-family:var(--font-heading); color:var(--text-h);">Semua Kursus Tersedia</h2>
        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($courses as $index => $c)
            @php $grads=['linear-gradient(135deg,#0C7779,#095E60)','linear-gradient(135deg,#5ECED0,#3AA8AA)','linear-gradient(135deg,#005461,#0A3D47)','linear-gradient(135deg,#0A6B6D,#0C7779)']; @endphp
            <a href="{{ route('courses.show', $c['slug']) }}"
               class="glass-card rounded-2xl p-4 border border-white/08 hover:border-teal-500/20 transition-all group flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"
                     style="background:{{ $grads[$index%4] }};">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$c['icon']] }}"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate group-hover:text-teal-300 transition-colors" style="color:var(--text-h);">{{ $c['title'] }}</p>
                    <p class="text-slate-500 text-xs">{{ $c['lessons_count'] }} pelajaran</p>
                </div>
                <svg class="w-4 h-4 text-slate-600 group-hover:text-teal-400 flex-shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
