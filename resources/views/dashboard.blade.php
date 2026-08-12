<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    @php
        $user = auth()->user()->fresh() ?? auth()->user();
        $isStudent = $user->isStudent();
        $isEducator = $user->isEducator();
        $isAdmin = $user->isAdmin();
    @endphp

    <div class="space-y-10">

        {{-- ── HERO WELCOME BANNER (ONLINETUTOR FUTURISTIC STYLE) ───────────────────── --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-900 via-blue-800 to-blue-600 p-8 sm:p-10 text-white shadow-xl shadow-blue-500/15">
            {{-- Background decorative grid & glow circles --}}
            <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -top-10 w-64 h-64 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-4">

                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-heading leading-tight text-white">
                    Teaching in the internet age means we must teach tomorrow's skills today
                </h1>

                <p class="text-blue-100 text-sm sm:text-base leading-relaxed max-w-2xl">
                    Selamat datang kembali, <strong class="text-white">{{ $user->name }}</strong>! Akses materi pembelajaran interaktif, pantau progres nyata, dan kelola ekosistem SynapEd dengan efisien.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    @if($isEducator || $isAdmin)
                        <button onclick="document.getElementById('modalCreateCourse').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span>+ Buat Kursus Baru</span>
                        </button>
                    @endif
                    @if($isAdmin)
                        <button onclick="document.getElementById('modalAddUser').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs backdrop-blur-md border border-white/30 transition-all flex items-center gap-2">
                            <span>+ Tambah User Baru</span>
                        </button>
                    @endif
                    <a href="{{ route('courses.index') }}" class="px-5 py-2.5 rounded-2xl bg-white text-blue-900 hover:bg-blue-50 font-bold text-xs shadow-md transition-all flex items-center gap-2">
                        <span>Jelajahi Katalog Kursus</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash notifications --}}
        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <p class="text-xs font-bold">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <p class="text-xs font-bold">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl">⚠️</span>
                <p class="text-xs font-bold">Gagal menyimpan, mohon periksa isian berikut:</p>
            </div>
            <ul class="list-disc list-inside text-xs pl-8">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        {{-- ── DYNAMIC STATS OVERVIEW CARDS ────────────────────────────────── --}}
        @if(isset($stats) && count($stats) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($stats as $st)
            <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex items-center gap-5">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $st['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $st['label'] }}</p>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-0.5 font-heading">{{ $st['value'] }}</h3>
                </div>
            </div>
            @endforeach
        </div>
        @endif


        {{-- ── SECTION: KURSUS SAYA (STUDENT VIEW) ────────────────────────────── --}}
        @if($isStudent)
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 font-heading">Kursus Yang Diikuti</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelanjutan modul pembelajaran interaktif Anda</p>
                </div>
                <a href="{{ route('courses.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Jelajahi Tambahan Kursus →
                </a>
            </div>

            @if(count($enrolled) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($enrolled as $item)
                    @php
                        $c = $item['course'];
                        $prog = $item['progress'] ?? 0;
                        $lastLes = $item['last_lesson'] ?? 'pengantar';
                    @endphp
                    <div class="group rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                        {{-- Course Thumbnail Image --}}
                        <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                            <img src="{{ !empty($c['thumbnail']) ? $c['thumbnail'] : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop' }}" alt="{{ $c['title'] ?? 'Kursus' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-bold text-blue-600 shadow-sm">
                                📹 {{ count($c['lessons'] ?? []) }}x Lesson
                            </div>
                            <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-amber-400 text-slate-950 text-[10px] font-extrabold">
                                ⭐ 4.95
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">
                                        {{ $c['category'] ?? 'Umum' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium">• {{ $c['level'] ?? 'Pemula' }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $c['title'] ?? 'Judul Kursus' }}
                                </h3>
                            </div>

                            {{-- Real Progress Bar --}}
                            <div class="space-y-2 pt-2 border-t border-slate-100">
                                <div class="flex items-center justify-between text-xs font-bold">
                                    <span class="text-slate-500">Kemajuan Progress:</span>
                                    <span class="text-blue-600 font-mono">{{ $prog }}%</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full transition-all duration-500" style="width: {{ $prog }}%;"></div>
                                </div>

                                <div class="pt-3">
                                    <a href="{{ route('learn.lesson', [$c['slug'] ?? 'kursus', $lastLes]) }}" class="w-full py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                                        <span>Lanjut Belajar</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center rounded-3xl bg-white border border-slate-100 space-y-3">
                    <div class="text-4xl">🎓</div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Kursus Yang Diikuti</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Anda belum terdaftar pada kursus apapun. Pilih kursus dari katalog untuk memulai proses belajar dengan progress 0%.</p>
                    <a href="{{ route('courses.index') }}" class="inline-block px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-xs font-bold shadow-md transition-all">
                        Jelajahi Katalog Kursus
                    </a>
                </div>
            @endif
        </div>
        @endif


        {{-- ── SECTION: MANAJEMEN KURSUS (EDUCATOR & ADMIN VIEW) ──────────────── --}}
        @if($isEducator || $isAdmin)
        @php
            $displayCourses = $isAdmin ? $courses : $educatorCourses;
        @endphp
        <div class="space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 font-heading">Manajemen Kursus & Modul</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola isi materi, video embed, transkrip, kuis, dan thumbnail kursus</p>
                </div>
                <button onclick="document.getElementById('modalCreateCourse').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
                    <span>+ Buat Kursus Baru</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($displayCourses as $c)
                <div class="group rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                    {{-- Course Thumbnail --}}
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $c->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop' }}" alt="{{ $c->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-bold text-blue-600 shadow-sm">
                            📹 {{ count($c->lessons ?? []) }}x Lesson
                        </div>
                        <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-extrabold">
                            {{ $c->level }}
                        </div>
                    </div>

                    {{-- Course Body --}}
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">
                                    {{ $c->category }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                    {{ $c->price > 0 ? 'Rp '.number_format($c->price, 0, ',', '.') : 'Gratis' }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 line-clamp-2">
                                {{ $c->title }}
                            </h3>
                        </div>

                        {{-- Lessons List --}}
                        <div class="space-y-2 pt-3 border-t border-slate-100">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                                <span>Materi / Lessons ({{ count($c->lessons ?? []) }}):</span>
                            </div>

                            <div class="max-h-36 overflow-y-auto space-y-1.5 pr-1">
                                @foreach($c->lessons as $les)
                                <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="px-1.5 py-0.5 text-[9px] font-extrabold rounded uppercase
                                            @if($les->type==='video') bg-cyan-100 text-cyan-700
                                            @elseif($les->type==='reading') bg-blue-100 text-blue-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            {{ $les->type }}
                                        </span>
                                        <span class="text-slate-800 truncate font-semibold">{{ $les->title }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <a href="{{ route('lessons.edit', $les->id) }}" class="text-[11px] text-blue-600 hover:text-blue-800 font-bold">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('lessons.destroy', $les->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[11px] text-rose-500 hover:text-rose-700 font-bold">&times;</button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <a href="{{ route('lessons.create', [$c->id, 'type' => 'video']) }}" class="px-2.5 py-1.5 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 text-[11px] font-bold rounded-xl transition-colors">
                                    + Video
                                </a>
                                <a href="{{ route('lessons.create', [$c->id, 'type' => 'reading']) }}" class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold rounded-xl transition-colors">
                                    + Reading
                                </a>
                                <a href="{{ route('lessons.create', [$c->id, 'type' => 'quiz']) }}" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-[11px] font-bold rounded-xl transition-colors">
                                    + Kuis
                                </a>
                                <button onclick="openEditCourseModal({{ $c->id }}, '{{ addslashes($c->title) }}', '{{ $c->category }}', '{{ $c->level }}', '{{ $c->price }}', '{{ addslashes($c->duration) }}', '{{ $c->icon }}', '{{ addslashes($c->thumbnail) }}', '{{ addslashes($c->short_desc) }}')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold rounded-xl transition-colors">
                                    ✏️ Edit
                                </button>
                            </div>

                            <form action="{{ route('courses.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kursus ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[11px] font-bold rounded-xl transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif


        {{-- ── SECTION: KELOLA USER & PEMBAYARAN (ADMIN VIEW ONLY) ──────────────── --}}
        @if($isAdmin)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- User Management Card --}}
            <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 font-heading">👥 Pengelolaan User Platform</h3>
                        <p class="text-xs text-slate-500">Kelola akun Student, Educator, dan Admin</p>
                    </div>
                    <button onclick="document.getElementById('modalAddUser').classList.remove('hidden')" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md">
                        + User
                    </button>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2 pr-1">
                    @foreach($allUsers as $u)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 truncate">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ $u->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-2 py-0.5 text-[9px] font-extrabold rounded-full uppercase
                                @if($u->role==='admin') bg-rose-100 text-rose-700
                                @elseif($u->role==='educator') bg-amber-100 text-amber-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $u->role }}
                            </span>
                            <button onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}', '{{ $u->role }}')" class="text-[11px] text-blue-600 hover:text-blue-800 font-bold">
                                ✏️ Edit
                            </button>
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold">&times;</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Payment Approval Card --}}
            <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900 font-heading">💳 Pengelolaan Pembayaran QRIS DANA</h3>
                    <p class="text-xs text-slate-500">Konfirmasi pendaftaran kursus dari siswa</p>
                </div>

                <div class="max-h-80 overflow-y-auto space-y-2.5 pr-1">
                    @forelse($payments as $pm)
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800">{{ $pm->user->name ?? 'User' }}</span>
                            <span class="px-2 py-0.5 text-[9px] font-extrabold rounded-full uppercase
                                @if($pm->status==='approved' || $pm->status==='Berhasil') bg-emerald-100 text-emerald-700
                                @elseif($pm->status==='rejected' || $pm->status==='Gagal') bg-rose-100 text-rose-700
                                @else bg-amber-100 text-amber-700 @endif">
                                {{ $pm->status }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-600">Kursus: <strong>{{ $pm->course->title ?? '-' }}</strong></p>
                        <div class="flex items-center justify-between pt-1">
                            <span class="font-mono text-blue-600 font-bold">Rp {{ number_format($pm->amount, 0, ',', '.') }}</span>

                            @if($pm->status==='pending' || $pm->status==='Pending')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.payments.approve', $pm->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 text-white font-bold rounded-lg text-[10px]">✓ Setujui</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $pm->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-rose-600 text-white font-bold rounded-lg text-[10px]">✕ Tolak</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada riwayat pembayaran.</p>
                    @endforelse
                </div>
            </div>

        </div>
        @endif

    </div>


    {{-- ── ALL MODALS (INTACT AND FUNCTIONAL) ────────────────────────────────── --}}

    {{-- MODAL: BUAT KURSUS BARU --}}
    @if($isEducator || $isAdmin)
    <div id="modalCreateCourse" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">✨ Buat Kursus Baru</h3>
                <button onclick="document.getElementById('modalCreateCourse').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Judul Kursus *</label>
                    <input type="text" name="title" required placeholder="Contoh: Bio-Computational Intelligence" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Kategori *</label>
                        <input type="text" name="category" required placeholder="Biomedical" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Tingkat Kesulitan *</label>
                        <select name="level" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Lanjutan">Lanjutan</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Harga (Rp, 0 = Gratis) *</label>
                        <input type="number" name="price" value="0" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Estimasi Durasi *</label>
                        <input type="text" name="duration" value="4 Minggu" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Thumbnail (Unggah Berkas Gambar ATAU Masukkan URL)</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-2 py-1 mb-1 text-slate-600">
                    <input type="text" name="thumbnail" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Deskripsi Singkat *</label>
                    <textarea name="short_desc" rows="2" required placeholder="Gambaran singkat kursus..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-900 focus:outline-none focus:border-blue-600"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalCreateCourse').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md">Terbitkan Kursus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: EDIT KURSUS & THUMBNAIL --}}
    <div id="modalEditCourse" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">✏️ Edit Kursus & Ganti Thumbnail</h3>
                <button onclick="document.getElementById('modalEditCourse').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
            <form id="formEditCourse" action="" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <input type="hidden" name="icon" id="editCourseIcon" value="🧠">
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Judul Kursus *</label>
                    <input type="text" name="title" id="editCourseTitle" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Kategori *</label>
                        <input type="text" name="category" id="editCourseCategory" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Tingkat Kesulitan *</label>
                        <select name="level" id="editCourseLevel" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Lanjutan">Lanjutan</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Harga (Rp) *</label>
                        <input type="number" name="price" id="editCoursePrice" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700">Estimasi Durasi *</label>
                        <input type="text" name="duration" id="editCourseDuration" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                    </div>
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Thumbnail Baru (Upload Berkas ATAU URL)</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-2 py-1 mb-1 text-slate-600">
                    <input type="text" name="thumbnail" id="editCourseThumbnail" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Deskripsi Singkat *</label>
                    <textarea name="short_desc" id="editCourseShortDesc" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-900 focus:outline-none focus:border-blue-600"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalEditCourse').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- MODAL: TAMBAH USER BARU (ADMIN ONLY) --}}
    @if($isAdmin)
    <div id="modalAddUser" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">👤 Tambah User Baru</h3>
                <button onclick="document.getElementById('modalAddUser').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Nama Lengkap *</label>
                    <input type="text" name="name" required placeholder="Ahmad Rizky" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Email *</label>
                    <input type="email" name="email" required placeholder="user@gmail.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Password *</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Role / Hak Akses *</label>
                    <select name="role" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                        <option value="student">Student (Siswa)</option>
                        <option value="educator">Educator (Pengajar)</option>
                        <option value="admin">Admin (Pengelola)</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalAddUser').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: EDIT USER (ADMIN ONLY) --}}
    <div id="modalEditUser" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900">✏️ Edit Akun User</h3>
                <button onclick="document.getElementById('modalEditUser').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
            <form id="formEditUser" action="" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Nama Lengkap *</label>
                    <input type="text" name="name" id="editUserName" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Email *</label>
                    <input type="email" name="email" id="editUserEmail" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700">Role / Hak Akses *</label>
                    <select name="role" id="editUserRole" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-blue-600">
                        <option value="student">Student (Siswa)</option>
                        <option value="educator">Educator (Pengajar)</option>
                        <option value="admin">Admin (Pengelola)</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('modalEditUser').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md">Update User</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
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

    function openEditUserModal(userId, name, email, role) {
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
        document.getElementById('formEditUser').action = '/admin/users/' + userId;
        document.getElementById('modalEditUser').classList.remove('hidden');
    }
    </script>
</x-app-layout>
