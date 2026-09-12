@extends('layouts.admin')

@section('title', 'Proyek')
@section('header-title', 'Daftar Proyek')

@push('styles')
  <style>
    @keyframes floatUpP {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpP .6s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyP {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyP 3.4s ease-in-out infinite; }

    @keyframes wiggleP {
      0%, 100% { transform: rotate(-4deg); }
      50% { transform: rotate(4deg); }
    }
    .animate-wiggle { animation: wiggleP 2.6s ease-in-out infinite; }

    @keyframes shakeP {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(3px); }
      30%, 50%, 70% { transform: translateX(-5px); }
      40%, 60% { transform: translateX(5px); }
    }
    .animate-shake { animation: shakeP .55s ease both; }

    @keyframes shineP {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
      animation: shineP 2.6s ease-in-out infinite;
    }

    @keyframes pulseRingP {
      0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, .45); }
      100% { box-shadow: 0 0 0 16px rgba(239, 68, 68, 0); }
    }
    .animate-pulse-ring { animation: pulseRingP 1.6s ease-out infinite; }

    .card-enter { animation: floatUpP .5s cubic-bezier(.22, 1, .36, 1) both; }
  </style>
@endpush

@section('content')
  @php
    $items = $projects->map(fn ($p) => [
      'id' => $p->id,
      'title' => $p->title,
      'subtitle' => $p->subtitle,
      'description' => $p->description,
      'thumbnail' => asset_url($p->thumbnail),
      'type' => $p->type,
      'is_active' => (bool) $p->is_active,
      'editUrl' => route('admin.projects.edit', $p),
      'caseUrl' => $p->caseStudy ? route('admin.casestudies.edit', $p->caseStudy) : null,
      'deleteUrl' => route('admin.projects.destroy', $p),
    ])->values();
  @endphp

  <div class="space-y-6" x-cloak x-data='projectsList(@json($items, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    {{-- Toolbar --}}
    <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:100ms">
      <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center gap-4">
        <div class="relative flex-1 min-w-0 group/search">
          <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 pointer-events-none group-focus-within/search:text-indigo-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
          </span>
          <input type="search" x-model="query" placeholder="Cari judul, subtitle, atau deskripsi proyek..."
            class="w-full pl-11 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-400 placeholder:text-gray-400 transition-all duration-200">
          <button x-show="query" x-transition.opacity.duration.150ms @click="query = ''" type="button"
            class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 hover:rotate-90 transition-transform duration-200" title="Bersihkan pencarian">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-2 shrink-0 flex-wrap">
          <template x-for="f in filters" :key="f.key">
            <button type="button" @click="typeFilter = f.key"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 active:scale-95"
              :class="typeFilter === f.key
                ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/25 scale-[1.03]'
                : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-indigo-300 hover:text-indigo-600'">
              <span :class="f.dot"></span>
              <span x-text="f.label"></span>
            </button>
          </template>
          <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>
          <label class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold cursor-pointer bg-gray-50 border border-gray-200 transition-all duration-200 hover:border-indigo-300">
            <input type="checkbox" x-model="activeOnly" class="w-3.5 h-3.5 accent-emerald-600">
            <span :class="activeOnly ? 'text-emerald-600' : 'text-gray-500'">Aktif saja</span>
          </label>
          <a href="{{ route('admin.projects.create') }}" class="shimmer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Proyek
          </a>
        </div>
      </div>

      <div class="px-5 py-2.5 bg-gray-50/60 border-b border-gray-100 flex items-center gap-2 text-xs text-gray-400">
        <span x-show="filtered.length === 0" class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg> Tidak ada hasil</span>
        <span x-show="filtered.length > 0" class="flex items-center gap-1.5"><span class="text-indigo-500 font-bold" x-text="filtered.length"></span> proyek ditampilkan</span>
      </div>

      {{-- Cards grid --}}
      <template x-if="filtered.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-5">
          <template x-for="(p, i) in filtered" :key="p.id">
            <article class="card-enter group relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-1.5 hover:border-indigo-100 transition-all duration-300"
                     :style="'animation-delay:' + (i * 60) + 'ms'">

              {{-- Thumbnail --}}
              <div class="relative aspect-video bg-gray-100 overflow-hidden">
                <template x-if="p.thumbnail">
                  <img :src="p.thumbnail" :alt="p.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1" loading="lazy">
                </template>
                <template x-if="!p.thumbnail">
                  <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z"/></svg>
                  </div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute top-3 right-3 flex gap-2">
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide shadow" :class="p.type === 'data_analyst' ? 'bg-emerald-500/95 text-white' : 'bg-indigo-500/95 text-white'">
                    <span x-text="p.type === 'data_analyst' ? 'Data Analyst' : 'UI/UX'"></span>
                  </span>
                </div>
                <div class="absolute bottom-3 left-3">
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold shadow transition-all duration-300"
                        :class="p.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-500'">
                    <span class="w-1.5 h-1.5 rounded-full" :class="p.is_active ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400'"></span>
                    <span x-text="p.is_active ? 'Aktif' : 'Non-aktif'"></span>
                  </span>
                </div>
                <span class="absolute top-3 left-3 w-8 h-8 inline-flex items-center justify-center rounded-lg bg-white/90 backdrop-blur text-xs font-extrabold text-indigo-600 shadow transition-transform duration-300 group-hover:scale-110" x-text="String(i + 1).padStart(2, '0')"></span>
              </div>

              {{-- Body --}}
              <div class="p-5">
                <h3 class="text-sm font-extrabold text-gray-800 group-hover:text-indigo-700 transition-colors duration-200" x-text="p.title"></h3>
                <p class="text-xs text-gray-400 font-medium mt-0.5" x-text="p.subtitle"></p>
                <p class="mt-3 text-xs text-gray-500 leading-relaxed line-clamp-2 whitespace-pre-line" x-text="p.description"></p>
              </div>

              {{-- Actions --}}
              <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50 flex items-center gap-1.5">
                <a :href="p.editUrl" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                  Edit
                </a>
                <template x-if="p.caseUrl">
                  <a :href="p.caseUrl" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-white bg-emerald-50 hover:bg-emerald-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Case Study
                  </a>
                </template>
                <button type="button" @click="deleteTarget = p" class="ml-auto inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-white bg-red-50 hover:bg-red-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                  Hapus
                </button>
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
          <p class="mt-3 text-sm font-semibold text-gray-600">Tidak ada proyek yang cocok</p>
          <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci atau filter pencarianmu.</p>
        </div>
      </template>

      <template x-if="total === 0">
        <div x-transition:enter="transition ease-out duration-500" class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Belum ada data proyek</p>
          <p class="mt-1 text-xs text-gray-400">Tambahkan proyek pertamamu untuk mulai membangun portfolio.</p>
          <a href="{{ route('admin.projects.create') }}" class="shimmer mt-5 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Proyek
          </a>
        </div>
      </template>
    </div>

    {{-- Delete modal --}}
    <div x-show="deleteTarget" @keydown.escape.window="deleteTarget = null"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         :class="deleteTarget ? '' : 'pointer-events-none'">
      <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteTarget = null"></div>
      <div x-show="deleteTarget"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-50 -translate-y-10 rotate-6"
           x-transition:enter-end="opacity-100 scale-100 translate-y-0 rotate-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100 translate-y-0"
           x-transition:leave-end="opacity-0 scale-75 translate-y-6"
           class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
          <div class="animate-shake w-11 h-11 rounded-full bg-red-50 text-red-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
          </div>
          <div class="min-w-0">
            <h3 class="text-base font-bold text-gray-800">Hapus proyek ini?</h3>
            <p class="mt-1 text-sm text-gray-500">Proyek <span class="font-semibold text-gray-700" x-text="deleteTarget && deleteTarget.title"></span> beserta case study-nya akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
        </div>
        <template x-if="deleteTarget">
          <div class="mt-4 flex items-center gap-3 rounded-xl bg-gray-50 border border-gray-100 px-3 py-2.5">
            <template x-if="deleteTarget.thumbnail">
              <img :src="deleteTarget.thumbnail" class="w-12 h-8 object-cover rounded-md" alt="">
            </template>
            <div class="min-w-0">
              <p class="text-xs font-bold text-gray-700 truncate" x-text="deleteTarget.title"></p>
              <p class="text-[11px] text-gray-400" x-text="deleteTarget.subtitle"></p>
            </div>
          </div>
        </template>
        <div class="mt-6 flex justify-end gap-3">
          <button type="button" @click="deleteTarget = null" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:scale-95">Batal</button>
          <form :action="deleteTarget ? deleteTarget.deleteUrl : '#'" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="animate-pulse-ring px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:scale-95 shadow-sm shadow-red-600/30">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function projectsList(projects) {
      return {
        projects: projects,
        query: '',
        typeFilter: 'all',
        activeOnly: false,
        deleteTarget: null,
        displayTotal: 0,
        displayActive: 0,

        filters: [
          { key: 'all', label: 'Semua', dot: 'hidden' },
          { key: 'ux', label: 'UI/UX', dot: 'w-2 h-2 rounded-full bg-indigo-500' },
          { key: 'data_analyst', label: 'Data', dot: 'w-2 h-2 rounded-full bg-emerald-500' },
        ],

        init() {
          this.$nextTick(() => {
            this.animateNumber('displayTotal', this.total, 750);
            setTimeout(() => this.animateNumber('displayActive', this.activeCount, 650), 250);
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

        get total() { return this.projects.length; },

        get activeCount() { return this.projects.filter((p) => p.is_active).length; },
        get uxCount() { return this.projects.filter((p) => p.type === 'ux').length; },
        get dataCount() { return this.projects.filter((p) => p.type === 'data_analyst').length; },

        get filtered() {
          const q = (this.query || '').trim().toLowerCase();
          return this.projects.filter((p) => {
            if (this.typeFilter !== 'all' && p.type !== this.typeFilter) return false;
            if (this.activeOnly && !p.is_active) return false;
            if (q && ![p.title, p.subtitle, p.description].filter(Boolean).join(' ').toLowerCase().includes(q)) return false;
            return true;
          });
        },
      };
    }
  </script>
@endpush