<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Portfolio - Muhammad Ilyas')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  @hasSection('extra-styles')
    @yield('extra-styles')
  @else
    <link rel="stylesheet" href="{{ asset('style.css') }}">
  @endif
</head>
<body class="fade">
  <div class="navbar">
    <a href="{{ route('home') }}" class="logo">{{ \App\Models\Setting::getValue('site_name', 'MUHAMMAD ILYAS') }}</a>
    <div class="nav-links">
      <a href="{{ route('home') }}">Beranda</a>
      <a href="{{ route('about') }}">Tentang Saya</a>
      <a href="{{ route('home') }}#projects">Studi Kasus</a>
      <a href="{{ \App\Models\Setting::getValue('resume_url', '#') }}" target="_blank">Resume</a>
    </div>
    <div class="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  @yield('content')

  <!-- CONNECT -->
  <section class="connect" style="position:relative; z-index:1;">
    <h2>Mari Terhubung</h2>
    <p>
      {{ \App\Models\Setting::getValue('connect_text', 'Terbuka untuk peluang kolaborasi maupun diskusi lebih lanjut.') }}
    </p>
    <div class="connect-buttons">
      <a href="{{ \App\Models\Setting::getValue('resume_url', '#') }}" target="_blank" class="connect-btn">Resume</a>
      <a href="{{ \App\Models\Setting::getValue('linkedin_url', '#') }}" class="connect-btn">LinkedIn</a>
      <a href="{{ \App\Models\Setting::getValue('spotify_url', '#') }}" class="connect-btn">Spotify</a>
    </div>
    <div class="copyright">
      {{ \App\Models\Setting::getValue('copyright', '© 2026 Muhammad Ilyas. All rights reserved.') }}
    </div>
  </section>

  <script>
    window.addEventListener("load", () => {
      document.body.classList.add("show");
    });

    function navigateWithFade(url) {
      document.body.classList.remove("show");
      setTimeout(() => {
        window.location.href = url;
      }, 500);
    }

    document.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", function(e) {
        const href = this.getAttribute("href");
        if (!href || href.startsWith("#") || this.target === "_blank" || href.startsWith("http")) return;
        if (href.includes("#projects")) return;
        e.preventDefault();
        navigateWithFade(href);
      });
    });
  </script>

  <script>
    const toggle = document.querySelector(".menu-toggle");
    const nav = document.querySelector(".nav-links");
    if (toggle && nav) {
      toggle.addEventListener("click", () => {
        nav.classList.toggle("active");
      });
    }
  </script>

  @stack('scripts')
</body>
</html>