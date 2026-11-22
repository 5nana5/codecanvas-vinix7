@extends('layouts.codecanvas')

@section('title', 'CodeCanvas — Eksplorasi Pemahaman Kode & Kompetensi Industri')

@section('content')
<section aria-labelledby="hero-heading" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-6 sm:p-10 mb-8 shadow-sm">
    <div class="max-w-3xl">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 mb-3">
            Micro-kuis interaktif
        </span>
        <h1 id="hero-heading" class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-4">
            Uji pemahaman kode dan kesiapan industri
        </h1>
        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
            Pilih kategori pelatihan VINIX7 untuk menguji kemampuan membaca potongan kode dan menyelesaikan studi kasus industri.
        </p>
    </div>

    <!-- Filter kategori -->
    <nav aria-label="Filter Kategori Kuis" class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('home') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold border transition {{ !$selectedCategory ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
            Semua Kategori
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->slug]) }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold border transition {{ $selectedCategory === $category->slug ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                <x-category-icon :name="$category->icon" /> {{ $category->name }}
            </a>
        @endforeach
    </nav>
</section>

<!-- Daftar paket kuis -->
<section aria-labelledby="catalog-heading">
    <div class="flex items-center justify-between mb-4">
        <h2 id="catalog-heading" class="text-xl font-bold text-slate-900 dark:text-white">
            Katalog micro-kuis ({{ $quizzes->count() }})
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($quizzes as $quiz)
            <article class="flex flex-col justify-between rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6 shadow-sm hover:border-blue-500 dark:hover:border-amber-400 transition">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 dark:bg-slate-900 dark:text-amber-400">
                            <x-category-icon :name="$quiz->category->icon" />{{ $quiz->category->name }}
                        </span>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            {{ $quiz->level }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                        {{ $quiz->title }}
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mb-4 line-clamp-2">
                        {{ $quiz->description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                        {{ $quiz->questions->count() }} soal • {{ $quiz->duration_minutes }} menit
                    </span>
                    <a href="{{ route('quiz.show', $quiz->slug) }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 text-white dark:text-slate-950 text-sm font-bold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Mulai Kuis <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </article>
        @empty
            <p class="col-span-3 text-center py-10 text-slate-500 dark:text-slate-400">Belum ada paket kuis pada kategori ini.</p>
        @endforelse
    </div>
</section>
@endsection
