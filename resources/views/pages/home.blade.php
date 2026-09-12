@extends('layouts.app')

@section('title', 'Portfolio - Muhammad Ilyas')

@section('content')
<div class="container">
  <div class="hero-content">

    <div class="hero-left fade-in">
      <span class="hero-eyebrow">{{ \App\Models\Setting::getValue('hero_eyebrow') }}</span>

      <h1 class="hero-title">
        <span class="title-main gradient-text">{{ \App\Models\Setting::getValue('hero_title_1') }}</span>
        <span class="title-sub gradient-text">{{ \App\Models\Setting::getValue('hero_title_2') }}</span>
      </h1>

      <div class="hero-tools">
        @php
          $tools = [
            'img/figma.png' => 'Figma',
            'img/xd.png' => 'Adobe XD',
            'img/py.png' => 'Python',
            'img/excel.png' => 'Excel',
            'img/shopee.png' => 'Shopee',
            'img/tiktok.png' => 'Tiktok',
            'img/tokped.png' => 'Tokped',
          ];
        @endphp
        @foreach ($tools as $src => $alt)
          <img src="{{ asset($src) }}" alt="{{ $alt }}" @if(in_array($alt, ['Shopee','Tiktok','Tokped'])) class="icon-market" @endif>
        @endforeach
      </div>

      <p>
        {{ \App\Models\Setting::getValue('hero_description') }}
      </p>

      <div class="buttons">
        <button class="btn btn-primary" data-link="{{ route('about') }}">Tentang Saya</button>
        <button class="btn btn-secondary" data-link="#projects">Studi Kasus</button>
      </div>
    </div>

    <div class="hero-right">
      <div class="avatar-spotlight" id="spotlight"></div>
      <div class="avatar-wrapper">
        <img src="{{ asset_url(\App\Models\Setting::getValue('profile_photo', 'img/ilyas.jpeg')) }}" alt="profile" class="hero-avatar" id="heroAvatar">
      </div>
    </div>

    <div class="bg-text fade-in">PORTFOLIO</div>
    <div class="blur1"></div>
    <div class="blur2"></div>

  </div>
</div>

<section id="projects" class="projects">
  <div class="projects-header">
    <h2>STUDI KASUS</h2>
    <span>{{ $activeProjects->count() }} Proyek</span>
  </div>

  <div class="projects-grid">
    @foreach ($projects as $index => $project)
      <div class="project-card">
        <div class="project-thumb">
          <img src="{{ asset_url($project->thumbnail ?: 'img/tanggap2.png') }}" alt="{{ $project->title }}">
        </div>
        <div class="project-body">
          <div class="project-meta">
            <span class="project-tag {{ $project->type === 'data_analyst' ? 'data' : 'ux' }}">{{ $project->type === 'data_analyst' ? 'Data Analyst' : 'UI/UX Designer' }}</span>
            <span class="project-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h3 class="project-title">{{ $project->title }}</h3>
          <p class="project-sub">{{ $project->subtitle }}</p>
          <hr class="project-divider">
          <p class="project-desc">{{ $project->description }}</p>
          @if ($project->caseStudy)
            <a href="{{ route('casestudy', $project->slug) }}" class="project-link">Lihat studi kasus →</a>
          @else
            <span class="project-link-nonactive">Lihat studi kasus →</span>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection

@push('scripts')
<script>
  const avatar = document.getElementById('heroAvatar');
  const spotlight = document.getElementById('spotlight');

  if (avatar && spotlight) {
    avatar.addEventListener('mouseenter', () => {
      spotlight.style.opacity = '1';
    });
    avatar.addEventListener('mouseleave', () => {
      spotlight.style.opacity = '0';
    });
    avatar.addEventListener('mousemove', (e) => {
      const rect = avatar.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      spotlight.style.left = x + 'px';
      spotlight.style.top = y + 'px';
    });
  }

  document.querySelectorAll(".btn[data-link]").forEach(btn => {
    btn.addEventListener("click", function() {
      const url = this.getAttribute("data-link");
      if (url.startsWith("#")) {
        const target = document.querySelector(url);
        if (target) target.scrollIntoView({ behavior: "smooth" });
        return;
      }
      window.location.href = url;
    });
  });

  const cards = document.querySelectorAll(".project-card");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  });
  cards.forEach(card => observer.observe(card));
</script>
@endpush