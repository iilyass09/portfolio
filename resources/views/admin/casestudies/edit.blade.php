@extends('layouts.admin')

@section('title', 'Edit Case Study')
@section('header-title')
  Edit Case Study: {{ $caseStudy->project->title ?? '' }}
@endsection

@push('styles')
<style>
  @keyframes floatUpC {
    0% { opacity: 0; transform: translateY(22px) scale(.97); }
    100% { opacity: 1; transform: none; }
  }
  .anim-in { animation: floatUpC .55s cubic-bezier(.22, 1, .36, 1) both; }

  @keyframes floatyC {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
  }
  .animate-floaty { animation: floatyC 3.4s ease-in-out infinite; }

  @keyframes shineC {
    100% { transform: translateX(250%); }
  }
  .shimmer { position: relative; overflow: hidden; }
  .shimmer::after {
    content: '';
    position: absolute;
    inset: 0;
    transform: translateX(-120%);
    background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
    animation: shineC 2.6s ease-in-out infinite;
  }

  .csl-field { transition: box-shadow .25s, border-color .25s; }
  .csl-field:focus-within { box-shadow: 0 0 0 4px rgba(99, 102, 241, .1); border-color: #818cf8; }

  details.cs-box { border: 1px solid #e5e7eb; border-radius: 1rem; background: white; overflow: hidden; transition: border-color .25s, box-shadow .25s; }
  details.cs-box[open] { border-color: #c7d2fe; box-shadow: 0 0 0 4px rgba(99, 102, 241, .07); }
  details.cs-box > summary { cursor: pointer; padding: .9rem 1.15rem; display: flex; align-items: center; gap: .75rem; list-style: none; user-select: none; }
  details.cs-box > summary::-webkit-details-marker { display: none; }
  details.cs-box > summary .cs-chev { transition: transform .3s ease; }
  details.cs-box[open] > summary .cs-chev { transform: rotate(180deg); }
  details.cs-box[open] > summary { border-bottom: 1px solid #f3f4f6; }
  .cs-body { padding: 1.15rem; border-top: 0; animation: csOpen .35s cubic-bezier(.22, 1, .36, 1); }
  @keyframes csOpen {
    0% { opacity: 0; transform: translateY(-6px); }
    100% { opacity: 1; transform: none; }
  }
  .cs-json { transition: border-color .2s, box-shadow .2s; }
  .cs-ok { border-color: #10b981 !important; box-shadow: 0 0 0 3px rgba(16, 185, 129, .12); }
  .cs-err { border-color: #ef4444 !important; box-shadow: 0 0 0 3px rgba(239, 68, 68, .12); }
</style>
@endpush

@section('content')
  @php
    $initial = [
      'tagline' => old('tagline', $caseStudy->tagline),
      'duration' => old('duration', $caseStudy->duration),
      'role' => old('role', $caseStudy->role),
      'tools' => old('tools', $caseStudy->tools),
      'figmaPrototype' => old('figma_prototype_url', $caseStudy->figma_prototype_url),
      'figmaLofi' => old('figma_lofi_url', $caseStudy->figma_lofi_url),
      'background' => old('background', $caseStudy->background),
      'problem' => old('problem', $caseStudy->problem),
      'goal' => old('goal', $caseStudy->goal),
      'footer' => old('footer_description', $caseStudy->footer_description),
      'layout' => $caseStudy->layout,
      'projectTitle' => $caseStudy->project->title ?? 'N/A',
      'thumbnail' => $caseStudy->project && $caseStudy->project->thumbnail ? asset_url($caseStudy->project->thumbnail) : null,
    ];
    $totalSections = $caseStudy->sections->count();
  @endphp

  <div class="max-w-6xl mx-auto space-y-6" x-cloak x-data='caseStudyForm(@json($initial, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))' x-init="makeJsonState()">
    <form method="POST" action="{{ route('admin.casestudies.update', $caseStudy) }}" x-on:submit="submitting = true" @focusout="onJsonFocusout($event)" @input="onJsonInput($event)">
      @csrf
      @method('PUT')

      {{-- Hero banner --}}
      <div class="anim-in relative bg-gradient-to-r from-slate-800 via-indigo-900 to-violet-900 rounded-2xl p-6 sm:p-8 overflow-hidden shadow-lg shadow-indigo-900/25">
        <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-indigo-400/20 blur-2xl animate-floaty"></div>
        <div class="absolute -left-12 -bottom-12 w-40 h-40 rounded-full bg-fuchsia-500/20 blur-2xl animate-floaty" style="animation-delay:1s"></div>
        <div class="relative flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-white animate-floaty" style="animation-delay:.3s">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
          </div>
          <div class="min-w-0">
            <h2 class="text-lg font-extrabold text-white truncate" x-text="projectTitle"></h2>
            <p class="text-sm text-indigo-200 mt-0.5">Kelola konten case study proyek ini secara menyeluruh.</p>
          </div>
          <div class="ml-auto flex items-center gap-2 shrink-0">
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold text-white shadow-sm" :class="layout === 'data' ? 'bg-emerald-600/90' : 'bg-indigo-500/90'">
              <span x-text="layout === 'data' ? 'Layout: Data' : 'Layout: UX Design'"></span>
            </span>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 text-white text-xs font-bold backdrop-blur">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Live Editor
            </span>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">
        <div class="xl:col-span-3 space-y-5">
          {{-- Informasi Umum --}}
          <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:80ms">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
              </div>
              <div>
                <h3 class="text-sm font-bold text-gray-800">Informasi Umum</h3>
                <p class="text-xs text-gray-400">Identitas dan tautan eksternal case study</p>
              </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tagline <span class="text-red-400">*</span></label>
                <input type="text" name="tagline" x-model="tagline" required maxlength="120" placeholder="cth. Meningkatkan konversi lewat data"
                  class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200">
                <div class="mt-1.5 flex items-center gap-2">
                  <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500" :class="tagline.length > 100 ? 'bg-rose-500' : 'bg-indigo-500'" :style="'width:' + Math.min(100, (tagline.length / 120) * 100) + '%'"></div>
                  </div>
                  <span class="text-[11px] font-medium tabular-nums" :class="tagline.length > 100 ? 'text-rose-500' : 'text-gray-400'" x-text="tagline.length + '/120'"></span>
                </div>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Durasi <span class="text-red-400">*</span></label>
                <input type="text" name="duration" x-model="duration" required maxlength="50" placeholder="cth. 3 bulan"
                  class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200">
                <div class="mt-1.5 flex items-center gap-2">
                  <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 bg-violet-400" :style="'width:' + Math.min(100, (duration.length / 50) * 100) + '%'"></div>
                  </div>
                  <span class="text-[11px] font-medium tabular-nums text-gray-400" x-text="duration.length + '/50'"></span>
                </div>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role <span class="text-red-400">*</span></label>
                <input type="text" name="role" x-model="role" required maxlength="120" placeholder="cth. Data Analyst"
                  class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200">
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tools <span class="text-red-400">*</span></label>
                <input type="text" name="tools" x-model="tools" required maxlength="120" placeholder="cth. Excel, Tableau, Python"
                  class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200">
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Figma Prototype</label>
                <div class="csl-field flex items-center gap-2 border border-gray-200 rounded-xl px-3.5 py-2.5 focus-within:border-indigo-400 transition-all duration-200">
                  <svg class="w-4 h-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                  <input type="url" name="figma_prototype_url" x-model="figmaPrototype" placeholder="https://figma.com/proto/..."
                    class="flex-1 text-sm bg-transparent outline-none placeholder:text-gray-300 min-w-0">
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold transition-all duration-300 shrink-0"
                    :class="protoStatus === 'ok' ? 'bg-emerald-50 text-emerald-600' : protoStatus === 'empty' ? 'bg-gray-50 text-gray-400' : 'bg-amber-50 text-amber-600'">
                    <span class="w-1.5 h-1.5 rounded-full" :class="protoStatus === 'ok' ? 'bg-emerald-500' : protoStatus === 'empty' ? 'bg-gray-300' : 'bg-amber-500 animate-pulse'"></span>
                    <span x-text="protoStatus === 'ok' ? 'URL valid' : protoStatus === 'empty' ? 'Kosong' : 'Periksa URL'"></span>
                  </span>
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Figma Lo-Fi</label>
                <div class="csl-field flex items-center gap-2 border border-gray-200 rounded-xl px-3.5 py-2.5 focus-within:border-indigo-400 transition-all duration-200">
                  <svg class="w-4 h-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                  <input type="url" name="figma_lofi_url" x-model="figmaLofi" placeholder="https://figma.com/file/..."
                    class="flex-1 text-sm bg-transparent outline-none placeholder:text-gray-300 min-w-0">
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold transition-all duration-300 shrink-0"
                    :class="lofiStatus === 'ok' ? 'bg-emerald-50 text-emerald-600' : lofiStatus === 'empty' ? 'bg-gray-50 text-gray-400' : 'bg-amber-50 text-amber-600'">
                    <span class="w-1.5 h-1.5 rounded-full" :class="lofiStatus === 'ok' ? 'bg-emerald-500' : lofiStatus === 'empty' ? 'bg-gray-300' : 'bg-amber-500 animate-pulse'"></span>
                    <span x-text="lofiStatus === 'ok' ? 'URL valid' : lofiStatus === 'empty' ? 'Kosong' : 'Periksa URL'"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>

          {{-- Konten Utama --}}
          <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
              </div>
              <div>
                <h3 class="text-sm font-bold text-gray-800">Konten Utama</h3>
                <p class="text-xs text-gray-400">Latar belakang, masalah, dan tujuan proyek</p>
              </div>
            </div>
            <div class="p-6 space-y-5">
              @php $textarea = ['background', 'problem', 'goal']; @endphp
              @foreach ($textarea as $t)
                @php
                  $label = ['background' => 'Latar Belakang', 'problem' => 'Masalah / Permasalahan', 'goal' => 'Tujuan Proyek'][$t];
                  $model = $t;
                  $icon = ['background' => 'info', 'problem' => 'warning', 'goal' => 'target'][$t];
                @endphp
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ $label }}</label>
                  @php
                    $bound = ['background' => 'background', 'problem' => 'problem', 'goal' => 'goal'][$t];
                  @endphp
                  <textarea name="{{ $t }}" x-model="{{ $bound }}" rows="4" placeholder="Tulis {{ strtolower($label) }}..."
                    class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200 resize-none"></textarea>
                  <div class="mt-1.5 flex items-center gap-2">
                    <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                      <div class="h-full rounded-full transition-all duration-500" :class="{{ $bound }}.length > 500 ? 'bg-rose-500' : 'bg-violet-400'" :style="'width:' + Math.min(100, ({{ $bound }}.length / 600) * 100) + '%'"></div>
                    </div>
                    <span class="text-[11px] font-medium tabular-nums" :class="{{ $bound }}.length > 500 ? 'text-rose-500' : 'text-gray-400'" x-text="{{ $bound }}.length + ' karakter'"></span>
                  </div>
                </div>
              @endforeach
              @if ($caseStudy->layout === 'data')
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Footer</label>
                  <textarea name="footer_description" x-model="footer" rows="3" placeholder="Kutipan atau ringkasan penutup..."
                    class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200 resize-none"></textarea>
                  <div class="mt-1.5 flex items-center gap-2">
                    <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                      <div class="h-full rounded-full transition-all duration-500 bg-emerald-400" :style="'width:' + Math.min(100, (footer.length / 300) * 100) + '%'"></div>
                    </div>
                    <span class="text-[11px] font-medium tabular-nums text-gray-400" x-text="footer.length + ' karakter'"></span>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Konten Bagian JSON --}}
          <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:200ms">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
              </div>
              <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-800">Konten Bagian (JSON)</h3>
                <p class="text-xs text-gray-400">Validasi otomatis saat mengetik — pastikan format JSON valid.</p>
              </div>
              <div class="text-right shrink-0 hidden sm:block">
                <p class="text-lg font-extrabold tabular-nums" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'text-emerald-600' : 'text-gray-500'">
                  <span x-text="jsonOk"></span><span class="text-gray-300 text-sm">/</span><span class="text-sm" x-text="jsonTotal"></span>
                </p>
                <div class="mt-0.5 w-20 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'bg-emerald-500' : 'bg-amber-400'" :style="'width:' + (jsonTotal ? Math.round(100 * jsonOk / jsonTotal) : 0) + '%'"></div>
                </div>
              </div>
            </div>

            <div class="p-6 space-y-4">
              @forelse ($caseStudy->sections as $section)
                @php
                  $label = strtoupper(str_replace('_', ' ', $section->type));
                  $jsonPretty = old('sections.' . $loop->index . '.content', json_encode($section->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                @endphp
                <details class="cs-box" @if ($loop->first) open @endif>
                  <summary>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 shrink-0">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/></svg>
                    </span>
                    <span class="flex-1 text-sm font-bold text-gray-700 tracking-wide">{{ $label }}</span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold transition-all duration-300"
                          :class="isJsonOk({{ $loop->index }}) ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'">
                      <span class="w-1.5 h-1.5 rounded-full" :class="isJsonOk({{ $loop->index }}) ? 'bg-emerald-500' : 'bg-rose-500 animate-pulse'"></span>
                      <span x-text="isJsonOk({{ $loop->index }}) ? 'Valid' : 'Cek format'"></span>
                    </span>
                    <svg class="cs-chev w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                  </summary>
                  <div class="cs-body">
                    <input type="hidden" name="sections[{{ $loop->index }}][id]" value="{{ $section->id }}">
                    <div class="flex items-center gap-2 mb-2.5 text-[11px] font-semibold text-gray-400">
                      <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg> Pratinjau di halaman publik</span>
                      <span class="w-px h-3 bg-gray-200"></span>
                      <span>Bagian ke-<b x-text="{{ $loop->index }} + 1"></b> dari {{ $totalSections }}</span>
                    </div>
                    <textarea data-jsonindex="{{ $loop->index }}" name="sections[{{ $loop->index }}][content]" rows="12" spellcheck="false"
                      class="json-area cs-json w-full px-3.5 py-3 border border-gray-200 rounded-xl font-mono text-xs leading-relaxed focus:outline-none focus:border-indigo-400 transition-all duration-200 bg-gray-50/50 tabular-nums">{{ $jsonPretty }}</textarea>
                  </div>
                </details>
              @empty
                <div class="text-center py-10 text-sm text-gray-400">Belum ada bagian konten pada case study ini.</div>
              @endforelse
            </div>
          </div>

          {{-- Save bar --}}
          <div class="anim-in flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between bg-white rounded-2xl border border-gray-100 shadow-sm p-4" style="animation-delay:260ms">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-500 animate-pulse'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
              </div>
              <div class="min-w-0">
                <p class="text-sm font-bold text-gray-700" x-text="jsonOk === jsonTotal && jsonTotal > 0 ? 'Semua bagian valid' : jsonOk + ' dari ' + jsonTotal + ' bagian valid'"></p>
                <p class="text-xs text-gray-400" x-text="jsonOk === jsonTotal && jsonTotal > 0 ? 'Siap disimpan — struktur konten aman.' : 'Perbaiki format JSON sebelum menyimpan.'"></p>
              </div>
            </div>
            <button type="submit" :disabled="submitting" class="shimmer inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 shadow-sm shadow-indigo-600/25 transition-all duration-200 hover:-translate-y-0.5 shrink-0" :class="submitting ? 'opacity-70 cursor-wait' : ''">
              <template x-if="!submitting">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
              </template>
              <template x-if="submitting">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
              </template>
              <span x-text="submitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
          </div>
        </div>

        {{-- Live preview --}}
        <div class="xl:col-span-2 xl:sticky xl:top-6 space-y-5">
          <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:240ms">
            <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-bold text-gray-700">Pratinjau Halaman</p>
              </div>
              <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live
              </span>
            </div>
            <div class="p-5">
              <div class="rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="relative aspect-video bg-gradient-to-br from-indigo-100 to-violet-100">
                  <template x-if="thumbnail">
                    <img :src="thumbnail" class="w-full h-full object-cover" alt="">
                  </template>
                  <div x-show="!thumbnail" class="w-full h-full flex items-center justify-center text-indigo-300 text-4xl font-extrabold" x-text="projectTitle.charAt(0).toUpperCase()" x-cloak></div>
                  <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/70 via-transparent to-transparent"></div>
                  <div class="absolute bottom-3 left-3 right-3">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold text-white shadow mb-1.5" :class="layout === 'data' ? 'bg-emerald-600' : 'bg-indigo-600'">
                      <span x-text="layout === 'data' ? 'Data Analysis' : 'UX Design'"></span>
                    </span>
                    <p class="text-sm font-extrabold text-white leading-snug" :class="!tagline ? 'opacity-40' : ''" x-text="tagline || 'Tagline case study akan tampil di sini...'"></p>
                  </div>
                </div>
                <div class="p-4 space-y-3">
                  <div class="flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1.5 font-semibold text-gray-500">
                      <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                      <span :class="!duration ? 'opacity-30' : ''" x-text="duration || 'Durasi'"></span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 font-semibold text-gray-500">
                      <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                      <span :class="!role ? 'opacity-30' : ''" x-text="role || 'Role'"></span>
                    </span>
                  </div>
                  <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-500">
                    <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085"/></svg>
                    <span :class="!tools ? 'opacity-30' : ''" class="truncate" x-text="tools || 'Tools yang digunakan'"></span>
                  </div>
                  <div class="space-y-2 pt-1 border-t border-gray-100">
                    <div>
                      <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg> Latar Belakang</p>
                      <p class="text-xs text-gray-500 line-clamp-2 whitespace-pre-line mt-0.5" :class="!background ? 'opacity-30' : ''" x-text="background || 'Tulis latar belakang proyek...'"></p>
                    </div>
                    <div>
                      <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg> Masalah</p>
                      <p class="text-xs text-gray-500 line-clamp-2 whitespace-pre-line mt-0.5" :class="!problem ? 'opacity-30' : ''" x-text="problem || 'Tulis permasalahan yang dihadapi...'"></p>
                    </div>
                    <div>
                      <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"/></svg> Tujuan</p>
                      <p class="text-xs text-gray-500 line-clamp-2 whitespace-pre-line mt-0.5" :class="!goal ? 'opacity-30' : ''" x-text="goal || 'Tulis tujuan proyek...'"></p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-3 flex items-center gap-2 rounded-xl bg-gray-50 border border-gray-100 px-3 py-2.5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-500'">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-500"><span x-text="jsonOk"></span> dari <span x-text="jsonTotal"></span> bagian JSON valid</p>
                <span class="ml-auto inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="jsonOk === jsonTotal && jsonTotal > 0 ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse'"></span>
                  <span x-text="jsonOk === jsonTotal && jsonTotal > 0 ? 'Siap simpan' : 'Perlu perbaikan'"></span>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  function caseStudyForm(initial) {
    return {
      projectTitle: initial.projectTitle,
      thumbnail: initial.thumbnail || null,
      layout: initial.layout,
      tagline: initial.tagline || '',
      duration: initial.duration || '',
      role: initial.role || '',
      tools: initial.tools || '',
      figmaPrototype: initial.figmaPrototype || '',
      figmaLofi: initial.figmaLofi || '',
      background: initial.background || '',
      problem: initial.problem || '',
      goal: initial.goal || '',
      footer: initial.footer || '',
      submitting: false,
      jsonOk: 0,
      jsonTotal: 0,
      _jsonDebounce: null,

      init() {
        this.$nextTick(() => this.makeJsonState());
      },

      get protoStatus() {
        if (!this.figmaPrototype) return 'empty';
        return /^https?:\/\/.+/.test(this.figmaPrototype) ? 'ok' : 'warn';
      },

      get lofiStatus() {
        if (!this.figmaLofi) return 'empty';
        return /^https?:\/\/.+/.test(this.figmaLofi) ? 'ok' : 'warn';
      },

      isJsonOk(index) {
        const area = document.querySelector('textarea.json-area[data-jsonindex="' + index + '"]');
        if (!area) return true;
        return this._isValid(area.value);
      },

      _isValid(v) {
        try { JSON.parse(v); return true; } catch (e) { return false; }
      },

      makeJsonState() {
        const areas = Array.from(document.querySelectorAll('textarea.json-area'));
        let ok = 0;
        areas.forEach((area) => {
          if (this._isValid(area.value)) ok++;
          area.classList.remove('cs-ok', 'cs-err');
          area.classList.add(this._isValid(area.value) ? 'cs-ok' : 'cs-err');
        });
        this.jsonTotal = areas.length;
        this.jsonOk = ok;
      },

      onJsonFocusout(event) {
        if (event.target && event.target.classList && event.target.classList.contains('json-area')) {
          this.makeJsonState();
        }
      },

      onJsonInput(event) {
        if (event.target && event.target.classList && event.target.classList.contains('json-area')) {
          const el = event.target;
          clearTimeout(this._jsonDebounce);
          this._jsonDebounce = setTimeout(() => {
            const valid = this._isValid(el.value);
            el.classList.remove('cs-ok', 'cs-err');
            el.classList.add(valid ? 'cs-ok' : 'cs-err');
            if (valid) this.makeJsonState();
          }, 350);
        }
      },
    };
  }
</script>
@endpush