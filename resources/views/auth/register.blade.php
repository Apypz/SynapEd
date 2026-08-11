<x-guest-layout>
    <div class="font-['Poppins']">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-2 tracking-tight">Buat Akun Baru</h2>
            <p class="text-slate-500 text-sm">Bergabung dengan ribuan pelajar di SynapEd</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="space-y-2">
                <label for="name" class="block text-slate-700 text-sm font-semibold ml-1">Nama Lengkap</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        required autofocus autocomplete="name"
                        placeholder="Nama Lengkap Anda"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
                @error('name')<p class="text-red-500 text-xs mt-1 ml-1 font-medium">{{ $message }}</p>@enderror
            </div>

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
                        required autocomplete="username"
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
                        required autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
                @error('password')<p class="text-red-500 text-xs mt-1 ml-1 font-medium">{{ $message }}</p>@enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-slate-700 text-sm font-semibold ml-1">Konfirmasi Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        required autocomplete="new-password"
                        placeholder="Ulangi kata sandi Anda"
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 shadow-sm" />
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-base shadow-lg shadow-blue-500/20 transform active:scale-[0.98] transition-all duration-200">
                    Daftar Sekarang
                </button>
            </div>

            {{-- Footer link --}}
            <p class="text-center text-slate-500 text-sm pt-2">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-bold ml-1 transition-colors underline-offset-4 hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>
</x-guest-layout>
