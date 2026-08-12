<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white text-xs">← Dashboard</a>
                <span class="text-slate-600">/</span>
                <h1 class="text-lg font-bold text-white font-heading">
                    📖 {{ isset($lesson) ? 'Edit Materi Reading' : 'Tambah Materi Reading Baru' }}
                </h1>
            </div>
            <span class="px-3 py-1 bg-blue-500/20 text-blue-300 border border-blue-500/30 text-xs font-bold rounded-full">
                Modul Bacaan & File Lampiran
            </span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="glass-card rounded-2xl p-6 border border-white/10 bg-slate-900/90 text-slate-200">
            <div class="mb-6 pb-4 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Form Pengaturan Materi Artikel & Reading</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Kursus: <strong class="text-blue-400">{{ $course->title }}</strong></p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-500 font-mono">Tipe: Reading</span>
                </div>
            </div>

            <form action="{{ isset($lesson) ? route('lessons.update', $lesson->id) : route('lessons.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @if(isset($lesson))
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="reading">

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Judul Pelajaran Reading *</label>
                        <input type="text" name="title" required value="{{ old('title', $lesson->title ?? '') }}" placeholder="Contoh: Prinsip Kerja Elektroensefalografi (EEG)" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Estimasi Waktu Baca *</label>
                        <input type="text" name="duration" required value="{{ old('duration', $lesson->duration ?? '10 menit') }}" placeholder="10 menit" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Nama Modul / Seksi *</label>
                        <input type="text" name="section_title" required value="{{ old('section_title', $lesson->section_title ?? 'Modul Utama') }}" placeholder="Modul 2: Pendalaman Topik" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Sisipkan File Lampiran (PDF / Slide PDF / Modul)</label>
                        <input type="file" name="attachment_file" accept=".pdf,.doc,.docx,.ppt,.pptx" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-blue-400 mb-1">
                        @if(isset($lesson) && $lesson->attachment_path)
                            <p class="text-[10px] text-emerald-400 truncate">File terpasang: {{ basename($lesson->attachment_path) }}</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1.5 text-slate-200 flex items-center justify-between">
                        <span>📝 Tempat Menulis Teks Artikel & Penjelasan Lengkap *</span>
                        <span class="text-[10px] text-slate-400">Dukungan format teks paragraf dan poin pemahaman</span>
                    </label>
                    <textarea name="content" required rows="10" placeholder="Tuliskan isi materi bacaan lengkap di sini..." class="w-full bg-slate-800 border border-white/10 rounded-xl p-4 text-sm text-slate-100 leading-relaxed focus:outline-none focus:border-blue-400">{{ old('content', $lesson->content ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl text-xs font-bold shadow-lg transition-all">
                        💾 {{ isset($lesson) ? 'Simpan Perubahan Reading' : 'Terbitkan Materi Reading' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
