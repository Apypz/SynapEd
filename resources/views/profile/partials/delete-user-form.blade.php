<section class="space-y-5">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus Akun Saya</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="background:#111827;border-radius:16px;">
            @csrf
            @method('delete')

            <h2 class="text-base font-bold text-white mb-2">Apakah Anda yakin ingin menghapus akun?</h2>
            <p class="text-slate-400 text-sm mb-6">Semua data akun Anda akan dihapus secara permanen. Masukkan kata sandi untuk konfirmasi.</p>

            <div class="mb-5">
                <x-input-label for="password" value="Kata Sandi" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full"
                    placeholder="Kata sandi Anda"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button>Hapus Akun</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
