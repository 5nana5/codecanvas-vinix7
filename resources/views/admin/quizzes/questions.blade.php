@extends('layouts.codecanvas')

@section('title', 'Kelola Soal — ' . $quiz->title)

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-amber-400">{{ $quiz->category->name }}</span>
            <h1 class="text-2xl font-extrabold mt-0.5">Daftar soal: {{ $quiz->title }}</h1>
        </div>
        <a href="{{ route('admin.quizzes.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow transition">
            Selesai
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-200 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('import_summary'))
        @php $sum = session('import_summary'); @endphp
        <div class="p-4 rounded-xl border border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-950/60 flex flex-wrap items-center justify-between gap-4">
            <div class="text-sm text-amber-900 dark:text-amber-200">
                <strong>Hasil unggah:</strong> {{ $sum['imported'] }} soal berhasil disimpan, sementara <strong>{{ $sum['failed'] }} baris ditolak</strong> karena data tidak sesuai.
            </div>
            <a href="{{ route('admin.quizzes.import.errors', $quiz) }}"
               class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold shadow transition">
                <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3" /></svg>Unduh data yang ditolak (.csv)
            </a>
        </div>
    @endif

    <!-- Unggah CSV -->
    <section class="rounded-xl border border-blue-200 dark:border-blue-900/60 bg-blue-50/60 dark:bg-slate-900/70 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
            <div>
                <h2 class="text-base font-bold">Unggah banyak soal sekaligus</h2>
                <p class="text-xs text-slate-600 dark:text-slate-400">Unduh template, isi soal beserta opsi A–D, lalu unggah kembali di sini.</p>
            </div>
            <a href="{{ route('admin.quizzes.template') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-blue-300 dark:border-slate-600 text-blue-700 dark:text-amber-400 text-xs font-extrabold shadow-sm hover:bg-blue-50 dark:hover:bg-slate-700 transition">
                <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3" /></svg>Unduh template CSV
            </a>
        </div>

        <form action="{{ route('admin.quizzes.import', $quiz) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3 pt-3 border-t border-blue-200/60 dark:border-slate-800">
            @csrf
            <input type="file" name="csv_file" accept=".csv,.txt" required
                class="text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 7.5 12 3m0 0 4.5 4.5M12 3v12" /></svg>Unggah CSV
            </button>
        </form>
    </section>

    <!-- Tambah soal manual -->
    <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6">
        <h2 class="text-lg font-extrabold text-slate-900 dark:text-white mb-4">Tambah soal pilihan ganda</h2>

        <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="question_text" class="block text-sm font-semibold mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <textarea id="question_text" name="question_text" rows="2" required placeholder="Tuliskan pertanyaan Anda di sini..."
                    class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900"></textarea>
            </div>

            <div>
                <label for="code_snippet" class="block text-sm font-semibold mb-1">Potongan kode (opsional)</label>
                <textarea id="code_snippet" name="code_snippet" rows="3" placeholder="Tempel potongan kode HTML/CSS/JS/SQL di sini jika ada..."
                    class="w-full font-mono text-sm rounded-lg border-slate-300 dark:border-slate-700 bg-slate-950 text-emerald-300"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="option_a" class="block text-xs font-bold mb-1">Opsi A <span class="text-red-500">*</span></label>
                    <input type="text" id="option_a" name="option_a" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_b" class="block text-xs font-bold mb-1">Opsi B <span class="text-red-500">*</span></label>
                    <input type="text" id="option_b" name="option_b" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_c" class="block text-xs font-bold mb-1">Opsi C <span class="text-red-500">*</span></label>
                    <input type="text" id="option_c" name="option_c" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
                <div>
                    <label for="option_d" class="block text-xs font-bold mb-1">Opsi D <span class="text-red-500">*</span></label>
                    <input type="text" id="option_d" name="option_d" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="correct_answer" class="block text-sm font-semibold mb-1">Kunci Jawaban <span class="text-red-500">*</span></label>
                    <select id="correct_answer" name="correct_answer" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                        <option value="d">Opsi D</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="explanation" class="block text-sm font-semibold mb-1">Penjelasan singkat (opsional)</label>
                    <input type="text" id="explanation" name="explanation" placeholder="Alasan mengapa jawaban tersebut benar..."
                        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 dark:bg-amber-400 text-white dark:text-slate-950 font-bold text-sm shadow">
                    + Simpan soal
                </button>
            </div>
        </form>
    </section>

    <!-- Daftar soal -->
    <section class="space-y-3">
        <h2 class="text-lg font-bold">Daftar soal tersimpan ({{ $quiz->questions->count() }})</h2>
        @forelse($quiz->questions as $idx => $q)
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-5 flex items-start justify-between gap-4">
                <div>
                    <p class="font-bold text-sm">#{{ $idx + 1 }}. {{ $q->question_text }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">Kunci Jawaban: <strong class="uppercase">{{ $q->correct_answer }}</strong></p>
                </div>
                <form action="{{ route('admin.questions.destroy', $q) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 rounded bg-rose-600 text-white text-xs font-bold">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada soal pada kuis ini.</p>
        @endforelse
    </section>
</div>
@endsection
