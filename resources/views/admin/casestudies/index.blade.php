@extends('layouts.admin')

@section('title', 'Konten Case Study')
@section('header-title', 'Konten Case Study')

@push('styles')
  <style>
    @keyframes floatUpC {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpC .6s cubic-bezier(.22, 1, .36, 1) both; }

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

    @keyframes wiggleC {
      0%, 100% { transform: rotate(-4deg); }
      50% { transform: rotate(4deg); }
    }
    .animate-wiggle { animation: wiggleC 2.6s ease-in-out infinite; }
  </style>
@endpush

@section('content')
  @php
    $items = $caseStudies->map(fn ($c) => [
      'id' => $c->id,
      'title' => $c->project->title ?? 'N/A',
      'tagline' => $c->tagline,
      'layout' => $c->layout,
      'duration' => $c->duration,
      'role' => $c->role,
      'tools' => $c->tools,
      'sectionCount' => $c->sections_count ?? $c->sections->count(),
      'thumbnail' => $c->project && $c->project->thumbnail ? asset_url($c->project->thumbnail) : null,
      'editUrl' => route('admin.casestudies.edit', $c),
      'publicUrl' => $c->project ? route('casestudy', $c->project->slug ?? $c->project->id) : null,
    ])->values();
  @endphp

  <div class="space-y-6" x-cloak x-data='caseStudiesList(@json($items, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    {{-- Toolbar --}}
    <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:100ms">
      <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center gap-4">
        <div class="relative flex-1 min-w-0 group/search">
          <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 pointer-events-none group-focus-within/search:text-indigo-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
          </span>
          <input type="search" x-model="query" placeholder="Cari judul proyek, tagline, atau role..."
            class="w-full pl-11 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-400 placeholder:text-gray-400 transition-all duration-200">
          <button x-show="query" x-transition.opacity.duration.150ms @click="query = ''" type="button"
            class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 hover:rotate-90 transition-transform duration-200" title="Bersihkan pencarian">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-2 shrink-0 flex-wrap">
          <template x-for="f in filters" :key="f.key">
            <button type="button" @click="layoutFilter = f.key"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 active:scale-95"
              :class="layoutFilter === f.key
                ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/25 scale-[1.03]'
                : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-indigo-300 hover:text-indigo-600'">
              <span :class="f.dot"></span>
              <span x-text="f.label"></span>
            </button>
          </template>
        </div>
      </div>

      <div class="px-5 py-2.5 bg-gray-50/60 border-b border-gray-100 flex items-center gap-2 text-xs text-gray-400">
        <span x-show="filtered.length === 0" class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg> Tidak ada hasil</span>
        <span x-show="filtered.length > 0" class="flex items-center gap-1.5"><span class="text-indigo-500 font-bold" x-text="filtered.length"></span> case study ditampilkan</span>
      </div>

      {{-- Cards --}}
      <template x-if="filtered.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-5">
          <template x-for="(c, i) in filtered" :key="c.id">
            <article class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-1.5 hover:border-indigo-100 transition-all duration-300"
                     :class="'anim-in'" :style="'animation-delay:' + (i * 60) + 'ms'">

              <div class="relative aspect-video bg-gray-100 overflow-hidden">
                <template x-if="c.thumbnail">
                  <img :src="c.thumbnail" :alt="c.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1" loading="lazy">
                </template>
                <template x-if="!c.thumbnail">
                  <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                  </div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide text-white shadow" :class="c.layout === 'data' ? 'bg-emerald-500/95' : 'bg-indigo-500/95'">
                  <span x-text="c.layout === 'data' ? 'Data' : 'UX Design'"></span>
                </span>
                <span class="absolute bottom-3 left-3 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/90 backdrop-blur text-[10px] font-bold text-gray-700 shadow">
                  <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  <span x-text="c.duration"></span>
                </span>
                <span class="absolute top-3 left-3 w-8 h-8 inline-flex items-center justify-center rounded-lg bg-white/90 backdrop-blur text-xs font-extrabold text-indigo-600 shadow transition-transform duration-300 group-hover:scale-110" x-text="String(i + 1).padStart(2, '0')"></span>
              </div>

              <div class="p-5">
                <div class="flex items-center gap-2">
                  <h3 class="text-sm font-extrabold text-gray-800 group-hover:text-indigo-700 transition-colors duration-200 truncate" x-text="c.title"></h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-0.5" x-text="c.tagline"></p>

                <div class="mt-3 flex flex-wrap gap-1.5">
                  <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-gray-50 border border-gray-100 text-[10px] font-bold text-gray-500">
                    <svg class="w-3 h-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    <span x-text="c.role"></span>
                  </span>
                  <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-gray-50 border border-gray-100 text-[10px] font-bold text-gray-500">
                    <svg class="w-3 h-3 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span x-text="c.sectionCount"></span> bagian
                  </span>
                  <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-gray-50 border border-gray-100 text-[10px] font-bold text-gray-500" title="Tools">
                    <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085"/></svg>
                    <span x-text="c.tools"></span>
                  </span>
                </div>
              </div>

              <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50 flex items-center gap-1.5">
                <a :href="c.editUrl" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                  Edit Konten
                </a>
                <template x-if="c.publicUrl">
                  <a :href="c.publicUrl" target="_blank" class="ml-auto inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-white bg-white hover:bg-gray-700 border border-gray-200 hover:border-gray-700 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Lihat
                  </a>
                </template>
              </div>
            </article>
          </template>
        </div>
      </template>

      {{-- Empty states --}}
      <template x-if="total > 0">
        <div x-show="filtered.length === 0" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95" class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Tidak ada case study yang cocok</p>
          <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci atau filter pencarianmu.</p>
        </div>
      </template>

      <template x-if="total === 0">
        <div class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Belum ada data case study</p>
          <p class="mt-1 text-xs text-gray-400">Case study muncul otomatis saat proyek dibuat.</p>
        </div>
      </template>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function caseStudiesList(items) {
      return {
        items: items,
        query: '',
        layoutFilter: 'all',
        displayTotal: 0,
        displayUx: 0,
        displayData: 0,

        filters: [
          { key: 'all', label: 'Semua', dot: 'hidden' },
          { key: 'ux', label: 'UX Design', dot: 'w-2 h-2 rounded-full bg-indigo-500' },
          { key: 'data', label: 'Data', dot: 'w-2 h-2 rounded-full bg-emerald-500' },
        ],

        init() {
          this.$nextTick(() => {
            this.animateNumber('displayTotal', this.total, 750);
            setTimeout(() => this.animateNumber('displayUx', this.uxCount, 650), 200);
            setTimeout(() => this.animateNumber('displayData', this.dataCount, 650), 350);
          });
        },

        animateNumber(prop, target, duration) {
          const start = performance.now();
          const step = (t) => {
            const p = Math.min((t - start) / duration, 1);
            this[prop] = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(step);
          };
          requestAnimationFrame(step);
        },

        get total() { return this.items.length; },
        get uxCount() { return this.items.filter((c) => c.layout === 'ux').length; },
        get dataCount() { return this.items.filter((c) => c.layout === 'data').length; },

        get filtered() {
          const q = (this.query || '').trim().toLowerCase();
          return this.items.filter((c) => {
            if (this.layoutFilter !== 'all' && c.layout !== this.layoutFilter) return false;
            if (q && ![c.title, c.tagline, c.role, c.tools].filter(Boolean).join(' ').toLowerCase().includes(q)) return false;
            return true;
          });
        },
      };
    }
  </script>
@endpush