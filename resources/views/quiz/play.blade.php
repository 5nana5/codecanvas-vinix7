@extends('layouts.codecanvas')

@section('title', $quiz->title . ' — CodeCanvas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-5 shadow-sm">
        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-amber-400">{{ $quiz->category->name }}</span>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $quiz->title }}</h1>
    </div>

    <form id="quiz-form" action="{{ route('quiz.submit', $quiz->slug) }}" method="POST">
        @csrf

        <section id="step-identity" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6 sm:p-8 shadow-sm space-y-5">
            <div>
                <span class="inline-block px-2.5 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800 dark:bg-slate-900 dark:text-blue-300 mb-2">
                    Persiapan kuis ({{ $quiz->questions->count() }} soal)
                </span>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Isi identitas singkat</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Waktu mengerjakan 1 menit untuk setiap soal. Jika waktu habis, kamu otomatis lanjut ke soal berikutnya.
                </p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="participant_name" class="block text-sm font-semibold mb-1">Nama lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="participant_name" name="participant_name" required placeholder="Contoh: Nanda Rahayu"
                        class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5">
                </div>
                <div>
                    <label for="university" class="block text-sm font-semibold mb-1">Asal kampus / instansi</label>
                    <input type="text" id="university" name="university" placeholder="Contoh: Universitas Dian Nusantara"
                        class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5">
                </div>
            </div>

            <div class="pt-2 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-500 hover:underline"><svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>Kembali</a>
                <button type="button" onclick="startQuiz()"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 text-white dark:text-slate-950 font-extrabold text-sm shadow transition">
                    Mulai Soal 1 <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </button>
            </div>
        </section>
        @foreach($quiz->questions as $index => $question)
            <article id="question-step-{{ $index }}"
                class="hidden rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between gap-2 mb-5">
                    <span class="text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-md bg-blue-100 text-blue-800 dark:bg-slate-900 dark:text-blue-300">
                        Soal {{ $index + 1 }} dari {{ $quiz->questions->count() }}
                    </span>
                    <div role="timer" aria-live="polite" class="px-3.5 py-1.5 rounded-lg bg-amber-100 text-amber-900 dark:bg-slate-900 dark:text-amber-400 font-mono font-extrabold text-base border border-amber-300/60 dark:border-amber-500/30">
                        <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg><span id="timer-display-{{ $index }}">01:00</span>
                    </div>
                </div>

                <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-4 leading-snug">
                    {{ $question->question_text }}
                </h2>

                @if($question->code_snippet)
                    <pre class="mb-5 p-4 rounded-xl bg-slate-950 text-emerald-300 font-mono text-sm overflow-x-auto border border-slate-800"><code>{{ $question->code_snippet }}</code></pre>
                @endif

                <fieldset id="fieldset-{{ $index }}" class="space-y-2.5">
                    <legend class="sr-only">Pilihan jawaban soal {{ $index + 1 }}</legend>
                    @foreach(['a' => $question->option_a, 'b' => $question->option_b, 'c' => $question->option_c, 'd' => $question->option_d] as $key => $optionText)
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/80 cursor-pointer transition">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}"
                                class="mt-1 text-blue-600 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-600">
                            <span class="text-sm sm:text-base text-slate-800 dark:text-slate-200">
                                <strong class="uppercase mr-1">{{ $key }}.</strong> {{ $optionText }}
                            </span>
                        </label>
                    @endforeach
                </fieldset>

                <div class="mt-8 pt-5 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end">
                    @if($index < $quiz->questions->count() - 1)
                        <button type="button" onclick="lockAndNext({{ $index }})"
                            class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow transition">
                            Soal Selanjutnya <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </button>
                    @else
                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow transition">
                            <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>Kumpulkan Jawaban & Lihat Skor
                        </button>
                    @endif
                </div>
            </article>
        @endforeach
    </form>
</div>

<script>
    const totalQuestions = {{ $quiz->questions->count() }};
    let currentStep = -1;
    let timerInterval = null;

    function startQuiz() {
        const nameInput = document.getElementById('participant_name');
        if (!nameInput.value.trim()) {
            nameInput.focus();
            alert('Isi nama lengkap kamu terlebih dahulu.');
            return;
        }
        document.getElementById('step-identity').classList.add('hidden');
        goToStep(0);
    }

    function lockAndNext(stepIndex) {
        const fs = document.getElementById('fieldset-' + stepIndex);
        if (fs) fs.classList.add('pointer-events-none', 'opacity-60');
        goToStep(stepIndex + 1);
    }

    function goToStep(stepIndex) {
        if (currentStep >= 0) {
            document.getElementById('question-step-' + currentStep).classList.add('hidden');
        }
        currentStep = stepIndex;
        document.getElementById('question-step-' + currentStep).classList.remove('hidden');
        startQuestionTimer(currentStep, 60);
    }

    function startQuestionTimer(stepIdx, secondsLeft) {
        if (timerInterval) clearInterval(timerInterval);
        const clockEl = document.getElementById('timer-display-' + stepIdx);

        function renderClock(sec) {
            const mins = String(Math.floor(sec / 60)).padStart(2, '0');
            const secs = String(sec % 60).padStart(2, '0');
            if (clockEl) clockEl.textContent = `${mins}:${secs}`;
        }

        renderClock(secondsLeft);

        timerInterval = setInterval(() => {
            secondsLeft--;
            renderClock(secondsLeft);

            if (secondsLeft <= 0) {
                clearInterval(timerInterval);
                const fs = document.getElementById('fieldset-' + stepIdx);
                if (fs) fs.classList.add('pointer-events-none', 'opacity-60');

                if (stepIdx < totalQuestions - 1) {
                    goToStep(stepIdx + 1);
                } else {
                    document.getElementById('quiz-form').submit();
                }
            }
        }, 1000);
    }
</script>
@endsection
