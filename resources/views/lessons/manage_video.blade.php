<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white text-xs">← Dashboard</a>
                <span class="text-slate-600">/</span>
                <h1 class="text-lg font-bold text-white font-heading">
                    📹 {{ isset($lesson) ? 'Edit Materi Video' : 'Tambah Materi Video Baru' }}
                </h1>
            </div>
            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs font-bold rounded-full">
                Modul Video & Transkrip
            </span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="glass-card rounded-2xl p-6 border border-white/10 bg-slate-900/90 text-slate-200">
            <div class="mb-6 pb-4 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Form Pengaturan Materi Video</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Kursus: <strong class="text-cyan-400">{{ $course->title }}</strong></p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-500 font-mono">Tipe: Video</span>
                </div>
            </div>

            <form action="{{ isset($lesson) ? route('lessons.update', $lesson->id) : route('lessons.store', $course->id) }}" method="POST" class="space-y-5">
                @csrf
                @if(isset($lesson))
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="video">

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Judul Pelajaran Video *</label>
                        <input type="text" name="title" required value="{{ old('title', $lesson->title ?? '') }}" placeholder="Contoh: Pengenalan Aktivitas Sinapsis Saraf" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Durasi Video *</label>
                        <input type="text" name="duration" required value="{{ old('duration', $lesson->duration ?? '15 menit') }}" placeholder="15 menit" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Nama Modul / Seksi *</label>
                        <input type="text" name="section_title" required value="{{ old('section_title', $lesson->section_title ?? 'Modul Utama') }}" placeholder="Modul 1: Pendahuluan" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">URL Link Video (YouTube Embed / MP4 Direct Link) *</label>
                        <input type="text" name="video_url" required value="{{ old('video_url', $lesson->video_url ?? '') }}" placeholder="https://www.youtube.com/embed/..." class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1.5 text-slate-200">Deskripsi Singkat Materi Video</label>
                    <textarea name="content" rows="3" placeholder="Tuliskan gambaran umum materi video..." class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-cyan-400">{{ old('content', $lesson->content ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1.5 text-slate-200 flex items-center justify-between">
                        <span>📝 Transkrip Teks Lengkap Video</span>
                        <span class="text-[10px] text-slate-400">Ditampilkan sebagai opsi bacaan transkrip di bawah video</span>
                    </label>
                    <textarea name="transcript" rows="6" placeholder="Ketik atau tempelkan transkrip percakapan/penjelasan video di sini..." class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-sm text-slate-200 focus:outline-none focus:border-cyan-400 font-mono">{{ old('transcript', $lesson->transcript ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-white/10">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white rounded-xl text-xs font-bold shadow-lg transition-all">
                        💾 {{ isset($lesson) ? 'Simpan Perubahan Video' : 'Terbitkan Materi Video' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
