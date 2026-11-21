@extends('layouts.codecanvas')

@section('title', $quiz->title . ' — CodeCanvas')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-5">
        <div>
            <span class="text-xs font-bold uppercase text-blue-600 dark:text-amber-400">{{ $quiz->category->name }} • {{ $quiz->level }}</span>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $quiz->title }}</h1>
        </div>
        <div role="timer" aria-live="polite" class="px-4 py-2 rounded-lg bg-amber-100 text-amber-900 dark:bg-slate-800 dark:text-amber-400 font-mono font-bold text-lg">
            ⏱️ <span id="countdown">{{ sprintf('%02d:00', $quiz->duration_minutes) }}</span>
        </div>
    </div>

    <form id="quiz-form" action="{{ route('quiz.submit', $quiz->slug) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Identitas Singkat Peserta -->
        
            Data Singkat Peserta</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="participant_name" class="block text-sm font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="participant_name" name="participant_name" required placeholder="Contoh: Nanda Rahayu"
                        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="university" class="block text-sm font-semibold mb-1">Asal Perguruan Tinggi / Instansi</label>
                    <input type="text" id="university" name="university" placeholder="Contoh: Universitas Dian Nusantara"
                        class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </section>

        <!-- Daftar Kartu Soal -->
        @foreach($quiz->questions as $index => $question)
            <article class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-blue-100 text-blue-800 dark:bg-slate-900 dark:text-blue-300">
                        Soal {{ $index + 1 }} dari {{ $quiz->questions->count() }}
                    </span>
                </div>

                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white mb-4">
                    {{ $question->question_text }}
                </h3>

                 @if($question->question_type === 'multiple_choice')
                    <fieldset class="space-y-2.5">
                        <legend class="sr-only">Pilihan jawaban untuk soal nomor {{ $index + 1 }}</legend>
                        @foreach(['a' => $question->option_a, 'b' => $question->option_b, 'c' => $question->option_c, 'd' => $question->option_d] as $key => $optionText)
                            <label class="flex items-start gap-3 p-3.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/80 cursor-pointer transition">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" required
                                    class="mt-1 text-blue-600 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-600">
                                <span class="text-sm sm:text-base text-slate-800 dark:text-slate-200">
                                    <strong class="uppercase mr-1">{{ $key }}.</strong> {{ $optionText }}
                                </span>
                            </label>
                        @endforeach
                    </fieldset>
                @elseif($question->question_type === 'short_answer')
                    <div>
                        <label for="ans_{{ $question->id }}" class="block text-xs font-bold uppercase text-slate-500 dark:text-slate-400 mb-1.5">
                            Jawaban Singkat Anda:
                        </label>
                        <input type="text" id="ans_{{ $question->id }}" name="answers[{{ $question->id }}]" required
                            placeholder="Ketik jawaban singkat di sini..."
                            class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>
                @else
                    <div>
                        <label for="ans_{{ $question->id }}" class="block text-xs font-bold uppercase text-slate-500 dark:text-slate-400 mb-1.5">
                            Jawaban Narasi / Penjelasan Anda:
                        </label>
                        <textarea id="ans_{{ $question->id }}" name="answers[{{ $question->id }}]" rows="4" required
                            placeholder="Tuliskan penjelasan atau analisis Anda secara ringkas..."
                            class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                @endif
            </article>
        @endforeach

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:underline">
                ← Batal & Kembali
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 text-white dark:text-slate-950 font-extrabold text-base shadow transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                Kumpulkan Jawaban & Lihat Skor
            </button>
        </div>
    </form>
</div>

<script>
    let totalSeconds = {{ $quiz->duration_minutes * 60 }};
    const countdownEl = document.getElementById('countdown');
    const timer = setInterval(() => {
        totalSeconds--;
        const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
        const secs = String(totalSeconds % 60).padStart(2, '0');
        countdownEl.textContent = `${mins}:${secs}`;
        if (totalSeconds <= 0) {
            clearInterval(timer);
            document.getElementById('quiz-form').submit();
        }
    }, 1000);
</script>
@endsection
