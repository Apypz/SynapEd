<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-white font-heading">Dashboard {{ ucfirst($user->role) }}</h1>
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                    @if($user->isAdmin()) bg-rose-500/20 text-rose-300 border border-rose-500/30
                    @elseif($user->isEducator()) bg-amber-500/20 text-amber-300 border border-amber-500/30
                    @else bg-blue-500/20 text-blue-300 border border-blue-500/30 @endif">
                    Role: {{ $user->role }}
                </span>
            </div>
            <p class="text-slate-400 text-xs hidden sm:block">Halo, <strong class="text-white">{{ $user->name }}</strong> ({{ $user->email }})</p>
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-emerald-400 text-lg">✓</span>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-200 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-rose-400 text-lg">⚠️</span>
            <p class="text-sm font-semibold">{{ session('error') }}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white">&times;</button>
    </div>
    @endif

    {{-- Dynamic Stats row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($stats as $stat)
        <div class="glass-card rounded-2xl p-5 flex flex-col gap-3 border border-white/08">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,rgba(12,119,121,0.2),rgba(94, 140, 208, 0.2));border:1px solid rgba(12, 54, 121, 0.25);">
                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white font-mono leading-none" style="background:linear-gradient(135deg,#60A5FA,#A78BFA);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $stat['value'] }}</p>
                <p class="text-slate-400 text-xs mt-1">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ADMIN EXCLUSIVE SECTIONS --}}
    @if($user->isAdmin())
    {{-- User Management Section --}}
    <div class="mb-10 glass-card rounded-2xl p-6 border border-white/08">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-white font-heading flex items-center gap-2">
                    <span>👥</span> Kelola Pengguna (User Management Real)
                </h2>
                <p class="text-slate-400 text-xs">Tambah user baru, edit data/role, atau hapus user langsung dari database</p>
            </div>
            <button onclick="document.getElementById('modalAddUser').classList.remove('hidden')" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-all">
                + Tambah User Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-white/05 text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/05">
                    @foreach($allUsers as $u)
                    <tr class="hover:bg-white/05 transition-colors">
                        <td class="py-3 px-4 font-semibold text-white">{{ $u->name }}</td>
                        <td class="py-3 px-4 text-slate-400">{{ $u->email }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase
                                @if($u->role === 'admin') bg-rose-500/20 text-rose-300 border border-rose-500/30
                                @elseif($u->role === 'educator') bg-amber-500/20 text-amber-300 border border-amber-500/30
                                @else bg-blue-500/20 text-blue-300 border border-blue-500/30 @endif">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}')" class="px-2.5 py-1 bg-amber-500/20 hover:bg-amber-500/30 text-xs text-amber-300 rounded transition-colors">Edit</button>
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user {{ addslashes($u->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-xs text-rose-300 rounded transition-colors">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Admin Payment Approval Section --}}
    <div class="mb-10 glass-card rounded-2xl p-6 border border-white/08">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-white font-heading flex items-center gap-2">
                    <span>💳</span> Kelola Pembayaran & Transaksi Real
                </h2>
                <p class="text-slate-400 text-xs">Verifikasi dan perbarui status transaksi siswa</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-white/05 text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4">No TRX</th>
                        <th class="py-3 px-4">Siswa</th>
                        <th class="py-3 px-4">Kursus</th>
                        <th class="py-3 px-4">Jumlah</th>
                        <th class="py-3 px-4">Metode</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/05">
                    @forelse($payments as $p)
                    <tr class="hover:bg-white/05 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-blue-400">{{ $p->trx_number }}</td>
                        <td class="py-3 px-4 font-semibold text-white">{{ $p->user->name ?? 'User' }}</td>
                        <td class="py-3 px-4 text-slate-300">{{ $p->course->title ?? 'Kursus' }}</td>
                        <td class="py-3 px-4 font-mono text-emerald-400 font-semibold">{{ $p->formatted_amount }}</td>
                        <td class="py-3 px-4 text-xs text-slate-400">{{ $p->payment_method }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $p->status === 'Berhasil' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : ($p->status === 'Pending' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <form action="{{ route('payments.update-status', $p->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Berhasil">
                                <button type="submit" class="px-2 py-1 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 text-xs rounded transition-colors">Setujui</button>
                            </form>
                            <form action="{{ route('payments.update-status', $p->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Gagal">
                                <button type="submit" class="px-2 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 text-xs rounded transition-colors">Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-slate-500 text-xs">Belum ada transaksi pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- EDUCATOR & ADMIN REAL COURSE & LESSON CRUD --}}
    @if($user->isEducator() || $user->isAdmin())
    <div class="mb-10 glass-card rounded-2xl p-6 border border-white/08">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-white font-heading flex items-center gap-2">
                    <span>📚</span> Kelola Kursus, Thumbnail & Materi (CRUD Real)
                </h2>
                <p class="text-slate-400 text-xs">Atur materi video real, bacaan real, dan ganti thumbnail kursus</p>
            </div>
            <button onclick="document.getElementById('modalAddCourse').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-semibold transition-all">
                + Buat Kursus Baru
            </button>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            @foreach($courses as $c)
            <div class="p-4 rounded-xl border border-white/10 bg-white/05 flex flex-col justify-between gap-4">
                <div class="flex items-start gap-3">
                    @if($c->thumbnail)
                        <img src="{{ $c->thumbnail }}" alt="Thumbnail {{ $c->title }}" class="w-16 h-16 rounded-xl object-cover border border-white/10 flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-blue-600/30 border border-blue-500/40 flex items-center justify-center flex-shrink-0 text-blue-300 font-bold text-lg">
                            {{ strtoupper(substr($c->title, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-bold text-white text-sm truncate">{{ $c->title }}</p>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded uppercase bg-slate-800 text-slate-300 border border-slate-700 flex-shrink-0">
                                {{ $c->category }}
                            </span>
                        </div>
                        <p class="text-slate-400 text-xs mt-0.5">{{ count($c->lessons) }} Pelajaran · {{ $c->duration }} · <span class="text-emerald-400 font-semibold">{{ $c->price_label }}</span></p>
                        <p class="text-slate-400 text-xs line-clamp-1 mt-1">{{ $c->short_desc }}</p>
                    </div>
                </div>

                {{-- Lesson Items List --}}
                <div class="space-y-1.5 pt-2 border-t border-white/05">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-bold text-slate-300">Materi / Lessons ({{ count($c->lessons) }}):</p>
                    </div>
                    <div class="max-h-36 overflow-y-auto space-y-1 pr-1">
                        @foreach($c->lessons as $les)
                        <div class="flex items-center justify-between gap-2 p-1.5 rounded bg-slate-900/60 border border-white/05 text-xs">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded uppercase
                                    @if($les->type==='video') bg-cyan-500/20 text-cyan-300
                                    @elseif($les->type==='reading') bg-blue-500/20 text-blue-300
                                    @else bg-amber-500/20 text-amber-300 @endif">
                                    {{ $les->type }}
                                </span>
                                <span class="text-slate-200 truncate font-medium">{{ $les->title }}</span>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('lessons.edit', $les->id) }}" class="text-[10px] text-amber-300 hover:underline font-bold">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('lessons.destroy', $les->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] text-rose-400 hover:underline font-semibold">&times;</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-white/05">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <a href="{{ route('lessons.create', [$c->id, 'type' => 'video']) }}" class="px-2.5 py-1 bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-300 text-[11px] font-bold rounded-lg transition-colors">
                            + Video
                        </a>
                        <a href="{{ route('lessons.create', [$c->id, 'type' => 'reading']) }}" class="px-2.5 py-1 bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 text-[11px] font-bold rounded-lg transition-colors">
                            + Reading
                        </a>
                        <a href="{{ route('lessons.create', [$c->id, 'type' => 'quiz']) }}" class="px-2.5 py-1 bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 text-[11px] font-bold rounded-lg transition-colors">
                            + Kuis (Form)
                        </a>
                        <button onclick="openEditCourseModal({{ $c->id }}, '{{ addslashes($c->title) }}', '{{ $c->category }}', '{{ $c->level }}', '{{ $c->price }}', '{{ addslashes($c->duration) }}', '{{ $c->icon }}', '{{ addslashes($c->thumbnail) }}', '{{ addslashes($c->short_desc) }}')" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 text-[11px] font-bold rounded-lg transition-colors">
                            ✏️ Edit Kursus
                        </button>
                    </div>
                    <form action="{{ route('courses.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kursus {{ addslashes($c->title) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 text-[11px] font-bold rounded-lg transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Educator Student Progress Real Section --}}
    <div class="mb-10 glass-card rounded-2xl p-6 border border-white/08">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-white font-heading flex items-center gap-2">
                    <span>📊</span> Statistik & Progress Peserta Terdaftar
                </h2>
                <p class="text-slate-400 text-xs">Pantau siswa yang terhubung dan mendaftar di kursus Anda secara realtime (dimulai dari 0%)</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-white/05 text-slate-400 border-b border-white/10">
                    <tr>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Kursus</th>
                        <th class="py-3 px-4">Progress Belajar</th>
                        <th class="py-3 px-4">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/05">
                    @forelse($studentProgress as $sp)
                    <tr class="hover:bg-white/05 transition-colors">
                        <td class="py-3 px-4 font-semibold text-white">{{ $sp->user->name ?? 'Student' }}</td>
                        <td class="py-3 px-4 text-slate-400 text-xs">{{ $sp->user->email ?? '' }}</td>
                        <td class="py-3 px-4 text-slate-300">{{ $sp->course->title ?? 'Kursus' }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-2 bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width:{{ $sp->progress }}%"></div>
                                </div>
                                <span class="text-xs font-mono font-bold text-blue-400">{{ $sp->progress }}%</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-400">{{ $sp->created_at ? $sp->created_at->format('d M Y') : 'Baru' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-slate-500 text-xs">Belum ada peserta terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- STUDENT EXCLUSIVE ENROLLED COURSES & CATALOG --}}
    @if($user->isStudent())
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold" style="font-family:var(--font-heading); color:var(--text-h);">🎓 Kursus Saya & Tracking Progress</h2>
            <a href="{{ route('courses.index') }}" class="text-blue-400 text-sm hover:text-blue-300 transition-colors">Jelajahi kursus lain →</a>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
            @foreach($enrolled as $e)
            @php $c = $e['course']; @endphp
            <div class="glass-card rounded-2xl p-5 border border-white/08 hover:border-blue-500/20 transition-all group">
                <div class="flex items-start gap-4 mb-5">
                    @if(!empty($c['thumbnail']))
                        <img src="{{ $c['thumbnail'] }}" alt="Thumbnail {{ $c['title'] }}" class="w-12 h-12 rounded-xl object-cover border border-white/10 flex-shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg, #2563EB, #0b3d91);">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$c['icon'] ?? 'brain'] ?? $iconPaths['brain'] }}"/>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-base leading-tight mb-1 group-hover:text-blue-300 transition-colors" style="color:var(--text-h);">{{ $c['title'] }}</p>
                        <p class="text-slate-400 text-xs">{{ $c['duration'] ?? '6 Jam' }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 bg-blue-500/20 text-blue-300 border border-blue-500/30">
                        {{ $c['level'] ?? 'Pemula' }}
                    </span>
                </div>
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-slate-400 text-xs">Kemajuan Belajar</span>
                        <span class="text-xs font-semibold text-blue-400 font-mono">{{ $e['progress'] }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-white/08 overflow-hidden border border-white/05">
                        <div class="h-full rounded-full transition-all duration-500" style="width:{{ $e['progress'] }}%;background:linear-gradient(135deg, #2563EB, #0b3d91);"></div>
                    </div>
                </div>
                <a href="{{ route('learn.lesson', [$c['slug'], $e['last_lesson']]) }}"
                   class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-all"
                   style="background:linear-gradient(135deg, #2563EB, #0b3d91);">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Lanjutkan Belajar
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- All courses catalog for Student ONLY --}}
    <div>
        <h2 class="text-lg font-bold mb-5" style="font-family:var(--font-heading); color:var(--text-h);">🛒 Katalog Kursus Tersedia</h2>
        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($courses as $index => $c)
            <a href="{{ route('courses.show', $c->slug) }}"
               class="glass-card rounded-2xl p-4 border border-white/08 hover:border-teal-500/20 transition-all group flex items-center gap-4">
                @if($c->thumbnail)
                    <img src="{{ $c->thumbnail }}" alt="Thumbnail" class="w-10 h-10 rounded-xl object-cover flex-shrink-0 border border-white/10">
                @else
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform bg-blue-600">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$c->icon] ?? $iconPaths['brain'] }}"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate group-hover:text-teal-300 transition-colors" style="color:var(--text-h);">{{ $c->title }}</p>
                    <p class="text-slate-500 text-xs">{{ $c->price_label }}</p>
                </div>
                <svg class="w-4 h-4 text-slate-600 group-hover:text-teal-400 flex-shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- MODAL: TAMBAH KURSUS BARU --}}
    <div id="modalAddCourse" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-2xl p-6 text-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">➕ Buat Kursus Baru & Thumbnail</h3>
                <button onclick="document.getElementById('modalAddCourse').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Kursus *</label>
                        <input type="text" name="title" required placeholder="Contoh: Bio-Signal Processing" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Thumbnail URL / Upload Gambar</label>
                        <input type="text" name="thumbnail" placeholder="https://images.unsplash.com/photo-..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 mb-1">
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Kategori *</label>
                        <select name="category" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="neuroscience">Neuroscience</option>
                            <option value="eeg">Teknologi EEG</option>
                            <option value="analisis">Analisis Data</option>
                            <option value="biomedis">Teknik Biomedis</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Tingkat Kesulitan *</label>
                        <select name="level" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Lanjutan">Lanjutan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Harga (Rp) *</label>
                        <input type="number" name="price" required value="299000" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Durasi Kursus *</label>
                        <input type="text" name="duration" required value="6 Jam" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Icon Ikon *</label>
                        <select name="icon" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="brain">Brain (Otak)</option>
                            <option value="wave">Wave (Gelombang EEG)</option>
                            <option value="headset">Headset (Perangkat Muse)</option>
                            <option value="chart">Chart (Analisis)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Warna Badge</label>
                        <select name="level_color" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="green">Hijau (Pemula)</option>
                            <option value="yellow">Kuning (Menengah)</option>
                            <option value="red">Merah (Lanjutan)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Deskripsi Singkat *</label>
                    <textarea name="short_desc" required rows="2" placeholder="Ringkasan 1-2 kalimat mengenai kursus..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalAddCourse').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-semibold transition-all">Terbitkan Kursus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: EDIT KURSUS & GANTI THUMBNAIL --}}
    <div id="modalEditCourse" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-xl p-6 text-slate-200">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">🖼️ Edit Kursus & Ganti Thumbnail</h3>
                <button onclick="document.getElementById('modalEditCourse').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form id="formEditCourse" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Kursus *</label>
                    <input type="text" id="editCourseTitle" name="title" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Thumbnail URL</label>
                        <input type="text" id="editCourseThumbnail" name="thumbnail" placeholder="https://..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Upload File Gambar Baru</label>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Kategori *</label>
                        <select id="editCourseCategory" name="category" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                            <option value="neuroscience">Neuroscience</option>
                            <option value="eeg">Teknologi EEG</option>
                            <option value="analisis">Analisis Data</option>
                            <option value="biomedis">Teknik Biomedis</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Level *</label>
                        <select id="editCourseLevel" name="level" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Lanjutan">Lanjutan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Harga (Rp) *</label>
                        <input type="number" id="editCoursePrice" name="price" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Durasi *</label>
                        <input type="text" id="editCourseDuration" name="duration" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Icon Ikon</label>
                        <select id="editCourseIcon" name="icon" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                            <option value="brain">Brain</option>
                            <option value="wave">Wave</option>
                            <option value="headset">Headset</option>
                            <option value="chart">Chart</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Deskripsi Singkat *</label>
                    <textarea id="editCourseShortDesc" name="short_desc" required rows="2" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalEditCourse').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-500 text-white rounded-xl text-xs font-semibold transition-all">Update Kursus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: TAMBAH LESSON KE KURSUS (DENGAN VIDEO URL & ISI MATERI REAL) --}}
    <div id="modalAddLesson" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-lg p-6 text-slate-200">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">📖 Tambah Pelajaran (Video & Reading Real)</h3>
                <button onclick="document.getElementById('modalAddLesson').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form id="formAddLesson" action="" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Kursus Target</label>
                    <input type="text" id="lessonCourseTitle" readonly class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-3 py-2 text-sm text-slate-400 font-semibold cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Lesson *</label>
                    <input type="text" name="title" required placeholder="Contoh: Pengenalan Gelombang Otak Alpha" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Tipe Konten *</label>
                        <select name="type" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="video">Video (Auto Complete saat selesai)</option>
                            <option value="reading">Artikel / Bacaan Real</option>
                            <option value="quiz">Kuis Interaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Durasi (Menit) *</label>
                        <input type="text" name="duration" required value="15 menit" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">URL Link Video (YouTube Embed / MP4)</label>
                    <input type="text" name="video_url" placeholder="https://www.youtube.com/embed/..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Modul / Seksi</label>
                    <input type="text" name="section_title" value="Modul Utama" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Isi Materi Lengkap / Penjelasan Bacaan</label>
                    <textarea name="content" rows="4" placeholder="Tuliskan materi pembelajaran lengkap di sini..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalAddLesson').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-semibold transition-all">Simpan Pelajaran</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: EDIT LESSON MATERI REAL --}}
    <div id="modalEditLesson" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-lg p-6 text-slate-200">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">✏️ Edit Materi Pelajaran (Real Content & Video)</h3>
                <button onclick="document.getElementById('modalEditLesson').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form id="formEditLesson" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Lesson *</label>
                    <input type="text" id="editLessonTitle" name="title" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Tipe Konten *</label>
                        <select id="editLessonType" name="type" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                            <option value="video">Video</option>
                            <option value="reading">Artikel / Bacaan Real</option>
                            <option value="quiz">Kuis Interaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-300">Durasi *</label>
                        <input type="text" id="editLessonDuration" name="duration" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">URL Link Video (YouTube Embed / MP4)</label>
                    <input type="text" id="editLessonVideoUrl" name="video_url" placeholder="https://www.youtube.com/embed/..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Judul Modul / Seksi</label>
                    <input type="text" id="editLessonSection" name="section_title" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Isi Materi Lengkap / Penjelasan Bacaan</label>
                    <textarea id="editLessonContent" name="content" rows="4" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalEditLesson').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-500 text-white rounded-xl text-xs font-semibold transition-all">Update Materi</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: USER CRUD (ADMIN) --}}
    @if($user->isAdmin())
    <div id="modalAddUser" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-md p-6 text-slate-200">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">👤 Tambah Pengguna Baru</h3>
                <button onclick="document.getElementById('modalAddUser').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Nama Pengguna *</label>
                    <input type="text" name="name" required placeholder="Budi Pratama" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Email *</label>
                    <input type="email" name="email" required placeholder="budi@gmail.com" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Password *</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Role Pengguna *</label>
                    <select name="role" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                        <option value="student">Student (Siswa)</option>
                        <option value="educator">Educator (Pengajar)</option>
                        <option value="admin">Admin (Pengelola Platform)</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalAddUser').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-all">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditUser" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
        <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-md p-6 text-slate-200">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/10">
                <h3 class="text-lg font-bold text-white font-heading">✏️ Edit Pengguna & Role</h3>
                <button onclick="document.getElementById('modalEditUser').classList.add('hidden')" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form id="formEditUser" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Nama Pengguna *</label>
                    <input type="text" id="editUserName" name="name" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Email *</label>
                    <input type="email" id="editUserEmail" name="email" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Role Pengguna *</label>
                    <select id="editUserRole" name="role" required class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                        <option value="student">Student (Siswa)</option>
                        <option value="educator">Educator (Pengajar)</option>
                        <option value="admin">Admin (Pengelola Platform)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-300">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-rose-500">
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('modalEditUser').classList.add('hidden')" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-semibold transition-all">Update User</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
    function openAddLessonModal(courseId, courseTitle) {
        document.getElementById('lessonCourseTitle').value = courseTitle;
        document.getElementById('formAddLesson').action = '/courses/' + courseId + '/lessons';
        document.getElementById('modalAddLesson').classList.remove('hidden');
    }

    function openEditCourseModal(courseId, title, category, level, price, duration, icon, thumbnail, shortDesc) {
        document.getElementById('editCourseTitle').value = title;
        document.getElementById('editCourseCategory').value = category;
        document.getElementById('editCourseLevel').value = level;
        document.getElementById('editCoursePrice').value = price;
        document.getElementById('editCourseDuration').value = duration;
        document.getElementById('editCourseIcon').value = icon;
        document.getElementById('editCourseThumbnail').value = thumbnail || '';
        document.getElementById('editCourseShortDesc').value = shortDesc;
        document.getElementById('formEditCourse').action = '/courses/' + courseId;
        document.getElementById('modalEditCourse').classList.remove('hidden');
    }

    function openEditLessonModal(lessonId, title, section, type, duration, videoUrl, content) {
        document.getElementById('editLessonTitle').value = title;
        document.getElementById('editLessonSection').value = section;
        document.getElementById('editLessonType').value = type;
        document.getElementById('editLessonDuration').value = duration;
        document.getElementById('editLessonVideoUrl').value = videoUrl || '';
        document.getElementById('editLessonContent').value = content;
        document.getElementById('formEditLesson').action = '/lessons/' + lessonId;
        document.getElementById('modalEditLesson').classList.remove('hidden');
    }

    function openEditUserModal(userId, name, email, role) {
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
        document.getElementById('formEditUser').action = '/admin/users/' + userId;
        document.getElementById('modalEditUser').classList.remove('hidden');
    }
    </script>
</x-app-layout>
