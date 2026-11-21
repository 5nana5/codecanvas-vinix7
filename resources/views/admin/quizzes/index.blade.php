@extends('layouts.codecanvas')

@section('title', 'Kelola Kuis — Admin CodeCanvas')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xs text-blue-600 dark:text-amber-400 hover:underline">← Kembali ke Dashboard</a>
            <h1 class="text-2xl font-extrabold mt-1">Manajemen Paket Kuis</h1>
        </div>
        <a href="{{ route('admin.quizzes.create') }}" class="px-4 py-2.5 rounded-lg bg-blue-600 dark:bg-amber-400 text-white dark:text-slate-950 font-bold text-sm">
            + Buat Kuis Baru
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-200 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 dark:bg-slate-900 uppercase text-xs">
                <tr>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Judul Kuis</th>
                    <th class="px-5 py-3">Level</th>
                    <th class="px-5 py-3">Jumlah Soal</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach($quizzes as $quiz)
                    <tr>
                        <td class="px-5 py-3.5 font-semibold">{{ $quiz->category->icon }} {{ $quiz->category->name }}</td>
                        <td class="px-5 py-3.5 font-bold">{{ $quiz->title }}</td>
                        <td class="px-5 py-3.5">{{ $quiz->level }}</td>
                        <td class="px-5 py-3.5">{{ $quiz->questions_count }} Soal</td>
                        <td class="px-5 py-3.5 text-right space-x-2">
                            <a href="{{ route('admin.quizzes.questions', $quiz) }}" class="px-3 py-1.5 rounded bg-blue-600 text-white text-xs font-bold">
                                Kelola Soal
                            </a>
                            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kuis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded bg-rose-600 text-white text-xs font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
