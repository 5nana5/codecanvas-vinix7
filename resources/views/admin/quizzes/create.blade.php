@extends('layouts.codecanvas')

@section('title', 'Buat Kuis Baru — CodeCanvas')

@section('content')
<div class="max-w-2xl mx-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1E293B] p-6">
    <h1 class="text-xl font-extrabold mb-4">Buat paket kuis baru</h1>
    <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="category_id" class="block text-sm font-semibold mb-1">Kategori</label>
            <select id="category_id" name="category_id" required class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="title" class="block text-sm font-semibold mb-1">Judul kuis</label>
            <input type="text" id="title" name="title" required placeholder="Contoh: Laravel & PHP Fundamentals"
                class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="level" class="block text-sm font-semibold mb-1">Tingkat Kesulitan</label>
                <select id="level" name="level" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                    <option value="Pemula">Pemula</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Lanjutan">Lanjutan</option>
                </select>
            </div>
            <div>
                <label for="duration_minutes" class="block text-sm font-semibold mb-1">Durasi (Menit)</label>
                <input type="number" id="duration_minutes" name="duration_minutes" value="5" min="1" max="60" required
                    class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
            </div>
        </div>
        <div>
            <label for="description" class="block text-sm font-semibold mb-1">Deskripsi singkat</label>
            <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-sm">Batal</a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 dark:bg-amber-400 text-white dark:text-slate-950 font-bold text-sm">Simpan dan lanjut tambah soal</button>
        </div>
    </form>
</div>
@endsection
