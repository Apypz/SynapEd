{{-- Partners / Institutions Marquee Section --}}
<section id="partners" class="py-16 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-xs font-semibold uppercase tracking-widest mb-2 text-teal-400">Dipercaya Oleh</p>
            <h2 class="text-2xl sm:text-3xl font-bold section-heading">
                Kolaborasi bersama
                <span style="background: linear-gradient(135deg, #60A5FA, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Institusi Terkemuka
                </span>
            </h2>
        </div>

        {{-- Marquee wrapper --}}
        <div class="relative">
            {{-- Fade edges --}}
            <div class="absolute inset-y-0 left-0 w-24 z-10 pointer-events-none"
                 style="background: linear-gradient(to right, var(--fade-from), transparent);"></div>
            <div class="absolute inset-y-0 right-0 w-24 z-10 pointer-events-none"
                 style="background: linear-gradient(to left, var(--fade-from), transparent);"></div>

            <div class="overflow-hidden">
                <div class="marquee-track flex gap-6 w-max">
                    @php $allPartners = array_merge($partners, $partners); @endphp
                    @foreach($allPartners as $partner)
                    <div class="glass-card rounded-xl px-6 py-4 flex items-center gap-3 select-none whitespace-nowrap flex-shrink-0">
                        <span class="w-9 h-9 rounded-lg text-xs font-bold text-white flex items-center justify-center flex-shrink-0"
                              style="background: linear-gradient(135deg, #0C7779, #5ECED0);">
                            {{ $partner['abbr'][0] }}
                        </span>
                        <span class="text-sm font-semibold partner-name-text">{{ $partner['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Pause marquee on hover
    const track = document.querySelector('.marquee-track');
    if (track) {
        const wrapper = track.parentElement;
        wrapper.addEventListener('mouseenter', () => track.style.animationPlayState = 'paused');
        wrapper.addEventListener('mouseleave', () => track.style.animationPlayState = 'running');
    }
</script>
@endpush
