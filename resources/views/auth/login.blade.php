<x-guest-layout>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-5 p-3 rounded-xl text-sm text-green-400 bg-green-500/10 border border-green-500/20">{{ session('status') }}</div>
    @endif

    <h2 class="text-2xl font-black text-white mb-1" style="font-family:var(--font-heading);">Masuk ke Akun</h2>
    <p class="text-slate-400 text-sm mb-7">Lanjutkan perjalanan belajar Anda</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-slate-300 text-sm font-medium mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="nama@email.com"
                   class="na-input" />
            @error('email')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-slate-300 text-sm font-medium mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="na-input" />
            @error('password')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-blue-500">
                <span class="text-slate-400 text-sm">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-blue-400 text-sm hover:text-blue-300 transition-colors">Lupa password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-base transition-all duration-200 hover:opacity-90">
            Masuk
        </button>

        {{-- Register link --}}
        <p class="text-center text-slate-400 text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
