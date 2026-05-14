<section id="hero" class="relative min-h-screen flex items-center bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 pt-20 overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-400 rounded-full opacity-20 blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-500 rounded-full opacity-20 blur-[100px]"></div>

        <div class="absolute top-20 right-10 opacity-20">
            <svg width="120" height="120" fill="currentColor" class="text-blue-200">
                <circle cx="2" cy="2" r="2"/><circle cx="22" cy="2" r="2"/><circle cx="42" cy="2" r="2"/><circle cx="62" cy="2" r="2"/>
                <circle cx="2" cy="22" r="2"/><circle cx="22" cy="22" r="2"/><circle cx="42" cy="22" r="2"/><circle cx="62" cy="22" r="2"/>
                <circle cx="2" cy="42" r="2"/><circle cx="22" cy="42" r="2"/><circle cx="42" cy="42" r="2"/><circle cx="62" cy="42" r="2"/>
            </svg>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-blue-900/30" style="clip-path: ellipse(80% 100% at 50% 100%);"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-12 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <div class="flex flex-col gap-6 z-10">
                <div class="inline-flex items-center gap-2 px-1 py-2 w-fit">
                    <span class="text-blue-200 text-sm font-poppins">Belajar Lebih Seru dan Menarik di SynapEd</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-poppins font-semibold leading-[1.1] text-white">
                    Platform Terbaik <br>
                    <span class="text-blue-500">Kuasai Neuroscience</span>
                </h1>

                <p class="text-lg text-blue-100 font-poppins leading-relaxed max-w-lg">
                    Pahami sinyal listrik otak dan implementasi EEG secara praktis. Didesain khusus untuk pelajar, mahasiswa, dan profesional teknologi.
                </p>

                <div class="flex flex-wrap gap-4 mt-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-blue-900 hover:bg-blue-50 font-bold rounded-xl transition-all shadow-xl">
                        Mulai Belajar Sekarang
                    </a>
                    <a href="#courses" class="px-8 py-4 bg-transparent border-2 border-white/30 hover:border-white text-white font-bold rounded-xl transition-all">
                        Lihat Kurikulum
                    </a>
                </div>

                {{-- <div class="flex items-center gap-4 mt-6">
                    <div class="flex -space-x-3">
                        <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff" class="w-10 h-10 rounded-full border-2 border-blue-800">
                        <img src="https://ui-avatars.com/api/?background=2ecc71&color=fff" class="w-10 h-10 rounded-full border-2 border-blue-800">
                        <img src="https://ui-avatars.com/api/?background=e67e22&color=fff" class="w-10 h-10 rounded-full border-2 border-blue-800">
                        <div class="w-10 h-10 rounded-full border-2 border-blue-800 bg-blue-700 flex items-center justify-center text-[10px] font-bold text-white">+2k</div>
                    </div>
                    <div>
                        <div class="font-bold text-white">100K+</div>
                        <div class="text-xs text-blue-200">Total Siswa Terdaftar</div>
                    </div>
                </div> --}}
            </div>

            <div class="relative flex justify-center items-center">
                <div class="absolute w-[85%] aspect-square bg-white rounded-full opacity-10 -rotate-12 translate-x-10 blur-sm"></div>

                <div class="relative z-10 w-full max-w-md">
                    <div class="aspect-[4/5] bg-blue-800 rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-white/10">
                         <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80" class="w-full h-full object-cover" alt="Student Learning">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
