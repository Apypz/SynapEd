<section id="hero" class="relative min-h-screen flex items-center overflow-hidden bg-gradient-hero grid-bg pt-24">

    <!-- Glowing background blobs -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 blob-gradient rounded-full opacity-60 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/3 w-64 h-64 blob-gradient rounded-full opacity-40" style="background: radial-gradient(ellipse at center, rgba(12,119,121,0.35) 0%, transparent 70%);"></div>
        <div class="absolute top-1/3 left-1/4 w-48 h-48 rounded-full opacity-20" style="background: radial-gradient(ellipse at center, rgba(94,206,208,0.4) 0%, transparent 70%); filter: blur(30px);"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-24 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Text Content -->
            <div class="flex flex-col gap-8">

                <!-- Headline -->
                <div class="flex flex-col gap-4">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight text-white"
                        style="font-family: var(--font-heading);">
                        Belajar Neuroscience &amp; EEG
                        <span class="block text-transparent bg-clip-text glow-text"
                              style="background-image: linear-gradient(135deg, #0C7779, #5ECED0);">
                            Secara Praktis &amp; Terstruktur
                        </span>
                    </h1>
                    <p class="text-lg text-slate-300 leading-relaxed max-w-xl">
                        Platform pembelajaran untuk memahami sinyal listrik otak, neuron, dan implementasi EEG dalam dunia teknologi modern. Tersedia untuk pelajar SMA, SMK, mahasiswa, dan umum.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="#courses"
                       class="inline-flex items-center gap-2 px-8 py-4 text-white font-bold text-base rounded-2xl btn-gradient glow-blue shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Mulai Belajar
                    </a>
                    <a href="#courses"
                       class="inline-flex items-center gap-2 px-8 py-4 font-bold text-base rounded-2xl glass-card text-white border border-teal-500/30 hover:border-teal-400/60 transition-all duration-200 hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Lihat Kurikulum
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap gap-8 pt-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-black text-white">4+</span>
                        <span class="text-sm text-slate-400">Modul Pembelajaran</span>
                    </div>
                    <div class="w-px bg-white/10 self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-black text-white">50+</span>
                        <span class="text-sm text-slate-400">Video & Materi</span>
                    </div>
                    <div class="w-px bg-white/10 self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-black text-white">100%</span>
                        <span class="text-sm text-slate-400">Terstruktur</span>
                    </div>
                </div>
            </div>

            <!-- Right: Visual / Illustration -->
            <div class="relative flex items-center justify-center lg:justify-end">
                <!-- Main abstract card -->
                <div class="relative w-full max-w-md">
                    <!-- Outer glow ring -->
                    <div class="absolute inset-0 rounded-3xl opacity-40 blur-2xl" style="background: linear-gradient(135deg, #0C7779, #5ECED0);"></div>

                    <!-- Main panel -->
                    <div class="relative glass-card rounded-3xl p-8 border border-white/10 shadow-2xl">
                        <!-- Header row -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl btn-gradient flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold text-sm">EEG Signal Monitor</div>
                                    <div class="text-slate-400 text-xs">Live brainwave data</div>
                                </div>
                            </div>
                            <span class="flex items-center gap-1.5 text-xs text-green-400 font-medium">
                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Live
                            </span>
                        </div>

                        <!-- EEG Wave SVG -->
                        <div class="rounded-2xl p-4 mb-6" style="background: rgba(12,119,121,0.08); border: 1px solid rgba(12,119,121,0.15);">
                            <svg viewBox="0 0 320 80" class="w-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Alpha wave -->
                                <path d="M0,40 C10,40 15,15 25,15 S40,65 50,65 S65,10 75,10 S90,70 100,70 S115,20 125,20 S140,60 150,60 S165,15 175,15 S190,65 200,65 S215,10 225,10 S240,70 250,70 S265,20 275,20 S290,60 300,60 S315,40 320,40"
                                      stroke="#0C7779" stroke-width="2" stroke-linecap="round" opacity="0.9">
                                    <animate attributeName="d"
                                        values="
                                        M0,40 C10,40 15,15 25,15 S40,65 50,65 S65,10 75,10 S90,70 100,70 S115,20 125,20 S140,60 150,60 S165,15 175,15 S190,65 200,65 S215,10 225,10 S240,70 250,70 S265,20 275,20 S290,60 300,60 S315,40 320,40;
                                        M0,40 C10,40 15,65 25,65 S40,10 50,10 S65,70 75,70 S90,15 100,15 S115,65 125,65 S140,10 150,10 S165,60 175,60 S190,15 200,15 S215,65 225,65 S240,10 250,10 S265,65 275,65 S290,15 300,15 S315,40 320,40;
                                        M0,40 C10,40 15,15 25,15 S40,65 50,65 S65,10 75,10 S90,70 100,70 S115,20 125,20 S140,60 150,60 S165,15 175,15 S190,65 200,65 S215,10 225,10 S240,70 250,70 S265,20 275,20 S290,60 300,60 S315,40 320,40"
                                        dur="3s" repeatCount="indefinite" />
                                </path>
                                <!-- Beta wave (lighter) -->
                                <path d="M0,40 C5,38 8,30 12,30 S18,50 22,50 S28,28 32,28 S38,52 42,52 S48,32 52,32 S58,48 62,48 S70,40 80,40"
                                      stroke="#5ECED0" stroke-width="1.5" stroke-linecap="round" opacity="0.6">
                                    <animateTransform attributeName="transform" type="translate" values="0,0; 240,0; 0,0" dur="3s" repeatCount="indefinite" />
                                </path>
                            </svg>
                        </div>

                        <!-- Brainwave stats row -->
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([['Alpha', '8-12 Hz', '#0C7779'], ['Beta', '13-30 Hz', '#5ECED0'], ['Theta', '4-8 Hz', '#5ECED0']] as $wave)
                            <div class="rounded-xl p-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);">
                                <div class="w-2 h-2 rounded-full mx-auto mb-2" style="background: {{ $wave[2] }};"></div>
                                <div class="text-white text-xs font-semibold">{{ $wave[0] }}</div>
                                <div class="text-slate-500 text-xs">{{ $wave[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Floating badge 1 -->
                    <div class="absolute -top-5 -left-5 glass-card rounded-2xl px-4 py-2.5 border border-white/10 shadow-xl">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🧠</span>
                            <div>
                                <div class="text-white text-xs font-semibold">Neuroscience</div>
                                <div class="text-slate-400 text-xs">Modul Dasar</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badge 2 -->
                    <div class="absolute -bottom-5 -right-5 glass-card rounded-2xl px-4 py-2.5 border border-white/10 shadow-xl">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full btn-gradient flex items-center justify-center">
                                <span class="text-sm">✓</span>
                            </div>
                            <div>
                                <div class="text-white text-xs font-semibold">Akses Penuh</div>
                                <div class="text-slate-400 text-xs">Semua modul</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 animate-bounce">
        <span class="text-slate-400 text-xs">Scroll</span>
        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>
