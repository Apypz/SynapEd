<x-guest-layout>
    <h2 class="text-2xl font-black text-white mb-1" style="font-family:var(--font-heading);">Reset Password</h2>
    <p class="text-slate-400 text-sm mb-7">Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.</p>

    @if (session('status'))
        <div class="mb-5 p-3 rounded-xl text-sm text-green-400 bg-green-500/10 border border-green-500/20">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-slate-300 text-sm font-medium mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus placeholder="nama@email.com" class="na-input" />
            @error('email')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-base">
            Kirim Link Reset
        </button>
        <p class="text-center text-slate-400 text-sm">
            Ingat password? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
