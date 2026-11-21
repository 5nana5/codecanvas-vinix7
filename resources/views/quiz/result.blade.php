@extends('layouts.codecanvas')

@section('title', 'Hasil Kuis — CodeCanvas')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Kartu Skor & Verdict -->
    <section aria-labelledby="result-heading" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-8 text-center shadow-sm">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 mb-3">
            Laporan Evaluasi Kompetensi VINIX7
        </span>
        <h1 id="result-heading" class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-1">
            {{ $attempt->participant_name }}
        </h1>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">{{ $attempt->university }} • {{ $quiz->title }}</p>

        <div class="inline-flex flex-col items-center justify-center w-36 h-36 rounded-full border-4 border-blue-600 dark:border-amber-400 mb-4">
            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $attempt->score }}</span>
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Skor Akhir</span>
        </div>

        <div class="mb-4">
            <span class="inline-block px-4 py-1.5 rounded-lg text-sm font-extrabold bg-blue-600 text-white dark:bg-amber-400 dark:text-slate-950">
                Status: {{ $attempt->readiness_verdict }}
            </span>
        </div>

        <p class="text-sm text-slate-600 dark:text-slate-300">
            Menjawab benar <strong>{{ $attempt->correct_count }}</strong> dari <strong>{{ $attempt->total_questions }}</strong> pertanyaan.
        </p>

        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-bold hover:opacity-90 transition">
                Pilih Topik Lain
            </a>
            <a href="{{ route('quiz.show', $quiz->slug) }}" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition">
                Ulangi Kuis Ini
            </a>
        </div>
    </section>

    <!-- Pembahasan Jawaban -->
    <section aria-labelledby="review-heading" class="space-y-4">
        <h2 id="review-heading" class="text-xl font-bold text-slate-900 dark:text-white">Pembahasan & Umpan Balik</h2>

        @foreach($review as $idx => $item)
            <article class="rounded-xl border {{ $item['is_correct'] ? 'border-emerald-500/50' : 'border-rose-500/50' }} bg-white dark:bg-[#1E293B] p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Pertanyaan #{{ $idx + 1 }}</span>
                    <span class="text-xs font-extrabold px-2.5 py-0.5 rounded {{ $item['is_correct'] ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                        {{ $item['is_correct'] ? '✓ Benar' : '✕ Kurang Tepat' }}
                    </span>
                </div>

                <p class="font-bold text-slate-900 dark:text-white mb-2">{{ $item['question']->question_text }}</p>

                @if($item['question']->code_snippet)
                    <pre class="mb-3 p-3 rounded bg-slate-950 text-emerald-300 font-mono text-xs overflow-x-auto"><code>{{ $item['question']->code_snippet }}</code></pre>
                @endif

                <p class="text-sm text-slate-700 dark:text-slate-300">
                    Jawaban Anda: <strong class="uppercase">{{ $item['user_answer'] ?? '-' }}</strong> |
                    Kunci Jawaban: <strong class="uppercase text-emerald-600 dark:text-emerald-400">{{ $item['question']->correct_answer }}</strong>
                </p>

                @if($item['question']->explanation)
                    <div class="mt-3 p-3 rounded-lg bg-slate-100 dark:bg-slate-900 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                        <strong>Penjelasan:</strong> {{ $item['question']->explanation }}
                    </div>
                @endif
            </article>
        @endforeach
    </section>
</div>
@endsection
