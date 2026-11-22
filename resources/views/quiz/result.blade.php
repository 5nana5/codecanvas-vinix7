@extends('layouts.codecanvas')

@section('title', 'Hasil Kuis — CodeCanvas')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Ringkasan skor -->
    <section aria-labelledby="result-heading" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-8 text-center shadow-sm">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 mb-3">
            Hasil Evaluasi CodeCanvas
        </span>
        <h1 id="result-heading" class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $attempt->participant_name }}</h1>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">{{ $attempt->university }} • {{ $quiz->title }}</p>

        <div class="inline-flex flex-col items-center justify-center w-36 h-36 rounded-full border-4 border-blue-600 dark:border-amber-400 mb-4">
            <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $attempt->score }}</span>
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Skor Akhir</span>
        </div>

        <div class="mb-3">
            <span class="inline-block px-4 py-1.5 rounded-lg text-sm font-extrabold bg-blue-600 text-white dark:bg-amber-400 dark:text-slate-950">
                Status: {{ $attempt->readiness_verdict }}
            </span>
        </div>

        <p class="text-sm text-slate-600 dark:text-slate-300">
            Benar <strong>{{ $attempt->correct_count }}</strong> dari <strong>{{ $attempt->total_questions }}</strong> soal.
        </p>

        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white text-sm font-bold">Pilih Topik Lain</a>
            <a href="{{ route('quiz.show', $quiz->slug) }}" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-bold">Ulangi Kuis Ini</a>
        </div>
    </section>

    <!-- Ajakan ke LMS -->
    <section aria-labelledby="cta-vinix-heading" class="rounded-2xl border border-blue-500/40 bg-blue-700 dark:bg-slate-800 p-6 sm:p-8 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                    <x-application-logo />
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-slate-950">
                        Tingkatkan perjalanan belajarmu
                    </span>
                </div>
                <h2 id="cta-vinix-heading" class="text-xl sm:text-2xl font-extrabold leading-snug">
                    Siap Mendalami Materi {{ $quiz->category->name }} Bersama Mentor Praktisi?
                </h2>
                <p class="text-sm text-white leading-relaxed">
                    Lanjutkan belajarmu di <strong>Vinix7 LMS</strong> untuk mengakses materi terstruktur, proyek nyata, dan sertifikat resmi.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="https://lms.vinix7.id/" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-sm shadow-md transition whitespace-nowrap">
                    Mulai Belajar di Vinix7 LMS <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Ringkasan jawaban -->
    <section aria-labelledby="review-heading" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6 shadow-sm">
        <h2 id="review-heading" class="text-lg font-bold text-slate-900 dark:text-white mb-4">Ringkasan Jawaban</h2>
        <div class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($review as $idx => $item)
                <div class="py-3.5 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">
                            Soal #{{ $idx + 1 }}: {{ $item['question']->question_text }}
                        </p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                            Jawaban kamu: <strong class="uppercase">{{ $item['user_answer'] ?: 'Belum dijawab (waktu habis)' }}</strong>
                            @if(!$item['is_correct'])
                                • Kunci: <strong class="uppercase text-emerald-600 dark:text-emerald-400">{{ $item['question']->correct_answer }}</strong>
                            @endif
                        </p>
                    </div>
                    <span class="flex-shrink-0 text-xs font-extrabold px-2.5 py-1 rounded {{ $item['is_correct'] ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                        @if($item['is_correct'])
                            <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>Benar
                        @else
                            <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>Salah
                        @endif
                    </span>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
