@extends('layouts.app')

@section('title', 'Studi Kasus - ' . $project->title)

@if ($caseStudy->layout === 'data')
  @section('extra-styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('pantau.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            animation: {
              fadeInUp: "fadeInUp 1s ease-out both",
            },
            keyframes: {
              fadeInUp: {
                "0%": { opacity: "0", transform: "translateY(30px)" },
                "100%": { opacity: "1", transform: "translateY(0)" },
              },
            },
          },
        },
      };
    </script>
    <style>
      body { font-family: 'Poppins', sans-serif; }
      html { scroll-behavior: smooth; }
    </style>
  @endsection
@else
  @section('extra-styles')
    <link rel="stylesheet" href="{{ asset('tanggap.css') }}">
  @endsection
@endif

@section('content')
  @php
    $empathize = $sections->where('type', 'empathize')->first();
    $define = $sections->where('type', 'define')->first();
    $ideate = $sections->where('type', 'ideate')->first();
    $prototype = $sections->where('type', 'prototype')->first();
    $test = $sections->where('type', 'test')->first();
    $dataSources = $sections->where('type', 'data_sources')->first();
    $featureEng = $sections->where('type', 'feature_engineering')->first();
    $modelPerf = $sections->where('type', 'model_performance')->first();
  @endphp

  @if ($caseStudy->layout === 'data')
    {{-- ========== DATA ANALYST LAYOUT (PANTAU) ========== --}}
    @php
      $banners = ['pantau/banner1.jpg', 'pantau/banner2.jpg', 'pantau/banner3.jpg'];
      $ds = $dataSources ? $dataSources->content : [];
      $fe = $featureEng ? $featureEng->content : [];
      $mp = $modelPerf ? $modelPerf->content : [];
    @endphp

    <div class="navbar" style="background:rgba(0,0,0,0.5);">
      <a href="{{ route('home') }}" class="logo">MUHAMMAD ILYAS</a>
      <div class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('about') }}">Tentang Saya</a>
        <a href="{{ \App\Models\Setting::getValue('resume_url', '#') }}" target="_blank">Resume</a>
      </div>
      <div class="menu-toggle">
        <span></span><span></span><span></span>
      </div>
    </div>

    <section id="home" class="relative h-screen overflow-hidden">
      <div id="carousel" class="absolute inset-0 flex transition-transform duration-1000 ease-in-out">
        @foreach (array_merge($banners, $banners) as $banner)
          <div class="min-w-full h-full bg-cover bg-center" style="background-image: url('{{ asset_url($banner) }}')"></div>
        @endforeach
      </div>
      <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 z-10"></div>

      <div class="relative z-20 text-center text-white flex items-center justify-center h-full">
        <div>
          <span class="text-sm md:text-base tracking-widest uppercase font-extrabold block">{{ $project->title }}</span>
          <h1 class="text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-2xl tracking-tight leading-[1.3]">{{ $project->subtitle }}</h1>
          <p class="text-lg md:text-2xl mb-10 max-w-3xl mx-auto text-gray-200">{{ $caseStudy->tagline }}</p>
          <div class="hero-meta" style="display:flex; justify-content:center; gap:30px; margin-top:20px;">
            <div class="meta-item"><span>Role</span><p>{{ $caseStudy->role }}</p></div>
            <div class="meta-item"><span>Tools</span><p>{{ $caseStudy->tools }}</p></div>
            <div class="meta-item"><span>Durasi</span><p>{{ $caseStudy->duration }}</p></div>
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="relative bg-gray-900 py-24 px-6 lg:px-20">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div>
          <h2 class="text-sm uppercase tracking-widest text-red-500 font-semibold mb-3">TENTANG PANTAU</h2>
          <h3 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">Meningkatkan Ketahanan Pangan<br />Lewat Inovasi Data & Teknologi</h3>
          <p class="text-lg text-gray-300 leading-relaxed mb-6">{{ $caseStudy->background }}</p>
          <div class="hero-meta" style="display:flex; gap:40px; flex-wrap:wrap; margin-bottom:20px;">
            <div class="meta-item"><span>Role</span><p>{{ $caseStudy->role }}</p></div>
            <div class="meta-item"><span>Tools</span><p>{{ $caseStudy->tools }}</p></div>
            <div class="meta-item"><span>Durasi</span><p>{{ $caseStudy->duration }}</p></div>
          </div>
        </div>
        <div class="relative mt-12">
          <img src="{{ asset_url($banners[0]) }}" alt="Pantau" class="w-full max-w-4xl mx-auto rounded-2xl shadow-2xl object-cover" />
          <div class="absolute bottom-4 left-4 bg-gray-800/80 backdrop-blur-md shadow-lg px-5 py-4 rounded-xl w-[320px] border-l-4 border-red-500">
            <p class="text-sm text-gray-300 mb-1">📈 Fakta Terkini</p>
            <p class="text-base font-semibold text-white leading-snug">Harga cabai rawit melonjak hingga <span class="text-red-500 font-bold">140%</span> hanya dalam waktu <span class="font-bold">3 minggu</span> pada tahun 2024.</p>
          </div>
        </div>
      </div>
    </section>

    @if ($ds)
    <section class="relative bg-cover bg-center py-40 px-6" style="background-image: url('{{ asset_url($banners[2]) }}');">
      <div class="absolute inset-0 bg-black/70"></div>
      <div class="relative z-10 max-w-6xl mx-auto text-center text-white space-y-10 animate-fadeInUp">
        <h2 class="text-4xl md:text-5xl font-bold md:font-extrabold leading-snug tracking-wide">{{ $ds['title'] ?? 'Sumber Data' }}</h2>
        <p class="text-lg md:text-xl text-gray-300 leading-relaxed">{{ $ds['description'] ?? '' }}</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-center mt-10">
          @if (isset($ds['weather_data']))
            <div class="bg-white/10 p-6 rounded-2xl backdrop-blur-md border border-white/20">
              <h3 class="text-xl font-semibold mb-4">🌤️ Data Cuaca</h3>
              <ul class="space-y-2 text-gray-200 mb-4">
                @foreach ($ds['weather_data']['indicators'] ?? [] as $indicator)
                  <li>{{ $indicator }}</li>
                @endforeach
              </ul>
              <p class="text-xs text-gray-400">Sumber data: {{ $ds['weather_data']['source'] ?? '' }}</p>
            </div>
          @endif
          @if (isset($ds['price_data']))
            <div class="bg-white/10 p-6 rounded-2xl backdrop-blur-md border border-white/20">
              <h3 class="text-xl font-semibold mb-4">📊 Data Harga</h3>
              <ul class="space-y-2 text-gray-200 mb-4">
                @foreach ($ds['price_data']['indicators'] ?? [] as $indicator)
                  <li>{{ $indicator }}</li>
                @endforeach
              </ul>
              <p class="text-xs text-gray-400">Sumber data: {{ $ds['price_data']['source'] ?? '' }}</p>
            </div>
          @endif
        </div>
      </div>
    </section>
    @endif

    @if ($fe)
    <section id="feature-engineering" class="relative py-32 px-6 bg-gray-950 text-white">
      <div class="max-w-5xl mx-auto text-center space-y-10 animate-fadeInUp">
        <h2 class="text-4xl md:text-5xl font-bold tracking-wide">{{ $fe['title'] ?? 'Feature Engineering' }}</h2>
        @if (isset($fe['background_model']))
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 text-left space-y-4">
          <h3 class="text-xl font-semibold">Latar Belakang Model</h3>
          <p class="text-gray-300 leading-relaxed">{{ $fe['background_model'] }}</p>
        </div>
        @endif
        @if (isset($fe['challenge']))
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 text-left space-y-4">
          <h3 class="text-xl font-semibold">Tantangan Utama</h3>
          <p class="text-gray-300 leading-relaxed">{{ $fe['challenge'] }}</p>
        </div>
        @endif
        <div class="grid md:grid-cols-2 gap-6 text-left">
          @foreach ($fe['features'] ?? [] as $feature)
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
              <h3 class="text-lg font-semibold mb-3">{{ $feature['title'] ?? '' }}</h3>
              <p class="text-gray-300">{{ $feature['description'] ?? '' }}</p>
            </div>
          @endforeach
        </div>
        @if (isset($fe['insight']))
        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-8 text-left">
          <h3 class="text-xl font-semibold mb-3">Insight</h3>
          <p class="text-gray-300 leading-relaxed">{{ $fe['insight'] }}</p>
        </div>
        @endif
      </div>
    </section>
    @endif

    @if ($mp)
    <section id="model-performance" class="relative py-32 px-6 bg-gray-950 text-white">
      <div class="max-w-6xl mx-auto space-y-12 animate-fadeInUp">
        <section id="evaluasi" class="space-y-10">
          <div class="text-center space-y-4">
            <h2 class="text-4xl md:text-5xl font-bold tracking-wide">{{ $mp['title'] ?? 'Model Performance' }}</h2>
            <p class="text-gray-400 text-lg">{{ $mp['subtitle'] ?? '' }}</p>
          </div>
          <div class="grid md:grid-cols-4 gap-6 text-center">
            @foreach ($mp['metrics'] ?? [] as $metric)
              <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                <h3 class="text-gray-400 text-sm uppercase tracking-widest">{{ $metric['label'] ?? '' }}</h3>
                <p class="text-3xl font-bold mt-2">{{ $metric['value'] ?? '' }}</p>
                <p class="text-gray-500 text-sm mt-2">{{ $metric['description'] ?? '' }}</p>
              </div>
            @endforeach
          </div>
          @if (isset($mp['chart_image']))
          <div class="bg-white/5 border border-white/10 rounded-2xl p-6 space-y-4">
            <h3 class="text-xl font-semibold">Perbandingan hasil prediksi dan data asli</h3>
            <div class="rounded-xl overflow-hidden border border-white/10">
              <img src="{{ asset_url($mp['chart_image']) }}" alt="Actual vs Prediction Chart" class="w-full h-auto object-cover">
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">{{ $mp['chart_insight'] ?? '' }}</p>
          </div>
          @endif
          @if (isset($mp['key_insight']))
          <div class="bg-white/5 border border-white/10 rounded-2xl p-8 text-center space-y-3">
            <h3 class="text-xl font-semibold">Key Insight</h3>
            <p class="text-gray-400">{{ $mp['key_insight'] }}</p>
          </div>
          @endif
        </section>
      </div>
    </section>
    @endif

    <footer id="contact" class="bg-gray-900 text-white py-16 px-6">
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        <div>
          <h3 class="text-2xl font-bold mb-4">{{ $project->title }}.id</h3>
          <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $caseStudy->footer_description ?? $project->description }}</p>
          <p class="text-sm text-gray-500">{{ \App\Models\Setting::getValue('copyright') }}</p>
        </div>
        <div>
          <h3 class="text-2xl font-bold mb-2">Mari Terhubung</h3>
          <p class="text-gray-400 text-sm mb-2">Temukan saya di platform berikut:</p>
          <div class="flex flex-col gap-3">
            <a href="{{ \App\Models\Setting::getValue('resume_url', '#') }}" class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 transition px-4 py-3 rounded-xl text-sm font-semibold">📄 Resume</a>
            <a href="{{ \App\Models\Setting::getValue('linkedin_url', '#') }}" class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 transition px-4 py-3 rounded-xl text-sm font-semibold">💼 LinkedIn</a>
          </div>
        </div>
      </div>
    </footer>

    @push('scripts')
    <script>
      const carousel = document.getElementById("carousel");
      if (carousel) {
        const slides = carousel.children.length / 2;
        let currentIndex = 0;
        function slide() {
          currentIndex++;
          carousel.style.transition = "transform 1s ease-in-out";
          carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
          if (currentIndex === slides) {
            setTimeout(() => {
              carousel.style.transition = "none";
              carousel.style.transform = `translateX(0)`;
              currentIndex = 0;
            }, 1000);
          }
        }
        setInterval(slide, 3000);
      }
    </script>
    @endpush

  @else
    {{-- ========== UX DESIGN LAYOUT (TANGGAP/BINBOL/SIAGA) ========== --}}
    @php
      $heroBg = $caseStudy->hero_bg ?: ('img/' . strtolower($project->slug) . '2.png');
    @endphp

    <style>
      .case-hero {
        height: 100vh;
        background: url("{{ asset_url($heroBg) }}") center/cover no-repeat;
      }
    </style>

    <div class="navbar">
      <a href="{{ route('home') }}" class="logo">MUHAMMAD ILYAS</a>
      <div class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('about') }}">Tentang Saya</a>
        <a href="{{ route('home') }}#projects">Studi Kasus</a>
        <a href="{{ \App\Models\Setting::getValue('resume_url', '#') }}" target="_blank">Resume</a>
      </div>
      <div class="menu-toggle">
        <span></span><span></span><span></span>
      </div>
    </div>

    <div class="case-hero">
      <div class="case-intro">
        <h1>{{ $project->title }}</h1>
        <p class="case-desc">{{ $project->subtitle }}</p>
        <p class="case-tagline">{{ $caseStudy->tagline }}</p>
      </div>
    </div>

    <section class="section" id="overview">
      <div class="overview-box">
        <h2>RINGKASAN</h2>
        <div class="overview-meta">
          <div>
            <span>Durasi</span>
            <p style="color:#fff;">{{ $caseStudy->duration }}</p>
          </div>
          <div>
            <span>Role</span>
            <p style="color:#fff;">{{ $caseStudy->role }}</p>
          </div>
          <div>
            <span>Tools</span>
            <p style="color:#fff;">{{ $caseStudy->tools }}</p>
          </div>
        </div>

        @if ($caseStudy->figma_prototype_url)
        <a href="{{ $caseStudy->figma_prototype_url }}" target="_blank" class="case-button-primary">VIEW PROTOTYPE</a>
        @endif

        @if ($caseStudy->background)
        <div class="overview-block">
          <h3>Latar Belakang</h3>
          <p>{{ $caseStudy->background }}</p>
        </div>
        @endif
        @if ($caseStudy->problem)
        <div class="overview-block">
          <h3>Masalah</h3>
          <p>{{ $caseStudy->problem }}</p>
        </div>
        @endif
        @if ($caseStudy->goal)
        <div class="overview-block">
          <h3>Tujuan Proyek</h3>
          <p>{{ $caseStudy->goal }}</p>
        </div>
        @endif
      </div>
    </section>

    <section class="process-section">
      <h2 class="process-title">PROSES KERJA</h2>
      <div class="process-grid">
        @php $icons = ['empathize.png', 'define.png', 'ideate.png', 'proto.png', 'test.png']; @endphp
        @foreach (['Empathize', 'Define', 'Ideate', 'Prototype', 'Test'] as $i => $step)
          <a href="#{{ strtolower($step) }}" class="process-item">
            <img src="{{ asset('img/' . $icons[$i]) }}" alt="{{ $step }}">
            <p>{{ strtoupper($step) }}</p>
          </a>
        @endforeach
      </div>
    </section>

    @if ($empathize)
      @php $e = $empathize->content; @endphp
      <section id="empathize" class="section empathize">
        <h2>EMPATHIZE</h2>
        <div class="overview-content">
          @if (isset($e['research_context']))
          <div class="overview-block">
            <h3>Konteks Penelitian</h3>
            <p>{{ $e['research_context'] }}</p>
          </div>
          @endif
          @if (isset($e['method']))
          <div class="overview-block">
            <h3>Metode Penelitian</h3>
            <p>{{ $e['method'] }}</p>
          </div>
          @endif
        </div>

        @if (isset($e['user_types']) && $e['user_types'])
        <div class="persona-grid">
          @foreach ($e['user_types'] as $userType)
            <div class="persona-card">
              <h3>{{ $userType['title'] ?? '' }}</h3>
              <p class="persona-desc">{{ $userType['description'] ?? '' }}</p>
              <ul>
                @foreach ($userType['behaviors'] ?? [] as $behavior)
                  <li>{{ $behavior }}</li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
        @endif

        @if (isset($e['pain_points']) && $e['pain_points'])
        <div class="overview-content">
          <div class="overview-block">
            <h3>Pain Points</h3>
            <ul>
              @foreach ($e['pain_points'] as $pain)
                <li>{{ $pain }}</li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif

        @if (isset($e['insight']))
        <div class="overview-content">
          <div class="overview-block">
            <h3>Insight Utama</h3>
            <p>{{ $e['insight'] }}</p>
          </div>
        </div>
        @endif
      </section>
    @endif

    @if ($define)
      @php $d = $define->content; @endphp
      <section id="define" class="section define">
        <h2>DEFINE</h2>
        <div class="define-container">
          @if (isset($d['summary']))
          <div class="define-block">
            <div class="label">Ringkasan</div>
            <p>{{ $d['summary'] }}</p>
          </div>
          @endif
          @if (isset($d['insight']))
          <div class="define-block">
            <div class="label">Insight Utama</div>
            <p>{{ $d['insight'] }}</p>
          </div>
          @endif

          @if (isset($d['persona']))
          <div class="define-block">
            <div class="label">Persona</div>
            <div class="persona-layout">
              <div style="flex:1;">
                <h3>{{ $d['persona']['name'] ?? '' }}</h3>
                @if (isset($d['persona']['description']))
                  <p>{{ $d['persona']['description'] }}</p>
                @endif
                @if (isset($d['persona']['detail']))
                  <p>{{ $d['persona']['detail'] }}</p>
                @endif
                @if (isset($d['persona']['expectation']))
                  <p><strong>Ekspektasi:</strong> {{ $d['persona']['expectation'] }}</p>
                @endif
              </div>
              @if (isset($d['persona']['image']))
                <div class="persona-image">
                  <img src="{{ asset_url($d['persona']['image']) }}" alt="Persona">
                </div>
              @endif
            </div>
          </div>
          @endif

          @if (isset($d['problem_statement']))
          <div class="define-block">
            <div class="label">Problem Statement</div>
            <p>{{ $d['problem_statement'] }}</p>
          </div>
          @endif
          @if (isset($d['how_might_we']))
          <div class="define-block hmw">
            <div class="label">How Might We</div>
            <p>{{ $d['how_might_we'] }}</p>
          </div>
          @endif
        </div>
      </section>
    @endif

    @if ($ideate)
      @php $i = $ideate->content; @endphp
      <section id="ideate" class="section ideate">
        <h2>IDEATE</h2>
        @if (isset($i['direction']))
        <p>{{ $i['direction'] }}</p>
        @endif
        @if (isset($i['features']) && $i['features'])
        <div class="feature-grid">
          @foreach ($i['features'] as $feature)
            <div class="feature-card">
              <h3>{{ $feature['title'] ?? '' }}</h3>
              <p>{{ $feature['description'] ?? '' }}</p>
              <h4>Fungsi:</h4>
              <ul>
                @foreach ($feature['functions'] ?? [] as $fn)
                  <li>{{ $fn }}</li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
        @endif
      </section>
    @endif

    @if ($prototype)
      @php $p = $prototype->content; @endphp
      <section id="prototype" class="section prototype">
        <h2>PROTOTYPE</h2>
        @if (isset($p['description']))
        <p>{{ $p['description'] }}</p>
        @endif

        @if (isset($p['lofi_images']) && $p['lofi_images'])
        <h3>Low Fidelity</h3>
        <div class="lofi-wrapper">
          @foreach ($p['lofi_images'] as $lofi)
            <div class="lofi-container"><img src="{{ asset_url($lofi) }}" alt="Lo-Fi"></div>
          @endforeach
        </div>
        @if ($caseStudy->figma_lofi_url)
          <a href="{{ $caseStudy->figma_lofi_url }}" target="_blank" class="lofi-button">Lihat Lo-Fi di Figma</a>
        @endif
        @endif

        @if (isset($p['hifi_images']) && $p['hifi_images'])
        <h3>High Fidelity Prototype</h3>
        <div class="prototype-grid">
          @foreach ($p['hifi_images'] as $hifi)
            <img src="{{ asset_url($hifi) }}" alt="Hi-Fi" class="proto-img">
          @endforeach
        </div>
        @if ($caseStudy->figma_prototype_url)
          <a href="{{ $caseStudy->figma_prototype_url }}" target="_blank" class="proto-button">Lihat Prototype di Figma</a>
        @endif
        @endif
      </section>
    @endif

    @if ($test)
      @php $t = $test->content; @endphp
      <section id="test" class="section test">
        <h2>TEST</h2>
        @if (isset($t['description']))
        <p>{{ $t['description'] }}</p>
        @endif
        @if (isset($t['method']))
        <h3>Metode Pengujian</h3>
        <p>{{ $t['method'] }}</p>
        @endif
        @if (isset($t['tasks']) && $t['tasks'])
        <h3>Tugas yang Diuji</h3>
        <ul>
          @foreach ($t['tasks'] as $task)
            <li>{{ $task }}</li>
          @endforeach
        </ul>
        @endif
        @if (isset($t['findings']) && $t['findings'])
        <h3>Temuan Utama</h3>
        <ul>
          @foreach ($t['findings'] as $finding)
            <li>{{ $finding }}</li>
          @endforeach
        </ul>
        @endif
        @if (isset($t['insight']))
        <h3>Insight</h3>
        <p>{{ $t['insight'] }}</p>
        @endif
        @if (isset($t['iteration']))
        <h3>Iterasi</h3>
        <p>{{ $t['iteration'] }}</p>
        @endif
      </section>
    @endif

    <div class="case-nav">
      <div class="nav-progress" id="progressBar"></div>
      @foreach (['overview', 'empathize', 'define', 'ideate', 'prototype', 'test'] as $_section)
        <a href="#{{ $_section }}">{{ strtoupper($_section) }}</a>
      @endforeach
    </div>

    @push('scripts')
    <script>
      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('.case-nav a');
      const progressBar = document.getElementById('progressBar');

      window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.body.scrollHeight - window.innerHeight;
        if (progressBar) progressBar.style.width = ((scrollTop / docHeight) * 100) + '%';

        let current = 'overview';
        sections.forEach(section => {
          if (window.scrollY >= section.offsetTop - 200) {
            current = section.id;
          }
        });
        navLinks.forEach(link => {
          link.classList.toggle('active', link.getAttribute('href') === '#' + current);
        });
      });

      const protoImgs = document.querySelectorAll('.proto-img');
      const protoObserver = new IntersectionObserver(entries => {
        entries.forEach((entry, i) => {
          if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('show'), i * 80);
          }
        });
      });
      protoImgs.forEach(img => protoObserver.observe(img));
    </script>
    @endpush
  @endif
@endsection