<section id="testimonials" class="py-24 bg-[#F8FAFC] font-sans overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex flex-col items-center text-center mb-16">

            <h2 class="text-4xl md:text-5xl font-poppins font-bold text-[#1B2534] leading-tight">
                Apa Yang <span class="text-[#0056D2]">Pelanggan</span> Kita Katakan
            </h2>
        </div>

        <div id="testimonial-slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth pb-4" style="-ms-overflow-style: none; scrollbar-width: none;">

            @foreach($testimonials as $t)
            <div class="snap-center shrink-0 w-[85%] md:w-[calc(33.333%-1rem)] bg-white rounded-[3rem] shadow-[5px_0px_10px_rgba(0,0,0,0.04)] border border-slate-100 p-5 flex flex-col transition-all duration-500">

                <div class="h-56 w-full rounded-[2.5rem] overflow-hidden mb-8">
                    @if(isset($t['work_image']))
                        <img src="{{ $t['work_image'] }}" class="w-full h-full object-cover" alt="Service thumbnail">
                    @else
                        <img src="{{ $t['image'] }}" class="w-full h-full object-cover" alt="Student thumbnail">
                    @endif
                </div>

                <div class="px-4 pb-6 flex flex-col items-center text-center">
                    <p class="text-slate-400 leading-relaxed text-sm mb-8 font-poppins font-medium italic">
                        "{{ $t['content'] }}"
                    </p>

                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-full overflow-hidden border-4 border-white shadow-lg">
                            <img src="{{ $t['image'] }}"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1B2534&color=fff'"
                                 class="w-full h-full object-cover"
                                 alt="{{ $t['name'] }}">
                        </div>

                        <div class="flex flex-col items-center">
                            <p class="text-sm font-poppins font-bold text-[#1B2534] tracking-wide">{{ $t['name'] }}</p>

                            <div class="flex gap-0.5 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= ($t['rating'] ?? 5) ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 9.101c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="flex justify-center gap-4 mt-12">
            <button onclick="scrollSlider('left')" class="w-14 h-14 rounded-full bg-white flex items-center justify-center hover:bg-[#0056D2] transition-all shadow-xl active:scale-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button onclick="scrollSlider('right')" class="w-14 h-14 rounded-full bg-white flex items-center justify-center hover:bg-[#0056D2] transition-all shadow-xl active:scale-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
    function scrollSlider(direction) {
        const slider = document.getElementById('testimonial-slider');
        // Card width + gap (24px)
        const cardWidth = slider.querySelector('.snap-center').offsetWidth + 24;

        if (direction === 'left') {
            slider.scrollLeft -= cardWidth;
        } else {
            slider.scrollLeft += cardWidth;
        }
    }
</script>
