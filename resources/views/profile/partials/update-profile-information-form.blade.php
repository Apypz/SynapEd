<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Foto Profil Section --}}
        <div class="flex items-center gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="relative w-20 h-20 rounded-full overflow-hidden bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-extrabold flex items-center justify-center text-2xl shadow-md border-2 border-white flex-shrink-0">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @endif
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700">Unggah Foto Profil Baru</label>
                <input type="file" name="avatar" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-colors">
                <p class="text-[10px] text-slate-400">Format yang didukung: JPG, PNG, WEBP (Maks. 2MB)</p>
                <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>Simpan Perubahan Profil</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-xs font-bold text-emerald-600"
                >✓ Perubahan profil berhasil disimpan!</p>
            @endif
        </div>
    </form>
</section>
