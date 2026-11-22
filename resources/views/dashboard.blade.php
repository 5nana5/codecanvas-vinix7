@extends('layouts.codecanvas')

@section('title', 'Dashboard Mentor VINIX7 — CodeCanvas')

@section('content')
<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Dashboard Mentor VINIX7</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">Kelola soal micro-kuis dan pantau hasil evaluasi peserta.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('dashboard.export') }}" class="px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm transition">
                <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3" /></svg>Ekspor rekap CSV
            </a>
            <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-amber-400 dark:hover:bg-amber-300 text-white dark:text-slate-950 font-bold text-sm transition">
                + Kelola kuis dan soal
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-sm font-semibold hover:bg-slate-100 dark:hover:bg-slate-800">
                    Keluar
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-200 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-lg bg-rose-100 text-rose-900 dark:bg-rose-950 dark:text-rose-200 text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

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

    <form id="bulk-delete-form" action="{{ route('dashboard.attempts.bulkDestroy') }}" method="POST"
          onsubmit="return confirm('Hapus semua data peserta yang dicentang?')">
        @csrf
        @method('DELETE')

        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] overflow-hidden">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-bold text-lg">Rekap Hasil Evaluasi Peserta Terbaru</h2>
                <button type="submit" id="btn-bulk-delete" disabled
                    class="px-3.5 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 disabled:opacity-40 disabled:cursor-not-allowed text-white text-xs font-bold transition">
                        <svg class="inline-block w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-10.5 0 .867 12.142A2.25 2.25 0 0 0 10.61 21.75h2.78a2.25 2.25 0 0 0 2.243-2.108L16.5 7.5m-6 4.125v5.25m3-5.25v5.25M9 7.5V4.875c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V7.5" /></svg>Hapus pilihan (<span id="selected-count">0</span>)
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" id="select-all" aria-label="Pilih semua data"
                                    class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 dark:bg-slate-900">
                            </th>
                            <th class="px-5 py-3">Nama Peserta</th>
                            <th class="px-5 py-3">Asal Kampus / Instansi</th>
                            <th class="px-5 py-3">Topik Kuis</th>
                            <th class="px-5 py-3">Skor</th>
                            <th class="px-5 py-3">Status Kesiapan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($recentAttempts as $item)
                            <tr class="hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="px-4 py-3.5">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                        class="row-checkbox rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 dark:bg-slate-900">
                                </td>
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
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data pengerjaan kuis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </form>
</div>

<script>
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const deleteBtn = document.getElementById('btn-bulk-delete');
    const countSpan = document.getElementById('selected-count');

    function updateBulkState() {
        const checked = document.querySelectorAll('.row-checkbox:checked').length;
        countSpan.textContent = checked;
        deleteBtn.disabled = checked === 0;
    }

    if (selectAll) {
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkState();
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateBulkState));
</script>
@endsection
