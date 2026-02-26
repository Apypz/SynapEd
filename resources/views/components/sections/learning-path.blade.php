<section id="learning-path" class="relative py-28 overflow-hidden" style="background: linear-gradient(180deg, #0B1120 0%, #0F172A 100%);">
    <div class="absolute inset-0 grid-bg opacity-40"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <!-- Section header -->
        <div class="text-center mb-20">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full border border-teal-500/20 mb-6">
                <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                </svg>
                <span class="text-teal-300 text-sm font-medium">Alur Belajar</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight" style="font-family: var(--font-heading);">
                Mulai Perjalanan
                <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(135deg, #0C7779, #5ECED0);">Belajarmu</span>
                dalam 5 Langkah
            </h2>
        </div>

        @php
        $steps = [
            ['num' => '01', 'title' => 'Daftar', 'desc' => 'Buat akun dan mulai akses seluruh kurikulum dalam hitungan detik.', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'gradient' => 'linear-gradient(135deg, #0C7779, #095E60)'],
            ['num' => '02', 'title' => 'Pilih Materi', 'desc' => 'Jelajahi kurikulum dan pilih modul sesuai level dan minat kamu.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'gradient' => 'linear-gradient(135deg, #5ECED0, #3AA8AA)'],
            ['num' => '03', 'title' => 'Belajar', 'desc' => 'Tonton video, baca modul PDF, dan selesaikan kuis interaktif.', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z', 'gradient' => 'linear-gradient(135deg, #005461, #0A3D47)'],
            ['num' => '04', 'title' => 'Praktik', 'desc' => 'Terapkan ilmu menggunakan dataset EEG nyata dan lab virtual.', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'gradient' => 'linear-gradient(135deg, #0A6B6D, #095E60)'],
            ['num' => '05', 'title' => 'Evaluasi', 'desc' => 'Ikuti ujian akhir modul dan dapatkan sertifikat digital kamu.', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'gradient' => 'linear-gradient(135deg, #3AA8AA, #0C7779)'],
        ];
        @endphp

        <!-- Desktop timeline -->
        <div class="hidden lg:block relative">
            <!-- Connector line -->
            <div class="absolute top-12 left-0 right-0 mx-auto" style="height: 2px; background: linear-gradient(90deg, transparent 0%, #0C7779 20%, #5ECED0 50%, #0C7779 80%, transparent 100%); box-shadow: 0 0 12px rgba(12,119,121,0.4); max-width: 900px; left: 50%; transform: translateX(-50%);"></div>

            <div class="grid grid-cols-5 gap-4 max-w-5xl mx-auto">
                @foreach($steps as $index => $step)
                <div class="flex flex-col items-center text-center group">
                    <!-- Circle -->
                    <div class="relative mb-6 z-10">
                        <div class="absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-lg scale-150"
                             style="background: {{ $step['gradient'] }};"></div>
                        <div class="relative w-24 h-24 rounded-full flex items-center justify-center group-hover:scale-110 transition-all duration-300"
                             style="background: {{ $step['gradient'] }}; box-shadow: 0 4px 20px rgba(12,119,121,0.25);">
                            <svg class="w-8 h-8" style="color:#fff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" />
                            </svg>
                        </div>
                        <!-- Step number badge -->
                        <div class="absolute -top-1 -right-1 w-7 h-7 rounded-full flex items-center justify-center text-xs font-black border-2"
                             style="background: {{ $step['gradient'] }}; color:#fff; border-color: var(--bg-s2);">
                            {{ $index + 1 }}
                        </div>
                    </div>
                    <h3 class="text-white font-bold text-base mb-2 group-hover:text-teal-300 transition-colors">{{ $step['title'] }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile timeline (vertical) -->
        <div class="lg:hidden flex flex-col gap-0 max-w-sm mx-auto">
            @foreach($steps as $index => $step)
            <div class="flex gap-6 group">
                <!-- Left: line + dot -->
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 flex-shrink-0 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300"
                         style="background: {{ $step['gradient'] }};">
                        <svg class="w-5 h-5" style="color:#fff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" />
                        </svg>
                    </div>
                    @if(!$loop->last)
                    <div class="w-0.5 flex-1 my-2 rounded-full" style="background: linear-gradient(180deg, rgba(12,119,121,0.5), rgba(94,206,208,0.5));"></div>
                    @endif
                </div>
                <!-- Right: text -->
                <div class="pt-1 pb-8">
                    <div class="text-slate-500 text-xs font-mono mb-1">LANGKAH {{ $step['num'] }}</div>
                    <h3 class="text-white font-bold text-base mb-1">{{ $step['title'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
