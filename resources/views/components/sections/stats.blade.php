{{-- Stats / Metrics Section --}}
<section id="stats-section" class="py-16 bg-[#F5F7F8]"> {{-- Background abu-abu sangat muda khas Coursera --}}
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mt-12 pt-12 border-t border-gray-200">
            @foreach($stats as $stat)
            <div class="flex flex-col items-center lg:items-start group">
                <div class="text-4xl font-poppins font-bold text-[#0056D2] mb-1 group-hover:scale-110 transition-transform">
                    {{ $stat['value'] }}
                </div>
                <div class="text-sm font-poppins font-bold text-gray-800 uppercase tracking-widest">
                    {{ $stat['label'] }}
                </div>
                <div class="w-8 h-1 bg-blue-200 mt-2 group-hover:w-full transition-all duration-500"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
