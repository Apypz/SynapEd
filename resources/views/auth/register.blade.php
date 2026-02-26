<x-guest-layout>
    <h2 class="text-2xl font-black text-white mb-1" style="font-family:var(--font-heading);">Buat Akun</h2>
    <p class="text-slate-400 text-sm mb-7">Bergabung dengan ribuan pelajar NeuroAcademy</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-slate-300 text-sm font-medium mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   placeholder="Nama Anda"
                   class="na-input" />
            @error('name')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-slate-300 text-sm font-medium mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   placeholder="nama@email.com"
                   class="na-input" />
            @error('email')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-slate-300 text-sm font-medium mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
                   class="na-input" />
            @error('password')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-slate-300 text-sm font-medium mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   placeholder="Ulangi password"
                   class="na-input" />
            @error('password_confirmation')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-base transition-all duration-200 hover:opacity-90">
            Daftar Sekarang
        </button>

        {{-- Login link --}}
        <p class="text-center text-slate-400 text-sm">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
