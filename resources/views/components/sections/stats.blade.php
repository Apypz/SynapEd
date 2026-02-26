{{-- Stats / Metrics Section --}}
<section id="stats" class="relative py-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="blob-gradient absolute w-72 h-72 -top-20 -left-20 rounded-full opacity-20"
             style="background: radial-gradient(circle, #2563EB 0%, transparent 70%);"></div>
        <div class="blob-gradient absolute w-72 h-72 -bottom-20 -right-20 rounded-full opacity-20"
             style="background: radial-gradient(circle, #7C3AED 0%, transparent 70%);"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($stats as $stat)
            <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                     style="background: linear-gradient(135deg, rgba(37,99,235,0.25), rgba(124,58,237,0.25)); border: 1px solid rgba(37,99,235,0.3);">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
                <div class="text-3xl font-bold font-mono mb-1"
                     style="background: linear-gradient(135deg, #60A5FA, #A78BFA); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $stat['value'] }}
                </div>
                <div class="text-sm font-medium stat-label-text">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
