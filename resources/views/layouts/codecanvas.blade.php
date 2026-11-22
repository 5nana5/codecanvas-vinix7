<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-vinix7.png') }}">
    <meta name="description" content="CodeCanvas - platform micro-kuis interaktif untuk menguji pemahaman kode dan kesiapan karier PT Vinix Seven Aurum">
    <title>@yield('title', 'CodeCanvas — Micro-kuis pemahaman kode dan karier VINIX7')</title>

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
                <x-application-logo />
                <span class="text-slate-400">|</span>
                <span class="font-bold text-blue-600 dark:text-amber-400 text-lg">CodeCanvas</span>
            </a>


            <div class="flex items-center gap-3">
                @auth
                    @if(request()->routeIs('dashboard*', 'admin.*'))
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                            Panel Admin
                        </a>
                    @endif
                @endauth

                <button id="theme-toggle" type="button" aria-label="Ganti Mode Gelap atau Terang"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-800 dark:text-amber-300 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <span id="theme-icon" aria-hidden="true">
                        <svg class="w-4 h-4 hidden" data-theme-icon="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-2.227-1.591 1.591M5.25 12H3m2.227-4.773L6.818 8.82m8.596 3.18a3.414 3.414 0 1 1-6.828 0 3.414 3.414 0 0 1 6.828 0Z" />
                        </svg>
                        <svg class="w-4 h-4" data-theme-icon="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75a9.75 9.75 0 0 1-9.75-9.75c0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25 9.75 9.75 0 0 0 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </span>
                    <span id="theme-label">Mode Terang</span>
                </button>
            </div>
        </nav>
    </header>

    <main id="main-content" class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 dark:border-slate-800 py-6 text-center text-sm text-slate-600 dark:text-slate-400">
        <p>
            &copy; {{ date('Y') }} CodeCanvas by VINIX7 • PT Vinix Seven Aurum
            <span class="mx-2">•</span>
            <a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-blue-600 dark:hover:text-amber-400 underline">
                Portal Mentor
            </a>
        </p>
    </footer>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeLabel = document.getElementById('theme-label');

        function syncThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            themeIcon.querySelector('[data-theme-icon="sun"]').classList.toggle('hidden', !isDark);
            themeIcon.querySelector('[data-theme-icon="moon"]').classList.toggle('hidden', isDark);
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
