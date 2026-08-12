<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white text-xs">← Dashboard</a>
                <span class="text-slate-600">/</span>
                <h1 class="text-lg font-bold text-white font-heading">
                    📝 {{ isset($lesson) ? 'Edit Kuis & Form Tugas' : 'Buat Form Kuis Baru (Google Forms Style)' }}
                </h1>
            </div>
            <span class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold rounded-full">
                Google Forms Style Builder
            </span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="glass-card rounded-2xl p-6 border border-white/10 bg-slate-900/90 text-slate-200">
            <div class="mb-6 pb-4 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Form Pengaturan Kuis & Evaluasi Modul</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Kursus: <strong class="text-amber-400">{{ $course->title }}</strong></p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-500 font-mono">Tipe: Quiz / Assignment</span>
                </div>
            </div>

            <form id="formQuizBuilder" action="{{ isset($lesson) ? route('lessons.update', $lesson->id) : route('lessons.store', $course->id) }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($lesson))
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="quiz">

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Judul Kuis / Evaluasi *</label>
                        <input type="text" name="title" required value="{{ old('title', $lesson->title ?? '') }}" placeholder="Contoh: Kuis Evaluasi Modul EEG & Biosignal" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Durasi Pengerjaan *</label>
                        <input type="text" name="duration" required value="{{ old('duration', $lesson->duration ?? '20 menit') }}" placeholder="20 menit" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Nama Modul / Seksi *</label>
                        <input type="text" name="section_title" required value="{{ old('section_title', $lesson->section_title ?? 'Modul Utama') }}" placeholder="Modul 3: Uji Pemahaman" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 text-slate-200">Petunjuk Pengerjaan</label>
                        <input type="text" name="content" value="{{ old('content', $lesson->content ?? 'Jawab seluruh pertanyaan kuis dengan cermat untuk menyelesaikan modul.') }}" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                {{-- GOOGLE FORMS DYNAMIC QUESTION BUILDER --}}
                <div class="pt-4 border-t border-white/10 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                                📋 Daftar Soal & Kunci Jawaban (Google Form Style)
                            </h3>
                            <p class="text-xs text-slate-400">Tambahkan pertanyaan pilihan ganda atau uraian dan tetapkan skornya</p>
                        </div>
                        <button type="button" onclick="addQuestionCard()" class="px-4 py-2 bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/40 rounded-xl text-xs font-bold transition-all">
                            + Tambah Soal Baru
                        </button>
                    </div>

                    {{-- Questions Container --}}
                    <div id="questionsContainer" class="space-y-4">
                        {{-- Questions will be rendered here dynamically via JavaScript --}}
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-white/10">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white rounded-xl text-xs font-bold shadow-lg transition-all">
                        💾 {{ isset($lesson) ? 'Simpan Perubahan Form Kuis' : 'Terbitkan Form Kuis' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @php
        $existingQuizData = isset($lesson) && !empty($lesson->quiz_data) ? $lesson->quiz_data : [
            [
                'id' => 1,
                'question' => '',
                'type' => 'pilihan_ganda',
                'points' => 50,
                'options' => [
                    '',
                    '',
                    '',
                    ''
                ],
                'correct_answer' => 0,
                'guide' => ''
            ],
            [
                'id' => 2,
                'question' => '',
                'type' => 'uraian',
                'points' => 50,
                'options' => ['', '', '', ''],
                'correct_answer' => 0,
                'guide' => ''
            ]
        ];
    @endphp

    <script>
    let questions = @json($existingQuizData);

    function renderQuestions() {
        const container = document.getElementById('questionsContainer');
        container.innerHTML = '';

        questions.forEach((q, idx) => {
            const card = document.createElement('div');
            card.className = 'p-5 rounded-2xl bg-slate-800/80 border border-white/10 space-y-4 shadow-lg relative';

            let optionsHtml = '';
            if (q.type === 'pilihan_ganda') {
                optionsHtml = `
                    <div class="space-y-2 pt-2">
                        <label class="block text-xs font-bold text-slate-300">Pilihan Jawaban & Tandai Kunci Jawaban Benar:</label>
                        ${[0,1,2,3].map(optIdx => `
                            <div class="flex items-center gap-3">
                                <input type="radio" name="questions[${idx}][correct_answer]" value="${optIdx}" ${q.correct_answer == optIdx ? 'checked' : ''} class="text-amber-500 focus:ring-0">
                                <span class="text-xs font-bold text-slate-400 w-6">${String.fromCharCode(65 + optIdx)}.</span>
                                <input type="text" name="questions[${idx}][options][${optIdx}]" value="${(q.options && q.options[optIdx]) ? q.options[optIdx] : ''}" placeholder="Opsi ${String.fromCharCode(65 + optIdx)}" required class="flex-1 bg-slate-900 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-amber-400">
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                optionsHtml = `
                    <div class="pt-2">
                        <label class="block text-xs font-bold text-slate-300 mb-1">Rubrik / Kunci Penilaian Jawaban Uraian:</label>
                        <textarea name="questions[${idx}][guide]" rows="2" placeholder="Panduan penilaian untuk pengajar..." class="w-full bg-slate-900 border border-white/10 rounded-lg p-2.5 text-xs text-white focus:outline-none focus:border-amber-400">${q.guide || ''}</textarea>
                    </div>
                `;
            }

            card.innerHTML = `
                <div class="flex items-center justify-between pb-3 border-b border-white/05">
                    <span class="text-xs font-bold text-amber-400">Pertanyaan #${idx + 1}</span>
                    <button type="button" onclick="removeQuestionCard(${idx})" class="text-xs text-rose-400 hover:text-rose-300 font-semibold">
                        🗑️ Hapus Soal
                    </button>
                </div>

                <div class="grid sm:grid-cols-4 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Teks Pertanyaan / Soal *</label>
                        <input type="text" name="questions[${idx}][question]" value="${q.question || ''}" required placeholder="Tuliskan pertanyaan..." class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Tipe Soal *</label>
                        <select name="questions[${idx}][type]" onchange="changeQuestionType(${idx}, this.value)" class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                            <option value="pilihan_ganda" ${q.type === 'pilihan_ganda' ? 'selected' : ''}>Pilihan Ganda</option>
                            <option value="uraian" ${q.type === 'uraian' ? 'selected' : ''}>Uraian / Esai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Bobot Skor (Poin) *</label>
                        <input type="number" name="questions[${idx}][points]" value="${q.points || 50}" min="1" max="100" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    </div>
                </div>

                ${optionsHtml}
            `;

            container.appendChild(card);
        });
    }

    function syncQuestionsFromDOM() {
        const container = document.getElementById('questionsContainer');
        questions.forEach((q, idx) => {
            const card = container.children[idx];
            if (!card) return;

            const questionInput = card.querySelector(`[name="questions[${idx}][question]"]`);
            if (questionInput) q.question = questionInput.value;

            const pointsInput = card.querySelector(`[name="questions[${idx}][points]"]`);
            if (pointsInput) q.points = pointsInput.value;

            if (q.type === 'pilihan_ganda') {
                q.options = [0, 1, 2, 3].map(optIdx => {
                    const optInput = card.querySelector(`[name="questions[${idx}][options][${optIdx}]"]`);
                    return optInput ? optInput.value : ((q.options && q.options[optIdx]) || '');
                });
                const checkedRadio = card.querySelector(`[name="questions[${idx}][correct_answer]"]:checked`);
                if (checkedRadio) q.correct_answer = parseInt(checkedRadio.value);
            } else {
                const guideInput = card.querySelector(`[name="questions[${idx}][guide]"]`);
                if (guideInput) q.guide = guideInput.value;
            }
        });
    }

    function addQuestionCard() {
        syncQuestionsFromDOM();
        questions.push({
            id: questions.length + 1,
            question: '',
            type: 'pilihan_ganda',
            points: 50,
            options: ['', '', '', ''],
            correct_answer: 0,
            guide: ''
        });
        renderQuestions();
    }

    function removeQuestionCard(idx) {
        if (questions.length <= 1) {
            alert('Minimal harus ada 1 pertanyaan dalam kuis.');
            return;
        }
        syncQuestionsFromDOM();
        questions.splice(idx, 1);
        renderQuestions();
    }

    function changeQuestionType(idx, newType) {
        syncQuestionsFromDOM();
        questions[idx].type = newType;
        renderQuestions();
    }

    document.addEventListener('DOMContentLoaded', renderQuestions);
    </script>
</x-app-layout>
