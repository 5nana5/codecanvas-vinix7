@extends('layouts.codecanvas')

@section('title', 'Kelola Soal — ' . $quiz->title)

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.quizzes.index') }}" class="text-xs text-blue-600 dark:text-amber-400 hover:underline">← Kembali ke Daftar Kuis</a>
            <h1 class="text-2xl font-extrabold mt-1">Bank Soal: {{ $quiz->title }}</h1>
        </div>
        <a href="{{ route('admin.quizzes.template') }}" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition">
            ⬇ Download Template CSV Soal
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-200 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Box Import CSV Massal -->
    <section class="rounded-xl border border-blue-200 dark:border-blue-900/60 bg-blue-50/60 dark:bg-slate-900/70 p-6">
        <h2 class="text-base font-bold mb-1">Import Banyak Soal Sekaligus (CSV)</h2>
        <p class="text-xs text-slate-600 dark:text-slate-400 mb-4">Unggah file .csv sesuai format template untuk menambahkan soal Pilihan Ganda, Jawaban Singkat, maupun Narasi secara otomatis.</p>
        <form action="{{ route('admin.quizzes.import', $quiz) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
            @csrf
            <input type="file" name="csv_file" accept=".csv,.txt" required
                class="text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                ⬆ Upload & Import CSV
            </button>
        </form>
    </section>

    <!-- Form Tambah Soal Manual (3 Tipe) -->
    <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6">
        <h2 class="text-lg font-bold mb-4">Tambah Pertanyaan Manual</h2>
        <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="question_type" class="block text-sm font-semibold mb-1">Tipe Pertanyaan</label>
                <select id="question_type" name="question_type" onchange="toggleOptions(this.value)"
                    class="w-full sm:w-72 rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                    <option value="multiple_choice">Pilihan Ganda (A, B, C, D)</option>
                    <option value="short_answer">Jawaban Singkat (Teks Pendek)</option>
                    <option value="essay">Narasi / Esai (Kata Kunci)</option>
                </select>
            </div>

            <div>
                <label for="question_text" class="block text-sm font-semibold mb-1">Teks Pertanyaan</label>
                <textarea id="question_text" name="question_text" rows="2" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900"></textarea>
            </div>

            <div>
                <label for="code_snippet" class="block text-sm font-semibold mb-1">Potongan Kode / Code-Snippet (Opsional)</label>
                <textarea id="code_snippet" name="code_snippet" rows="3" placeholder="Tempel potongan kode di sini jika ada..."
                    class="w-full font-mono text-sm rounded-lg border-slate-300 dark:border-slate-700 bg-slate-950 text-emerald-300"></textarea>
            </div>

            <div id="mc-options" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="option_a" class="block text-xs font-bold mb-1">Opsi A</label>
                    <input type="text" id="option_a" name="option_a" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_b" class="block text-xs font-bold mb-1">Opsi B</label>
                    <input type="text" id="option_b" name="option_b" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_c" class="block text-xs font-bold mb-1">Opsi C</label>
                    <input type="text" id="option_c" name="option_c" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_d" class="block text-xs font-bold mb-1">Opsi D</label>
                    <input type="text" id="option_d" name="option_d" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label id="answer-label" for="correct_answer" class="block text-sm font-semibold mb-1">Kunci Jawaban (a / b / c / d)</label>
                    <input type="text" id="correct_answer" name="correct_answer" required placeholder="Contoh: b"
                        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div class="sm:col-span-2">
                    <label for="explanation" class="block text-sm font-semibold mb-1">Penjelasan Singkat Jawaban</label>
                    <input type="text" id="explanation" name="explanation" placeholder="Alasan atau pembahasan jawaban..."
                        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
            </div>

            <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 dark:bg-amber-400 text-white dark:text-slate-950 font-bold text-sm">
                + Simpan Soal ke Database
            </button>
        </form>
    </section>

    <!-- Daftar Soal Tersimpan -->
    <section class="space-y-3">
        <h2 class="text-lg font-bold">Daftar Soal Tersimpan ({{ $quiz->questions->count() }})</h2>
        @foreach($quiz->questions as $idx => $q)
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-5 flex items-start justify-between gap-4">
                <div>
                    <span class="inline-block text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-800 mb-1">
                        {{ str_replace('_', ' ', $q->question_type) }}
                    </span>
                    <p class="font-bold text-sm">#{{ $idx + 1 }}. {{ $q->question_text }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">Kunci / Kata Kunci: <strong>{{ $q->correct_answer }}</strong></p>
                </div>
                <form action="{{ route('admin.questions.destroy', $q) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 rounded bg-rose-600 text-white text-xs font-bold">Hapus</button>
                </form>
            </div>
        @endforeach
    </section>
</div>

<script>
    function toggleOptions(type) {
        const mcBox = document.getElementById('mc-options');
        const ansLabel = document.getElementById('answer-label');
        const ansInput = document.getElementById('correct_answer');

        if (type === 'multiple_choice') {
            mcBox.style.display = 'grid';
            ansLabel.textContent = 'Kunci Jawaban (a / b / c / d)';
            ansInput.placeholder = 'Contoh: b';
        } else if (type === 'short_answer') {
            mcBox.style.display = 'none';
            ansLabel.textContent = 'Kunci Jawaban Singkat';
            ansInput.placeholder = 'Contoh: 22';
        } else {
            mcBox.style.display = 'none';
            ansLabel.textContent = 'Kata Kunci Penilaian (pisahkan koma)';
            ansInput.placeholder = 'Contoh: model, view, controller';
        }
    }
</script>
@endsection
