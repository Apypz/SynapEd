<x-guest-layout>
    <div class="font-['Poppins']">
        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-6 p-4 rounded-2xl text-sm text-blue-600 bg-blue-400 border border-blue-950 animate-fade-in-down">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-800 mb-2 tracking-tight">Selamat Datang</h2>
            <p class="text-blue-800 text-sm">Silakan masuk untuk melanjutkan akses materi</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                        required autofocus autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
                @error('email')<p class="text-red-500 text-xs mt-1 ml-1 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <label for="password" class="block text-slate-700 text-sm font-semibold ml-1">Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password"
                        required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
                @error('password')<p class="text-red-500 text-xs mt-1 ml-1 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between px-1">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <div class="relative flex items-center">
                        <input type="checkbox" name="remember" class="peer h-4 w-4 cursor-pointer appearance-none rounded border border-slate-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:ring-blue-500/20 transition-all">
                        <svg class="absolute h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-slate-600 text-sm group-hover:text-blue-600 transition-colors">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-600 text-sm font-semibold hover:text-blue-700 transition-colors">Lupa Password?</a>
                @endif
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-base shadow-lg shadow-blue-500/20 transform active:scale-[0.98] transition-all duration-200">
                Masuk Sekarang
            </button>

            {{-- Footer link --}}
            <div class="pt-4">
                <p class="text-center text-slate-500 text-sm">
                    Belum bergabung?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold ml-1 transition-colors underline-offset-4 hover:underline">Daftar Akun Gratis</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
