@extends('layouts.app')

@section('title', 'Portfolio - Tentang Saya')

@section('content')
<div class="about-section">
  <div class="about-text">
    <h1 class="about-title">
      {!! \Illuminate\Support\Str::of(\App\Models\Setting::getValue('about_title'))->replace(['desain antarmuka', 'analisis data'], ['<span class="gradient-text">desain antarmuka</span>', '<span class="gradient-text">analisis data</span>']) !!}
    </h1>
    <p>{{ \App\Models\Setting::getValue('about_text_1') }}</p>
    <p>{{ \App\Models\Setting::getValue('about_text_2') }}</p>
    <p>{{ \App\Models\Setting::getValue('about_text_3') }}</p>
  </div>

  <div class="about-photo">
    <img src="{{ asset_url(\App\Models\Setting::getValue('profile_photo', 'img/ilyas.jpeg')) }}" alt="Ilyas Photo">
  </div>
</div>

<div class="education-section">
  <h2 class="section-title">{{ \App\Models\Setting::getValue('education_title') }}</h2>
  <p class="education-subtitle">{{ \App\Models\Setting::getValue('education_subtitle') }}</p>
  <div class="education-grid">
    @foreach ($educations as $education)
      <div class="education-card">
        <span class="edu-year">{{ $education->start_date }}{{ $education->end_date ? ' — ' . $education->end_date : '' }}</span>
        <div>
          <p class="edu-name">{{ $education->institution }}</p>
          <p class="edu-major">{{ $education->degree }}</p>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="experience-section">
  <h2 class="section-title">{{ \App\Models\Setting::getValue('experience_title') }}</h2>
  <p class="experience-subtitle">{{ \App\Models\Setting::getValue('experience_subtitle') }}</p>
  <div class="experience-grid">
    @foreach ($experiences as $experience)
      <div class="experience-card">
        <div class="exp-year">{{ $experience->period }}</div>
        <div class="exp-content">
          <h3>{{ $experience->title }}</h3>
          <p>{{ $experience->description }}</p>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="skills-section">
  <h2 class="section-title">{{ \App\Models\Setting::getValue('skills_title') }}</h2>
  <p class="skills-subtitle">{{ \App\Models\Setting::getValue('skills_subtitle') }}</p>
  <div class="skills-grid">
    @foreach ($skills as $skill)
      <div class="skill">{{ $skill->name }}</div>
    @endforeach
  </div>
</div>

<div class="bg-text">ABOUT</div>
<div class="blur1"></div>
<div class="blur2"></div>
@endsection

@push('scripts')
<script>
  const eduCards = document.querySelectorAll('.education-card');
  const eduObserver = new IntersectionObserver(entries => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => entry.target.classList.add('show'), i * 100);
      }
    });
  }, { threshold: 0.1 });
  eduCards.forEach(card => eduObserver.observe(card));
</script>

<script>
  const expCards = document.querySelectorAll('.experience-card');
  const expObserver = new IntersectionObserver(entries => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => entry.target.classList.add('show'), i * 120);
      }
    });
  }, { threshold: 0.1 });
  expCards.forEach(card => expObserver.observe(card));
</script>

<script>
  const scrollTargets = document.querySelectorAll(
    '.education-section .section-title, .education-subtitle, .skill'
  );
  const scrollObserver = new IntersectionObserver(entries => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => entry.target.classList.add('show'), i * 100);
      }
    });
  }, { threshold: 0.1 });
  scrollTargets.forEach(el => scrollObserver.observe(el));
</script>
@endpush