@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('header-title', 'Pengaturan Situs')

@push('styles')
  <style>
    @keyframes floatUpS {
      0% { opacity: 0; transform: translateY(24px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpS .6s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyS {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyS 3.4s ease-in-out infinite; }

    @keyframes shineS {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
      animation: shineS 2.4s ease-in-out infinite;
    }

    @keyframes gradientMove {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }
    .gradient-live { background-size: 200% 200%; animation: gradientMove 6s ease infinite; }

    @keyframes popInS {
      0% { opacity: 0; transform: scale(.6); }
      60% { transform: scale(1.08); }
      100% { opacity: 1; transform: scale(1); }
    }
    .anim-pop { animation: popInS .4s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes pulseGlow {
      0%, 100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, .28); }
      50% { box-shadow: 0 0 0 8px rgba(79, 70, 229, 0); }
    }
    .animate-glow { animation: pulseGlow 2.4s ease-in-out infinite; }

    .tab-pill { position: relative; }
    .tab-pill::after {
      content: '';
      position: absolute;
      left: 0.5rem;
      right: 0.5rem;
      bottom: 0.25rem;
      height: 2px;
      border-radius: 9999px;
      background: #6366f1;
      transform: scaleX(0);
      transition: transform .3s cubic-bezier(.22, 1, .36, 1);
    }
    .tab-pill.active::after { transform: scaleX(1); }

    .field {
      transition: border-color .2s, box-shadow .2s, background-color .2s;
    }
    .field:focus {
      border-color: #818cf8;
      box-shadow: 0 0 0 4px rgba(99, 102, 241, .14);
    }
  </style>
@endpush

@section('content')
  @php
    $s = $settings;
    $profilePhoto = ($s['profile_photo'] ?? 'img/ilyas.jpeg');
    $settingsData = [
      'site_name' => $s['site_name'] ?? '',
      'hero_eyebrow' => $s['hero_eyebrow'] ?? '',
      'hero_title_1' => $s['hero_title_1'] ?? '',
      'hero_title_2' => $s['hero_title_2'] ?? '',
      'hero_description' => $s['hero_description'] ?? '',
      'about_title' => $s['about_title'] ?? '',
      'about_text_1' => $s['about_text_1'] ?? '',
      'about_text_2' => $s['about_text_2'] ?? '',
      'about_text_3' => $s['about_text_3'] ?? '',
      'resume_url' => $s['resume_url'] ?? '',
      'linkedin_url' => $s['linkedin_url'] ?? '',
      'spotify_url' => $s['spotify_url'] ?? '',
      'copyright' => $s['copyright'] ?? '',
      'connect_text' => $s['connect_text'] ?? '',
      'education_title' => $s['education_title'] ?? '',
      'education_subtitle' => $s['education_subtitle'] ?? '',
      'experience_title' => $s['experience_title'] ?? '',
      'experience_subtitle' => $s['experience_subtitle'] ?? '',
      'skills_title' => $s['skills_title'] ?? '',
      'skills_subtitle' => $s['skills_subtitle'] ?? '',
      'profilePhotoUrl' => asset_url($profilePhoto),
    ];
  @endphp

  <div x-cloak x-data='settingsForm(@json($settingsData, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 xl:grid-cols-12 gap-6" @submit="submitting = true">
      @csrf

      {{-- ================= Left: Form ================= --}}
      <div class="xl:col-span-7 space-y-6 min-w-0">

        {{-- Header banner --}}
        <div class="anim-in relative overflow-hidden rounded-2xl bg-white border border-gray-100 shadow-sm p-6" style="animation-delay:20ms">
          <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 animate-floaty">
              <svg class="w-7 h-7 animate-spin-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
              <h2 class="text-xl font-extrabold text-gray-800">Pengaturan Situs</h2>
              <p class="text-sm text-gray-400">Kelola semua konten dan tautan portfolio kamu. Perubahan tampil langsung di pratinjau.</p>
            </div>
            <div class="ml-auto hidden sm:flex flex-col items-end gap-1">
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live Preview
              </span>
              <span class="text-[11px] text-gray-400" x-text="activeTabLabel"></span>
            </div>
          </div>
        </div>

        {{-- Tabs --}}
        <nav class="anim-in flex flex-wrap gap-2" style="animation-delay:90ms">
          <template x-for="tab in tabs" :key="tab.key">
            <button type="button" @click="activeTab = tab.key"
              class="tab-pill inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 active:scale-95"
              :class="activeTab === tab.key
                ? 'active bg-indigo-600 text-white shadow-md shadow-indigo-600/25'
                : 'bg-white text-gray-500 border border-gray-200 hover:border-indigo-300 hover:text-indigo-600 hover:-translate-y-0.5'">
              <span x-html="tab.icon"></span>
              <span x-text="tab.label"></span>
            </button>
          </template>
        </nav>

        {{-- Panel: Beranda --}}
        <section x-show="activeTab === 'beranda'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-6" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-indigo-50/60 to-transparent">
            <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
              <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg></span>
              Halaman Beranda
            </h3>
            <span class="text-xs font-medium text-indigo-500 bg-indigo-50 rounded-full px-2.5 py-1">6 field</span>
          </div>
          <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="anim-in space-y-2" style="animation-delay:180ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Nama Situs (Logo navbar)</span>
                <span class="text-indigo-400 transition-all duration-200" :class="site_name.length > 40 && 'text-red-400 scale-110'" x-text="site_name.length"></span>
              </label>
              <input type="text" name="settings[site_name]" x-model="site_name" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            <div class="anim-in space-y-2" style="animation-delay:220ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Eyebrow Hero</span>
                <span class="text-indigo-400 transition-all duration-200" :class="hero_eyebrow.length > 60 && 'text-red-400'" x-text="hero_eyebrow.length"></span>
              </label>
              <input type="text" name="settings[hero_eyebrow]" x-model="hero_eyebrow" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            <div class="anim-in space-y-2" style="animation-delay:260ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Judul Hero (Baris 1)</span>
                <span class="text-indigo-400 transition-all duration-200" :class="hero_title_1.length > 40 && 'text-red-400'" x-text="hero_title_1.length"></span>
              </label>
              <input type="text" name="settings[hero_title_1]" x-model="hero_title_1" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            <div class="anim-in space-y-2" style="animation-delay:300ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Judul Hero (Baris 2)</span>
                <span class="text-indigo-400 transition-all duration-200" :class="hero_title_2.length > 40 && 'text-red-400'" x-text="hero_title_2.length"></span>
              </label>
              <input type="text" name="settings[hero_title_2]" x-model="hero_title_2" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            <div class="md:col-span-2 anim-in space-y-2" style="animation-delay:340ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Deskripsi Hero</span>
                <span class="inline-flex items-center gap-1 text-xs font-semibold rounded-full px-2.5 py-0.5 transition-colors duration-200" :class="hero_description.length > 300 ? 'text-amber-700 bg-amber-50' : 'text-gray-400 bg-gray-100'" x-text="hero_description.length + ' karakter'"></span>
              </label>
              <textarea name="settings[hero_description]" x-model="hero_description" rows="4" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800"></textarea>
              <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-300" :style="'width:' + Math.min(100, hero_description.length / 3.5) + '%'"></div>
              </div>
            </div>

            <div class="md:col-span-2 anim-in space-y-2" style="animation-delay:380ms">
              <label class="block text-xs font-semibold text-gray-600">Foto Profil</label>
              <div class="flex items-center gap-5">
                <div class="group relative shrink-0">
                  <img :src="profilePhotoUrl" alt="Profile" class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-105 group-hover:rotate-1">
                  <label class="absolute inset-0 flex items-center justify-center rounded-2xl bg-gray-900/60 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                    <span class="flex flex-col items-center gap-1 text-xs font-semibold">
                      <svg class="w-5 h-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                      Unggah
                    </span>
                    <input type="file" name="settings[profile_photo]" accept="image/*" class="hidden" @change="onPhotoChange">
                  </label>
                </div>
                <div class="space-y-1.5 text-xs text-gray-400">
                  <p class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg> Arahkan kursor ke foto untuk unggah gambar baru.</p>
                  <p class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Pratinjau berubah otomatis setelah dipilih.</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        {{-- Panel: Tentang --}}
        <section x-show="activeTab === 'tentang'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-6" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-emerald-50/60 to-transparent">
            <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
              <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg></span>
              Halaman Tentang Saya
            </h3>
            <span class="text-xs font-medium text-emerald-500 bg-emerald-50 rounded-full px-2.5 py-1">4 field</span>
          </div>
          <div class="p-6 space-y-5">
            <div class="anim-in space-y-2" style="animation-delay:180ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Judul Tentang</span>
                <span class="text-indigo-400 transition-all duration-200" :class="about_title.length > 100 && 'text-red-400'" x-text="about_title.length"></span>
              </label>
              <input type="text" name="settings[about_title]" x-model="about_title" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            @for ($i = 1; $i <= 3; $i++)
              <div class="anim-in space-y-2" style="animation-delay:{{ 220 + $i * 40 }}ms">
                <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                  <span>Paragraf {{ $i }}</span>
                  <span class="inline-flex items-center gap-1 text-xs font-semibold rounded-full px-2.5 py-0.5 transition-colors duration-200" :class="about_text_{{ $i }}.length > 500 ? 'text-amber-700 bg-amber-50' : 'text-gray-400 bg-gray-100'" x-text="about_text_{{ $i }}.length + ' karakter'"></span>
                </label>
                <textarea name="settings[about_text_{{ $i }}]" x-model="about_text_{{ $i }}" rows="3" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800"></textarea>
                <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-300" :style="'width:' + Math.min(100, about_text_{{ $i }}.length / 5.5) + '%'"></div>
                </div>
              </div>
            @endfor
          </div>
        </section>

        {{-- Panel: Tautan --}}
        <section x-show="activeTab === 'tautan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-6" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-amber-50/60 to-transparent">
            <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
              <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg></span>
              Tautan & Kontak
            </h3>
            <span class="text-xs font-medium text-amber-500 bg-amber-50 rounded-full px-2.5 py-1">5 field</span>
          </div>
          <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            @php
              $links = [
                'resume_url' => ['URL Resume', 'file'],
                'linkedin_url' => ['URL LinkedIn', 'linkedin'],
                'spotify_url' => ['URL Spotify', 'spotify'],
              ];
            @endphp
            @foreach ($links as $key => [$label, $iconName])
              <div class="anim-in space-y-2" style="animation-delay:{{ 180 + $loop->index * 50 }}ms">
                <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                  <span>{{ $label }}</span>
                  <span class="anim-pop inline-flex items-center gap-1 text-[10px] font-bold rounded-full px-2 py-0.5 transition-all duration-300"
                    :class="isValidUrl({{ json_encode($key) }})
                      ? 'text-emerald-600 bg-emerald-50'
                      : 'text-amber-600 bg-amber-50'">
                    <svg x-show="isValidUrl({{ json_encode($key) }})" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <svg x-show="!isValidUrl({{ json_encode($key) }})" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    <span x-text="isValidUrl({{ json_encode($key) }}) ? 'OK' : 'Isi URL'"></span>
                  </span>
                </label>
                <div class="relative">
                  <span class="absolute left-3.5 inset-y-0 flex items-center text-gray-400 pointer-events-none">
                    <span class="w-2.5 h-2.5 rounded-sm" :class="{ 'bg-emerald-400': isValidUrl({{ json_encode($key) }}), 'bg-amber-300': !isValidUrl({{ json_encode($key) }}) }"></span>
                  </span>
                  <input type="url" name="settings[{{ $key }}]" x-model="{{ $key }}" placeholder="https://..." class="field w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
                </div>
              </div>
            @endforeach
            <div class="anim-in space-y-2" style="animation-delay:340ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Teks Copyright</span>
                <span class="text-indigo-400 transition-all duration-200" :class="copyright.length > 60 && 'text-red-400'" x-text="copyright.length"></span>
              </label>
              <input type="text" name="settings[copyright]" x-model="copyright" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
            </div>
            <div class="anim-in md:col-span-2 space-y-2" style="animation-delay:390ms">
              <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                <span>Teks "Mari Terhubung"</span>
                <span class="text-indigo-400 transition-all duration-200" :class="connect_text.length > 140 && 'text-red-400'" x-text="connect_text.length"></span>
              </label>
              <textarea name="settings[connect_text]" x-model="connect_text" rows="2" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800"></textarea>
            </div>
          </div>
        </section>

        {{-- Panel: Judul Bagian --}}
        <section x-show="activeTab === 'bagian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-6" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150" class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-violet-50/60 to-transparent">
            <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
              <span class="w-7 h-7 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg></span>
              Judul Bagian
            </h3>
            <span class="text-xs font-medium text-violet-500 bg-violet-50 rounded-full px-2.5 py-1">6 field</span>
          </div>
          <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            @php
              $sectionFields = [
                'education_title' => 'Judul Pendidikan',
                'education_subtitle' => 'Subtitle Pendidikan',
                'experience_title' => 'Judul Pengalaman',
                'experience_subtitle' => 'Subtitle Pengalaman',
                'skills_title' => 'Judul Keahlian',
                'skills_subtitle' => 'Subtitle Keahlian',
              ];
            @endphp
            @foreach ($sectionFields as $key => $label)
              <div class="anim-in space-y-2" style="animation-delay:{{ 180 + $loop->index * 45 }}ms">
                <label class="flex items-center justify-between text-xs font-semibold text-gray-600">
                  <span>{{ $label }}</span>
                  <span class="text-indigo-400 transition-all duration-200" :class="{{ $key }}.length > 100 && 'text-red-400'" x-text="{{ $key }}.length"></span>
                </label>
                <input type="text" name="settings[{{ $key }}]" x-model="{{ $key }}" class="field w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-sm outline-none text-gray-800">
              </div>
            @endforeach
          </div>
        </section>

        {{-- Sticky action bar --}}
        <div class="anim-in sticky bottom-4 z-20" style="animation-delay:420ms">
          <div class="flex flex-col sm:flex-row sm:items-center gap-4 justify-between bg-white/90 backdrop-blur border border-gray-200 rounded-2xl shadow-lg shadow-gray-200/60 px-5 py-4">
            <div class="text-xs text-gray-400 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
              Perubahan otomatis tampil di pratinjau di samping.
            </div>
            <div class="flex items-center gap-3">
              <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-4 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                Batal
              </a>
              <button type="submit" :disabled="submitting"
                class="shimmer inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md shadow-indigo-600/30 transition-all duration-200 hover:-translate-y-0.5 active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed animate-glow">
                <svg x-show="!submitting" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-6.219-8.56"/></svg>
                <span x-text="submitting ? 'Menyimpan...' : 'Simpan Pengaturan'"></span>
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- ================= Right: Live preview ================= --}}
      <div class="xl:col-span-5 min-w-0">
        <div class="sticky top-8 space-y-5" x-show="activeTab === 'beranda' || activeTab === 'tentang'" x-transition>
          {{-- Live hero preview --}}
          <div class="anim-in overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white" style="animation-delay:160ms">
            <div class="flex items-center justify-between px-4 py-2.5 bg-gray-900 text-white text-[11px] font-semibold">
              <span class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
              </span>
              <span class="text-gray-400">Pratinjau Langsung</span>
              <svg class="w-3.5 h-3.5 text-emerald-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2A10 10 0 102 12h2a8 8 0 118-8v6h5.34l-2-2L21 5.66 16 10.66h0z" opacity="0"/><path fill-rule="evenodd" d="M12 22a10 10 0 110-20 10 10 0 010 20zm0-3a7 7 0 100-14 7 7 0 000 14z" clip-rule="evenodd"/></svg>
            </div>
            <div class="gradient-live bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-600 px-6 py-8 text-white">
              <div class="flex items-center justify-between mb-6">
                <span class="text-sm font-extrabold tracking-wide" x-text="site_name || 'MUHAMMAD ILYAS'"></span>
                <div class="flex items-center gap-3 text-[10px] text-white/70">
                  <span>Beranda</span><span>Tentang</span><span>Resume</span>
                </div>
              </div>
              <div class="flex items-center gap-5">
                <img :src="profilePhotoUrl" class="w-20 h-20 rounded-full object-cover border-2 border-white/60 shadow-xl animate-floaty" alt="avatar">
                <div>
                  <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-white/80" x-text="hero_eyebrow || 'Halo, Saya ...'"></p>
                  <h3 class="text-xl font-extrabold leading-tight mt-0.5">
                    <span x-text="hero_title_1 || 'UI / UX DESIGN'"></span><br>
                    <span x-text="hero_title_2 || '& E COMMERCE ANALYST'"></span>
                  </h3>
                </div>
              </div>
              <p class="mt-4 text-[13px] leading-relaxed text-white/85 line-clamp-3" x-text="hero_description || 'Deskripsi hero akan tampil di sini...'"></p>
            </div>
            <div class="px-5 py-3 text-[11px] text-gray-400 border-t border-gray-100" x-text="copyright || '© 2026 Muhammad Ilyas. All rights reserved.'"></div>
          </div>

          {{-- Live about preview --}}
          <div class="anim-in overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white" style="animation-delay:240ms">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
              <span class="text-xs font-bold text-gray-700">Tentang Saya</span>
              <span class="text-[10px] font-semibold text-indigo-500 bg-indigo-50 rounded-full px-2.5 py-0.5">live</span>
            </div>
            <div class="p-5 space-y-3">
              <h4 class="text-sm font-bold text-gray-800" x-text="about_title || 'Menciptakan pengalaman digital...'"></h4>
              <div class="space-y-2 text-[13px] leading-relaxed text-gray-500">
                <p x-text="about_text_1 || '—'"></p>
                <p x-text="about_text_2 || '—'"></p>
                <p x-text="about_text_3 || '—'"></p>
              </div>
              <div class="pt-2 border-t border-gray-100">
                <p class="text-[12px] font-semibold text-gray-400" x-text="connect_text || 'Terbuka untuk kolaborasi.'"></p>
              </div>
            </div>
          </div>

          {{-- Section titles preview --}}
          <div class="anim-in space-y-2 rounded-2xl border border-gray-200 shadow-sm bg-white p-5" style="animation-delay:320ms">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 anim-pop" :style="'animation-delay:' + (180 + site_name.length) % 60 + 'ms'">Judul Bagian</p>
            <template x-for="sec in sectionTitles" :key="sec.id">
              <div class="flex items-center justify-between rounded-xl px-3 py-2 bg-gray-50 hover:bg-indigo-50/50 transition-colors duration-200">
                <span class="text-xs text-gray-500" x-text="sec.label"></span>
                <span class="text-xs font-bold text-gray-700 truncate max-w-[55%] ml-3" x-text="sec.value || '—'"></span>
              </div>
            </template>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    function settingsForm(initial) {
      return {
        activeTab: 'beranda',
        submitting: false,
        ...initial,

        tabs: [
          { key: 'beranda', label: 'Beranda', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>' },
          { key: 'tentang', label: 'Tentang', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>' },
          { key: 'tautan', label: 'Tautan', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>' },
          { key: 'bagian', label: 'Judul Bagian', icon: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>' },
        ],

        get activeTabLabel() {
          const t = this.tabs.find((x) => x.key === this.activeTab);
          return t ? t.label : '';
        },

        isValidUrl(key) {
          const v = (this[key] || '').trim();
          if (!v) return false;
          try {
            return ['http:', 'https:'].includes(new URL(v).protocol);
          } catch (e) {
            return false;
          }
        },

        get sectionTitles() {
          return [
            { id: 1, label: 'Pendidikan', value: this.education_title },
            { id: 2, label: 'Pengalaman', value: this.experience_title },
            { id: 3, label: 'Keahlian', value: this.skills_title },
          ];
        },

        onPhotoChange(event) {
          const file = event.target.files[0];
          if (!file) return;
          if (!file.type.startsWith('image/')) return;
          const reader = new FileReader();
          reader.onload = (e) => { this.profilePhotoUrl = e.target.result; };
          reader.readAsDataURL(file);
        },
      };
    }
  </script>
  <style>
    @keyframes spinSlow { to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spinSlow 14s linear infinite; }
  </style>
@endpush