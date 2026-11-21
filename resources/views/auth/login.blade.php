<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <!-- Sisi Kiri: Branding Biru Elektrik VINIX7 -->
        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 p-12 text-white">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-white px-4 py-2 rounded-lg shadow">
                    @if(file_exists(public_path('images/logo-vinix7.png')))
                        <img src="{{ asset('images/logo-vinix7.png') }}" alt="Logo VINIX7" class="h-7 w-auto">
                    @else
                        <span class="font-black text-xl tracking-tight text-blue-700">VINIX<span class="text-amber-500">7</span></span>
                    @endif
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
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs">✓</span>
                        Kelola bank soal code-snippet & studi kasus industri
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs">✓</span>
                        Import soal massal & export rekap hasil peserta (CSV)
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold text-xs">✓</span>
                        Pemantauan verdict kesiapan karier secara real-time
                    </li>
                </ul>
            </div>

            <div class="text-xs text-blue-200">
                &copy; {{ date('Y') }} PT Vinix Seven Aurum • Divisi Web Development
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="flex flex-col justify-between p-6 sm:p-12">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-amber-400 transition">
                    ← Kembali ke Beranda
                </a>

                <button id="login-theme-toggle" type="button" aria-label="Ganti Mode Gelap atau Terang"
                    class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <span id="login-theme-icon">☀️</span>
                </button>
            </div>

            <div class="w-full max-w-md mx-auto my-auto">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#111827] p-8 shadow-xl">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                            Selamat datang kembali 👋
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
                            Masuk →
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-center text-xs text-slate-500 dark:text-slate-500">
                &copy; {{ date('Y') }} CodeCanvas VINIX7. Hak cipta dilindungi.
            </p>
        </div>
    </div>

    <script>
        const btn = document.getElementById('login-theme-toggle');
        const icon = document.getElementById('login-theme-icon');
        function updateIcon() {
            icon.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
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
