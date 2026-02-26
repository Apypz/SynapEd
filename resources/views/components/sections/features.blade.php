<section id="features" class="relative py-28 overflow-hidden" style="background: linear-gradient(180deg, #0F172A 0%, #0B1120 100%);">
    <div class="absolute inset-0 grid-bg opacity-40"></div>

    <!-- Right side glow -->
    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full opacity-15 pointer-events-none" style="background: radial-gradient(ellipse at center, #5ECED0, transparent 70%); filter: blur(60px);"></div>

    <div class="relative max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Text -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full border border-teal-500/20 mb-6">
                    <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-teal-300 text-sm font-medium">Mengapa NeuroAcademy</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white leading-tight mb-6" style="font-family: var(--font-heading);">
                    Keunggulan yang Membuat
                    <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(135deg, #0C7779, #5ECED0);">Belajar Lebih Efektif</span>
                </h2>
                <p class="text-slate-400 text-base leading-relaxed mb-10">
                    NeuroAcademy dirancang dengan standar platform edukasi modern — aksesibel, terstruktur, dan berbasis praktik nyata tanpa hambatan biaya.
                </p>

                <!-- Feature checklist -->
                <div class="flex flex-col gap-5">
                    @php
                    $features = [
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Kurikulum Terverifikasi', 'desc' => 'Materi dikurasi dan diverifikasi oleh praktisi neuroscience dan teknologi EEG berpengalaman.', 'color' => '#10B981'],
                        ['icon' => 'M15 10l4.553-2.069A1 1 0 0121 8.873v6.254a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'title' => 'Video Berkualitas Tinggi', 'desc' => 'Video rekaman & animasi terstruktur yang mudah dipahami untuk setiap topik.', 'color' => '#0C7779'],
                        ['icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Modul PDF Lengkap', 'desc' => 'Setiap modul dilengkapi ringkasan PDF yang dapat diunduh untuk belajar offline.', 'color' => '#5ECED0'],
                        ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'Eksperimen Praktis', 'desc' => 'Dataset nyata dan panduan eksperimen untuk melatih skill analisis EEG secara langsung.', 'color' => '#005461'],
                        ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2a2 2 0 002 2zM8 9h8m-4-6v6', 'title' => 'Responsive di Semua Perangkat', 'desc' => 'Akses dari laptop, tablet, atau smartphone. Belajar kapan saja dan di mana saja.', 'color' => '#F59E0B'],
                    ];
                    @endphp

                    @foreach($features as $feature)
                    <div class="flex items-start gap-4 group">
                        <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center glass-card border border-white/10 group-hover:border-opacity-50 transition-all duration-200"
                             style="border-color: {{ $feature['color'] }}33;">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                                 style="color: {{ $feature['color'] }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-semibold text-base mb-1">{{ $feature['title'] }}</div>
                            <div class="text-slate-400 text-sm leading-relaxed">{{ $feature['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Visual card -->
            <div class="relative flex justify-center lg:justify-end">
                <div class="relative w-full max-w-sm">
                    <!-- Outer glow -->
                    <div class="absolute inset-0 rounded-3xl opacity-30 blur-2xl" style="background: linear-gradient(135deg, #5ECED0, #0C7779);"></div>

                    <div class="relative glass-card rounded-3xl p-7 border border-white/10">
                        <div class="mb-6">
                            <div class="text-slate-400 text-xs font-medium uppercase tracking-widest mb-3">Progress Belajar</div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white text-sm font-semibold">Dasar Neuroscience</span>
                                <span class="text-teal-400 text-sm font-semibold">85%</span>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.08);">
                                <div class="h-full rounded-full btn-gradient" style="width: 85%;"></div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white text-sm font-semibold">Pengenalan EEG</span>
                                <span class="text-violet-400 text-sm font-semibold">60%</span>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.08);">
                                <div class="h-full rounded-full" style="width: 60%; background: linear-gradient(135deg, #5ECED0, #3AA8AA);"></div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-white text-sm font-semibold">Implementasi Muse</span>
                                <span class="text-cyan-400 text-sm font-semibold">30%</span>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.08);">
                                <div class="h-full rounded-full" style="width: 30%; background: linear-gradient(135deg, #005461, #0A3D47);"></div>
                            </div>
                        </div>

                        <hr class="border-white/08 my-6" />

                        <!-- Stats row -->
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-black text-white">28</div>
                                <div class="text-slate-500 text-xs mt-1">Pelajaran Selesai</div>
                            </div>
                            <div>
                                <div class="text-2xl font-black text-white">14h</div>
                                <div class="text-slate-500 text-xs mt-1">Waktu Belajar</div>
                            </div>
                            <div>
                                <div class="text-2xl font-black" style="color: #F59E0B;">🔥</div>
                                <div class="text-slate-500 text-xs mt-1">7 Hari Streak</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
