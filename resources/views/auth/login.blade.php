<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-vinix7.png') }}">
    <title>Masuk Mentor — CodeCanvas VINIX7</title>
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
                    Portal manajemen evaluasi dan bank soal interaktif <strong>CodeCanvas</strong> PT Vinix Seven Aurum untuk mengukur kesiapan talenta digital Indonesia.
                </p>

                <ul class="space-y-3.5 text-sm font-medium text-blue-50">
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Kelola soal dan studi kasus industri
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Unggah soal sekaligus dan ekspor hasil peserta (.csv)
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></span>
                        Pantau kesiapan karier peserta secara berkala
                    </li>
                </ul>
            </div>

            <div class="text-xs text-blue-200">
                © {{ date('Y') }} CodeCanvas VINIX7. Hak cipta dilindungi.
            </div>
        </div>

        <!-- Formulir masuk -->
        <div class="flex flex-col justify-between p-6 sm:p-12">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-amber-400 transition">
                    <svg class="inline w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>Kembali ke beranda
                </a>

                <button id="login-theme-toggle" type="button" aria-label="Ganti Mode Gelap atau Terang"
                    class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <span id="login-theme-icon">
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
                            Selamat datang kembali <svg class="inline-block w-4 h-4 ml-1 align-text-bottom" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 16.5a7.488 7.488 0 0 0-5.982 2.225m11.964 0a9 9 0 1 0-11.964 0m11.964 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Masuk sebagai Mentor / Admin untuk mengelola CodeCanvas.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-3.5 rounded-lg bg-rose-100 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs font-medium">
                            Email atau kata sandi tidak sesuai. Silakan periksa kembali.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold mb-1.5 text-slate-700 dark:text-slate-300">
                                Alamat Email
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', 'admin@vinix7.id') }}" required autofocus
                                placeholder="nama@email.com"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold mb-1.5 text-slate-700 dark:text-slate-300">
                                Kata Sandi
                            </label>
                            <input id="password" type="password" name="password" required
                                placeholder="Masukkan kata sandi"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-[#0B1120] text-slate-900 dark:text-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <label class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 dark:bg-slate-900">
                                <span>Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg shadow-blue-600/20 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Masuk <svg class="inline-block w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </button>
                        <p class="mt-5 text-center text-xs text-slate-600 dark:text-slate-400">
                            Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-blue-600 dark:text-amber-400 hover:underline">Daftar di sini</a>
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const btn = document.getElementById('login-theme-toggle');
        const icon = document.getElementById('login-theme-icon');
        function updateIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            icon.querySelector('[data-theme-icon="sun"]').classList.toggle('hidden', !isDark);
            icon.querySelector('[data-theme-icon="moon"]').classList.toggle('hidden', isDark);
        }
        updateIcon();
        btn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            updateIcon();
        });
    </script>
</body>
</html>
