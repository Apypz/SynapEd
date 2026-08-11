<x-guest-layout>
    <div class="font-['Poppins']">
        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-6 p-4 rounded-2xl text-sm text-blue-600 bg-blue-50 border border-blue-100 animate-fade-in-down">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="text-center mb-8">
            {{-- Icon Dekorasi --}}
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl text-blue-600 mb-4 shadow-sm">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2 tracking-tight">Lupa Password?</h2>
            <p class="text-slate-500 text-sm px-4">Jangan khawatir, kami akan mengirimkan instruksi pemulihan ke email Anda.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            {{-- Alamat Email --}}
            <div class="space-y-2">
                <label for="email" class="block text-slate-700 text-sm font-semibold ml-1">Alamat Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        required autofocus
                        placeholder="nama@email.com"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
                @error('email')<p class="text-red-500 text-xs mt-1 ml-1 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-base shadow-lg shadow-blue-500/20 transform active:scale-[0.98] transition-all duration-200">
                Kirim Instruksi Reset
            </button>

            {{-- Back to Login --}}
            <div class="pt-2 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-bold text-sm transition-colors group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke halaman Masuk
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
