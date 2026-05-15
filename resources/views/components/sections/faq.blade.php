<section id="faq" class="relative py-24 overflow-hidden bg-[#F1F5F9]">
    <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_20%_30%,_rgba(59,130,246,0.05)_0%,_transparent_50%)]"></div>

    <div class="relative max-w-6xl mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-poppins font-bold text-slate-900 mt-4">Frequently <span class="text-[#0056D2] ">Asked</span> Questions</h2>
        </div>

        <div class="flex flex-col gap-5 items-center">
            @foreach($faqs as $index => $faq)
            <div class="group relative w-full flex justify-center items-center py-2">

                <div class="absolute left-[5%] lg:left-[10%] bottom-[-10px] z-30 pointer-events-none
                            opacity-0 group-hover:opacity-100
                            -translate-x-10 group-hover:translate-x-2
                            transition-all duration-500 ease-out hidden lg:block">
                    <img src="images/3.png"
                         alt="User Support"
                         class="h-60 w-auto object-contain drop-shadow-[0_20px_20px_rgba(0,0,0,0.15)]">
                </div>

                <div class="relative z-20 w-full max-w-2xl transition-all duration-500 ease-in-out transform lg:group-hover:translate-x-32">

                    <div class="bg-white rounded-[2.5rem] rounded-tl-none shadow-[0_10px_40px_-15px_rgba(0,0,0,0.08)]
                                border border-white group-hover:border-blue-200
                                group-hover:shadow-blue-900/5 transition-all duration-300">

                        <button
                            class="w-full flex items-center justify-between gap-4 p-7 md:p-9 text-left accordion-trigger"
                            data-target="faq-{{ $index }}"
                            aria-expanded="false">

                            <div class="flex items-center gap-6">
                                <div class="w-1.5 h-10 bg-[#0056D2] rounded-full shadow-[0_0_15px_rgba(37,99,235,0.4)]"></div>
                                <span class="text-slate-800 font-poppins font-bold text-lg md:text-xl leading-tight group-hover:text-[#0056D2] transition-colors">
                                    {{ $faq['question'] }}
                                </span>
                            </div>

                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-50 group-hover:bg-[#0056D2] transition-all duration-300 accordion-icon">
                                <svg class="w-5 h-5 text-[#0056D2] group-hover:text-white transition-transform duration-300 accordion-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <div id="faq-{{ $index }}" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out accordion-content bg-slate-50/30">
                            <div class="px-10 pb-9 text-slate-600 text-base md:text-lg leading-relaxed border-t border-slate-50 pt-4">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        </div>
            <p class="text-center text-slate-500 text-sm mt-10">
                Masih ada pertanyaan? <a href="#" class="text-white hover:text-[#0056D2] font-poppins font-medium transition-colors">Hubungi kami</a>
            </p>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.querySelectorAll('.accordion-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const chevron = btn.querySelector('.accordion-chevron');
            const iconBg = btn.querySelector('.accordion-icon');

            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

            // Menutup semua accordion lain secara eksklusif
            document.querySelectorAll('.accordion-content').forEach(c => {
                c.style.maxHeight = '0px';
                const otherBtn = c.previousElementSibling;
                otherBtn.querySelector('.accordion-chevron').style.transform = 'rotate(0deg)';
                otherBtn.querySelector('.accordion-icon').classList.remove('bg-blue-600');
                otherBtn.querySelector('.accordion-icon').classList.add('bg-blue-50');
            });

            // Buka yang diklik
            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + "px";
                chevron.style.transform = 'rotate(180deg)';
                iconBg.classList.add('bg-blue-600');
                iconBg.classList.remove('bg-blue-50');
            }
        });
    });
</script>
@endpush
