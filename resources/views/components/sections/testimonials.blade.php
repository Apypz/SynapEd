{{-- Testimonials Section --}}
<section id="testimonials" class="py-20 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-widest mb-2 text-teal-400">Testimoni</p>
            <h2 class="text-3xl sm:text-4xl font-bold section-heading">
                Apa kata
                <span style="background: linear-gradient(135deg, #60A5FA, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    pelajar kami
                </span>
            </h2>
            <p class="mt-4 max-w-xl mx-auto text-base section-sub-text">
                Bergabunglah bersama ratusan pelajar yang telah merasakan manfaat nyata belajar neuroscience dan EEG di NeuroAcademy.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
            <div class="glass-card rounded-2xl p-7 flex flex-col gap-5 hover:scale-[1.02] transition-transform duration-300">
                {{-- Quote icon --}}
                <svg class="w-8 h-8 flex-shrink-0 opacity-40" viewBox="0 0 24 24" fill="currentColor" style="color: #5ECED0;">
                    <path d="M7.17 17c.51 0 .98-.29 1.2-.74l1.42-2.84c.14-.28.21-.58.21-.89V8c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v5c0 .55.45 1 1 1h2l-1.03 2.06c-.45.89.2 1.94 1.2 1.94zm10 0c.51 0 .98-.29 1.2-.74l1.42-2.84c.14-.28.21-.58.21-.89V8c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v5c0 .55.45 1 1 1h2l-1.03 2.06c-.45.89.2 1.94 1.2 1.94z"/>
                </svg>

                {{-- Content --}}
                <p class="flex-1 leading-relaxed text-sm testimonial-content">{{ $t['content'] }}</p>

                {{-- Star rating --}}
                <div class="flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $t['rating'] ? 'text-yellow-400' : 'text-gray-600' }}"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 9.101c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    @endfor
                </div>

                {{-- Author --}}
                <div class="flex items-center gap-3 pt-2 border-t border-white/10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                         style="background: linear-gradient(135deg, {{ $t['color'] }}, #5ECED0);">
                        {{ $t['initials'] }}
                    </div>
                    <div>
                        <div class="font-semibold text-sm testimonial-name">{{ $t['name'] }}</div>
                        <div class="text-xs testimonial-position">{{ $t['position'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
