<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-vinix7.png') }}">
    <title>Daftar Mentor — CodeCanvas VINIX7</title>
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-slate-100 antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Branding -->
        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 p-12 text-white">
            <div>
                <a href="{{ route('home') }}" class="inline-flex">
                    <x-application-logo image-class="h-7 w-auto block object-contain" />
                </a>
            </div>

            <div class="max-w-md space-y-6">
                <h1 class="text-4xl font-extrabold leading-tight">
                    Belajar tanpa batas, tumbuh tanpa henti.
                </h1>
                <p class="text-blue-100 text-base leading-relaxed">
                    PT Vinix Seven Aurum. Membentuk talenta yang siap bersaing untuk Indonesia Emas 2045 melalui teknologi dan pendidikan.
                </p>
                <ul class="space-y-3.5 text-sm font-medium text-blue-50">
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Kelola soal dan studi kasus pembelajaran
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Unggah dan ekspor data evaluasi peserta (.csv)
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Siap diintegrasikan ke ekosistem LMS VINIX7
                    </li>
                </ul>
            </div>

            <div class="text-xs text-blue-200">
                © {{ date('Y') }} CodeCanvas VINIX7. Hak cipta dilindungi.
            </div>
        </div>

        <!-- Formulir daftar akun -->
        <div class="flex flex-col justify-between p-6 sm:p-12">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-amber-400 transition">
                    <svg class="inline w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>Kembali ke beranda
                </a>

                <button id="reg-theme-toggle" type="button" aria-label="Ganti Mode Gelap atau Terang"
                    class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <span id="reg-theme-icon">
                        <svg class="w-4 h-4 hidden" data-theme-icon="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-2.227-1.591 1.591M5.25 12H3m2.227-4.773L6.818 8.82m8.596 3.18a3.414 3.414 0 1 1-6.828 0 3.414 3.414 0 0 1 6.828 0Z" />
                        </svg>
                        <svg class="w-4 h-4" data-theme-icon="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75a9.75 9.75 0 0 1-9.75-9.75c0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25 9.75 9.75 0 0 0 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </span>
                </button>
            </div>

            <div class="w-full max-w-md mx-auto my-auto">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-8 shadow-xl">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                            Buat akun baru <svg class="inline-block w-4 h-4 ml-1 align-text-bottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.485-2.485L14.25 6l1.006-.23a3.375 3.375 0 0 0 2.485-2.485L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.485 2.485L21.75 6l-1.006.23a3.375 3.375 0 0 0-2.485 2.485Z" /></svg>
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Daftarkan akun Mentor / Admin untuk mengelola CodeCanvas.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3.5 rounded-lg bg-rose-100 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold mb-1">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold mb-1">Kata Sandi</label>
                            <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold mb-1">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm">
                        </div>

                        <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg transition">
                            Daftar Sekarang <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </button>
                    </form>

                    <p class="mt-5 text-center text-xs text-slate-600 dark:text-slate-400">
                        Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 dark:text-amber-400 hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        const regBtn = document.getElementById('reg-theme-toggle');
        const regIcon = document.getElementById('reg-theme-icon');
        function updateRegIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            regIcon.querySelector('[data-theme-icon="sun"]').classList.toggle('hidden', !isDark);
            regIcon.querySelector('[data-theme-icon="moon"]').classList.toggle('hidden', isDark);
        }
        updateRegIcon();
        regBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            updateRegIcon();
        });
    </script>
</body>
</html>
