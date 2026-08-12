@extends('layouts.app')

@section('title', 'Manajemen User – SynapEd Admin')

@section('content')
<div class="space-y-8 font-sans">

    {{-- ── HERO / HEADER BANNER ────────────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-800 p-8 sm:p-10 text-white shadow-xl shadow-blue-500/10">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/3 -top-10 w-64 h-64 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="max-w-2xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-extrabold tracking-wider uppercase">
                    <span>👑 Control Center Administrator</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    Manajemen User & Hak Akses
                </h1>
                <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                    Kelola pengguna platform SynapEd, atur hak akses role (Admin, Educator, Student), perbarui kata sandi, serta monitor daftar alamat email pengguna.
                </p>
            </div>

            <div class="flex-shrink-0">
                <button onclick="openAddModal()" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white text-blue-900 hover:bg-blue-50 font-bold text-sm shadow-xl transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>+ Tambah User Baru</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── STATS OVERVIEW CARDS ────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total User</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">👥</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Student</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($stats['students']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">🎓</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Educator</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($stats['educators']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">👨‍🏫</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-1">{{ number_format($stats['admins']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg">⚡</div>
        </div>
    </div>

    {{-- ── FILTER & SEARCH BAR ─────────────────────────────────────────── --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            
            {{-- Search Input --}}
            <div class="relative w-full sm:w-80">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>

            {{-- Role Filter Buttons --}}
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
                <a href="{{ route('admin.users.index', ['search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ empty($roleFilter) ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Role ({{ $stats['total'] }})
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'student', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $roleFilter === 'student' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Student ({{ $stats['students'] }})
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'educator', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $roleFilter === 'educator' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Educator ({{ $stats['educators'] }})
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $roleFilter === 'admin' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Admin ({{ $stats['admins'] }})
                </a>
            </div>
        </form>

        {{-- ── TABLE OF USERS ───────────────────────────────────────────── --}}
        <div class="overflow-x-auto rounded-2xl border border-slate-200/80">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500 tracking-wider">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Alamat Email</th>
                        <th class="py-3.5 px-4">Role / Hak Akses</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- User Name & Avatar --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-200 border border-slate-200 flex-shrink-0 flex items-center justify-center text-slate-700 font-bold text-sm">
                                        @if($u->avatar)
                                            <img src="{{ $u->avatar }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-tight">{{ $u->name }}</p>
                                        @if($u->id === auth()->id())
                                            <span class="text-[10px] text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">Akun Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Email Address --}}
                            <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                <div class="flex items-center gap-2">
                                    <span>{{ $u->email }}</span>
                                    <button onclick="copyToClipboard('{{ $u->email }}')" title="Salin Email" class="text-slate-400 hover:text-blue-600 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            </td>

                            {{-- Role Badge --}}
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider
                                    @if($u->role === 'admin') bg-rose-100 text-rose-700 border border-rose-200
                                    @elseif($u->role === 'educator') bg-amber-100 text-amber-800 border border-amber-200
                                    @else bg-blue-100 text-blue-700 border border-blue-200 @endif">
                                    @if($u->role === 'admin') ⚡ Admin
                                    @elseif($u->role === 'educator') 👨‍🏫 Educator
                                    @else 🎓 Student @endif
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>

                            {{-- Action Buttons --}}
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Edit Role & Name --}}
                                    <button onclick="openEditModal({{ json_encode($u) }})" title="Edit User & Role" class="p-2 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 transition-colors cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    {{-- Change Password --}}
                                    <button onclick="openPasswordModal({{ json_encode($u) }})" title="Ganti Password" class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 hover:text-amber-600 text-slate-600 transition-colors cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    </button>

                                    {{-- Delete User --}}
                                    @if($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Yakin ingin menghapus user {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus User" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 transition-colors cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm">
                                Tidak ada data pengguna yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── MODAL 1: TAMBAH USER BARU ─────────────────────────────────────────── --}}
<div id="modalAddUser" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-6 relative border border-slate-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">+ Tambah User Baru</h3>
            <button onclick="closeModal('modalAddUser')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Role / Hak Akses</label>
                <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="student">Student (Siswa / Peserta)</option>
                    <option value="educator">Educator (Pengajar / Pembuat Modul)</option>
                    <option value="admin">Admin (Pengelola Platform)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Password</label>
                <input type="password" name="password" required minlength="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modalAddUser')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">Simpan User</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL 2: EDIT USER & ROLE ────────────────────────────────────────── --}}
<div id="modalEditUser" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-6 relative border border-slate-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">Edit User & Hak Akses</h3>
            <button onclick="closeModal('modalEditUser')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="formEditUser" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Nama Lengkap</label>
                <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Alamat Email</label>
                <input type="email" id="edit_email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Role / Hak Akses</label>
                <select id="edit_role" name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="student">Student (Siswa / Peserta)</option>
                    <option value="educator">Educator (Pengajar / Pembuat Modul)</option>
                    <option value="admin">Admin (Pengelola Platform)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Ganti Password (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah password" minlength="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modalEditUser')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL 3: GANTI PASSWORD ────────────────────────────────────────────── --}}
<div id="modalPasswordUser" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-6 relative border border-slate-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">🔑 Ganti Password User</h3>
            <button onclick="closeModal('modalPasswordUser')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="formPasswordUser" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="pass_name_hidden" name="name">
            <input type="hidden" id="pass_email_hidden" name="email">
            <input type="hidden" id="pass_role_hidden" name="role">

            <p class="text-sm text-slate-600">
                Ganti kata sandi untuk akun <span id="pass_user_name" class="font-bold text-slate-900"></span>.
            </p>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Password Baru</label>
                <input type="password" name="password" required minlength="4" placeholder="Masukkan password baru" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modalPasswordUser')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-md">Update Password</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('modalAddUser').classList.remove('hidden');
}

function openEditModal(user) {
    document.getElementById('formEditUser').action = '/admin/users/' + user.id;
    document.getElementById('edit_name').value = user.name;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_role').value = user.role;
    document.getElementById('modalEditUser').classList.remove('hidden');
}

function openPasswordModal(user) {
    document.getElementById('formPasswordUser').action = '/admin/users/' + user.id;
    document.getElementById('pass_user_name').innerText = user.name;
    document.getElementById('pass_name_hidden').value = user.name;
    document.getElementById('pass_email_hidden').value = user.email;
    document.getElementById('pass_role_hidden').value = user.role;
    document.getElementById('modalPasswordUser').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Email ' + text + ' berhasil disalin ke clipboard!');
    }).catch(err => {
        console.error('Gagal menyalin:', err);
    });
}
</script>
@endpush
@endsection
