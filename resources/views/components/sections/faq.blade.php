<section id="faq" class="relative py-28 overflow-hidden" style="background: linear-gradient(180deg, #0F172A 0%, #0B1120 100%);">
    <div class="absolute inset-0 grid-bg opacity-40"></div>

    <div class="relative max-w-3xl mx-auto px-6">

        <!-- Section header -->
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full border border-teal-500/20 mb-6">
                <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-teal-300 text-sm font-medium">FAQ</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-white leading-tight" style="font-family: var(--font-heading);">
                Pertanyaan yang Sering
                <span class="text-transparent bg-clip-text" style="background-image: linear-gradient(135deg, #0C7779, #5ECED0);">Ditanyakan</span>
            </h2>
        </div>

        <!-- Accordion -->
        <div class="flex flex-col gap-3" id="faq-accordion">
            @foreach($faqs as $index => $faq)
            <div class="glass-card rounded-2xl border border-white/08 overflow-hidden accordion-item group hover:border-teal-500/20 transition-colors duration-200">
                <button
                    class="w-full flex items-center justify-between gap-4 p-6 text-left accordion-trigger"
                    data-target="faq-{{ $index }}"
                    aria-expanded="false">
                    <span class="text-white font-semibold text-base leading-snug pr-4 group-hover:text-teal-200 transition-colors">
                        {{ $faq['question'] }}
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center transition-all duration-300 accordion-icon"
                          style="background: rgba(12,119,121,0.15); border: 1px solid rgba(12,119,121,0.2);">
                        <svg class="w-4 h-4 text-teal-400 transition-transform duration-300 accordion-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div id="faq-{{ $index }}" class="accordion-content">
                    <div class="px-6 pb-6">
                        <div class="h-px mb-5" style="background: rgba(255,255,255,0.06);"></div>
                        <p class="text-slate-300 text-sm leading-relaxed">{{ $faq['answer'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bottom note -->
        <p class="text-center text-slate-500 text-sm mt-10">
            Masih ada pertanyaan? <a href="#" class="text-teal-400 hover:text-teal-300 font-medium transition-colors">Hubungi kami</a>
        </p>
    </div>
</section>

@push('scripts')
<script>
    // Accordion logic
    document.querySelectorAll('.accordion-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const content  = document.getElementById(targetId);
            const chevron  = btn.querySelector('.accordion-chevron');
            const isOpen   = content.classList.contains('open');

            // Close all
            document.querySelectorAll('.accordion-content').forEach(c => {
                c.classList.remove('open');
            });
            document.querySelectorAll('.accordion-chevron').forEach(c => {
                c.style.transform = 'rotate(0deg)';
            });
            document.querySelectorAll('.accordion-trigger').forEach(b => {
                b.setAttribute('aria-expanded', 'false');
            });

            // Open clicked (if it was closed)
            if (!isOpen) {
                content.classList.add('open');
                chevron.style.transform = 'rotate(180deg)';
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
</script>
@endpush
