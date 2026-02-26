<x-app-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="max-w-2xl space-y-6">

        {{-- Profile Info --}}
        <div class="glass-card rounded-2xl p-6 border border-white/08">
            <h2 class="text-base font-bold text-white mb-1" style="font-family:var(--font-heading);">Informasi Profil</h2>
            <p class="text-slate-400 text-sm mb-6">Perbarui nama dan alamat email akun Anda.</p>
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Change Password --}}
        <div class="glass-card rounded-2xl p-6 border border-white/08">
            <h2 class="text-base font-bold text-white mb-1" style="font-family:var(--font-heading);">Ubah Kata Sandi</h2>
            <p class="text-slate-400 text-sm mb-6">Gunakan kata sandi yang panjang dan acak untuk keamanan akun.</p>
            @include('profile.partials.update-password-form')
        </div>

        {{-- Delete Account --}}
        <div class="glass-card rounded-2xl p-6 border border-red-500/20">
            <h2 class="text-base font-bold text-red-400 mb-1" style="font-family:var(--font-heading);">Hapus Akun</h2>
            <p class="text-slate-400 text-sm mb-6">Setelah dihapus, semua data akun akan hilang secara permanen.</p>
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>
