<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - @yield('title', 'Dashboard')</title>
  <script>
    (function () {
      try {
        var t = localStorage.getItem('admin-theme');
        if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark');
        }
      } catch (e) {}
    })();
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' };</script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    [x-cloak] { display: none !important; }

    body, aside, header, main,
    .bg-white, .bg-gray-50, .bg-gray-100, .bg-gray-200,
    input, textarea, select, button, a {
      transition: background-color .3s ease, border-color .3s ease, color .3s ease;
    }

    /* ===== Dark theme surface remap ===== */
    .dark { color-scheme: dark; }
    .dark body { background-color: #070d1a !important; color: #e2e8f0 !important; }
    .dark .bg-gray-100 { background-color: #070d1a !important; }
    .dark .bg-white { background-color: #0f1a2e !important; }
    .dark .bg-gray-50 { background-color: #0b1526 !important; }
    .dark .bg-gray-50\/60 { background-color: rgba(11, 21, 38, .6) !important; }
    .dark .bg-gray-50\/50 { background-color: rgba(11, 21, 38, .5) !important; }
    .dark .bg-gray-50\/40 { background-color: rgba(11, 21, 38, .4) !important; }
    .dark .bg-gray-200 { background-color: #1e293b !important; }
    .dark .hover\:bg-gray-50:hover { background-color: #0b1526 !important; }
    .dark .hover\:bg-gray-100:hover { background-color: #0b1526 !important; }
    .dark .hover\:bg-gray-200:hover { background-color: #1e293b !important; }

    .dark .text-gray-800 { color: #f1f5f9 !important; }
    .dark .text-gray-700 { color: #e2e8f0 !important; }
    .dark .text-gray-600 { color: #cbd5e1 !important; }
    .dark .text-gray-500 { color: #94a3b8 !important; }
    .dark .text-gray-400 { color: #64748b !important; }
    .dark .text-gray-300 { color: #475569 !important; }
    .dark .hover\:text-gray-800:hover { color: #f1f5f9 !important; }
    .dark .hover\:text-gray-700:hover { color: #e2e8f0 !important; }
    .dark .hover\:text-gray-600:hover { color: #cbd5e1 !important; }
    .dark .hover\:text-gray-300:hover { color: #94a3b8 !important; }

    .dark .border-gray-100 { border-color: #1b2942 !important; }
    .dark .border-gray-200 { border-color: #27354e !important; }
    .dark .border-gray-300 { border-color: #27354e !important; }
    .dark .hover\:border-gray-700:hover { border-color: #334155 !important; }

    .dark input, .dark textarea, .dark select { color: #e2e8f0 !important; }
    .dark input::placeholder, .dark textarea::placeholder { color: #64748b !important; }
    .dark input[type="checkbox"] { background-color: #0f1a2e; }

    .dark .bg-green-50 { background-color: rgba(16, 185, 129, .1) !important; }
    .dark .text-green-700 { color: #6ee7b7 !important; }
    .dark .border-green-200 { border-color: rgba(16, 185, 129, .3) !important; }
    .dark .bg-red-50 { background-color: rgba(239, 68, 68, .1) !important; }
    .dark .text-red-700 { color: #fca5a5 !important; }
    .dark .border-red-200 { border-color: rgba(239, 68, 68, .3) !important; }

    .dark .bg-indigo-50 { background-color: rgba(99, 102, 241, .12) !important; }
    .dark .bg-emerald-50 { background-color: rgba(16, 185, 129, .12) !important; }
    .dark .bg-amber-50 { background-color: rgba(245, 158, 11, .12) !important; }
    .dark .bg-violet-50 { background-color: rgba(139, 92, 246, .12) !important; }
    .dark .bg-sky-50 { background-color: rgba(14, 165, 233, .12) !important; }

    .dark .from-indigo-100 { --tw-gradient-from: #1a2440 !important; }
    .dark .from-indigo-100.to-violet-100 { --tw-gradient-to: #241b52 !important; }

    .dark .stats, .dark .shadow-sm { box-shadow: 0 1px 2px rgba(0, 0, 0, .4) !important; }

    .theme-toggle:hover svg { transform: rotate(18deg) scale(1.08); }
    .theme-toggle svg { transition: transform .3s ease; }
    .theme-toggle .icon-sun { display: none; }
    .dark .theme-toggle .icon-sun { display: block; }
    .dark .theme-toggle .icon-moon { display: none; }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="flex min-h-screen">
    @include('admin.layouts.sidebar')

    <div class="flex-1 flex flex-col ml-64">
      <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-30">
        <h1 class="text-xl font-bold text-gray-800">@yield('header-title', 'Dashboard')</h1>
        <div class="flex items-center gap-2">
          <button type="button" id="theme-toggle" title="Ganti tema" aria-label="Ganti tema"
            class="theme-toggle w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-500 flex items-center justify-center transition-colors duration-200">
            <svg class="icon-moon w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
            <svg class="icon-sun w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
          </button>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-medium px-3 py-2">Keluar</button>
          </form>
        </div>
      </header>

      <main class="flex-1 p-8">
        @if (session('success'))
          <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
          <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        @yield('content')
      </main>
    </div>
  </div>

  @stack('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('#theme-toggle');
      if (!btn) return;
      var root = document.documentElement;
      var isDark = root.classList.toggle('dark');
      try { localStorage.setItem('admin-theme', isDark ? 'dark' : 'light'); } catch (e) {}
    });
  </script>
</body>
</html>