@extends('layouts.codecanvas')

@section('title', 'Dashboard Mentor VINIX7 — CodeCanvas')

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Dashboard Mentor VINIX7</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">Kelola bank soal micro-quiz dan pantau hasil evaluasi kesiapan peserta.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard.export') }}" class="px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm transition">
                ⬇ Export Rekap CSV
            </a>
            <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 text-white dark:text-slate-950 font-bold text-sm transition">
                + Kelola Kuis & Bank Soal
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-sm font-semibold hover:bg-slate-100 dark:hover:bg-slate-800">
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B]">
            <p class="text-xs text-slate-500 dark:text-slate-400">Kategori</p>
            <p class="text-2xl font-black mt-1">{{ $stats['categories'] }}</p>
        </div>
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B]">
            <p class="text-xs text-slate-500 dark:text-slate-400">Paket Kuis</p>
            <p class="text-2xl font-black mt-1">{{ $stats['quizzes'] }}</p>
        </div>
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B]">
            <p class="text-xs text-slate-500 dark:text-slate-400">Total Soal</p>
            <p class="text-2xl font-black mt-1">{{ $stats['questions'] }}</p>
        </div>
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B]">
            <p class="text-xs text-slate-500 dark:text-slate-400">Total Pengerjaan</p>
            <p class="text-2xl font-black mt-1">{{ $stats['attempts'] }}</p>
        </div>
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B]">
            <p class="text-xs text-slate-500 dark:text-slate-400">Rata-rata Skor</p>
            <p class="text-2xl font-black mt-1 text-blue-600 dark:text-amber-400">{{ $stats['avg_score'] }}</p>
        </div>
    </div>

    <!-- Tabel Riwayat Peserta -->
    <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] overflow-hidden">
        <div class="p-5 border-b border-slate-200 dark:border-slate-800">
            <h2 class="font-bold text-lg">Rekap Hasil Evaluasi Peserta Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Nama Peserta</th>
                        <th class="px-5 py-3">Perguruan Tinggi</th>
                        <th class="px-5 py-3">Topik Kuis</th>
                        <th class="px-5 py-3">Skor</th>
                        <th class="px-5 py-3">Verdict Kesiapan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($recentAttempts as $item)
                        <tr>
                            <td class="px-5 py-3.5 font-semibold">{{ $item->participant_name }}</td>
                            <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">{{ $item->university }}</td>
                            <td class="px-5 py-3.5">{{ $item->quiz->title }}</td>
                            <td class="px-5 py-3.5 font-bold">{{ $item->score }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800 dark:bg-slate-800 dark:text-amber-400">
                                    {{ $item->readiness_verdict }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
