<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CodeCanvas - Sistem Web Micro-Quiz Interaktif Eksplorasi Pemahaman Kode PT Vinix Seven Aurum">
    <title>@yield('title', 'CodeCanvas — Micro-Quiz Pemahaman Kode & Karier VINIX7')</title>

    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-[#0B1120] dark:text-slate-100 transition-colors duration-200 flex flex-col antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200 dark:border-slate-800 bg-white/90 dark:bg-[#0B1120]/90 backdrop-blur">
        <nav aria-label="Navigasi Utama" class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg">
                @if(file_exists(public_path('images/Logo-VINIX7.png')))
                    <img src="{{ asset('images/Logo-VINIX7.png') }}" alt="Logo VINIX7" class="h-8 w-auto object-contain">
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-600 text-white font-black tracking-tight text-base shadow">
                        VINIX<span class="text-amber-400">7</span>
                    </span>
                @endif
                <span class="text-slate-400">|</span>
                <span class="font-bold text-blue-600 dark:text-amber-400 text-lg">CodeCanvas</span>
            </a>


            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        Panel Admin
                    </a>
                @endauth

                <button id="theme-toggle" type="button" aria-label="Ganti Mode Gelap atau Terang"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-800 dark:text-amber-300 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <span id="theme-icon" aria-hidden="true">☀️</span>
                    <span id="theme-label">Mode Terang</span>
                </button>
            </div>
        </nav>
    </header>

    <main id="main-content" class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 dark:border-slate-800 py-6 text-center text-sm text-slate-600 dark:text-slate-400">
        <p>&copy; {{ date('Y') }} CodeCanvas — Divisi Web Development PT Vinix Seven Aurum (VINIX7).</p>
    </footer>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeLabel = document.getElementById('theme-label');

        function syncThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
            themeLabel.textContent = isDark ? 'Mode Terang' : 'Mode Gelap';
            themeBtn.setAttribute('aria-label', isDark ? 'Ubah ke Mode Terang' : 'Ubah ke Mode Gelap');
        }

        syncThemeUI();

        themeBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            syncThemeUI();
        });
    </script>
</body>
</html>
