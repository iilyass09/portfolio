@extends('layouts.admin')

@section('title', 'Keahlian')
@section('header-title', 'Daftar Keahlian')

@push('styles')
  <style>
    @keyframes floatUpS {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpS .6s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyS {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyS 3.4s ease-in-out infinite; }

    @keyframes wiggleS {
      0%, 100% { transform: rotate(-4deg); }
      50% { transform: rotate(4deg); }
    }
    .animate-wiggle { animation: wiggleS 2.6s ease-in-out infinite; }

    @keyframes shakeS {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(3px); }
      30%, 50%, 70% { transform: translateX(-5px); }
      40%, 60% { transform: translateX(5px); }
    }
    .animate-shake { animation: shakeS .55s ease both; }

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
      animation: shineS 2.6s ease-in-out infinite;
    }

    @keyframes pulseRingS {
      0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, .45); }
      100% { box-shadow: 0 0 0 16px rgba(239, 68, 68, 0); }
    }
    .animate-pulse-ring { animation: pulseRingS 1.6s ease-out infinite; }

    .chip-enter { animation: floatUpS .45s cubic-bezier(.22, 1, .36, 1) both; }
  </style>
@endpush

@section('content')
  @php
    $catMeta = [
      'marketplace' => ['label' => 'Marketplace', 'dot' => 'bg-amber-500', 'chip' => 'bg-amber-50 text-amber-700 border-amber-200', 'solid' => 'bg-amber-500'],
      'uiux' => ['label' => 'UI/UX', 'dot' => 'bg-indigo-500', 'chip' => 'bg-indigo-50 text-indigo-700 border-indigo-200', 'solid' => 'bg-indigo-500'],
      'data' => ['label' => 'Data', 'dot' => 'bg-emerald-500', 'chip' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'solid' => 'bg-emerald-500'],
      'technical' => ['label' => 'Technical', 'dot' => 'bg-violet-500', 'chip' => 'bg-violet-50 text-violet-700 border-violet-200', 'solid' => 'bg-violet-500'],
      'general' => ['label' => 'General', 'dot' => 'bg-sky-500', 'chip' => 'bg-sky-50 text-sky-700 border-sky-200', 'solid' => 'bg-sky-500'],
    ];
    $items = $skills->map(function ($s) use ($catMeta) {
      $m = $catMeta[$s->category] ?? $catMeta['general'];
      return [
        'id' => $s->id,
        'name' => $s->name,
        'category' => $s->category,
        'catLabel' => $m['label'],
        'dot' => $m['dot'],
        'chipClass' => $m['chip'],
        'sortOrder' => $s->sort_order,
        'editUrl' => route('admin.skills.edit', $s),
        'deleteUrl' => route('admin.skills.destroy', $s),
      ];
    })->values();
  @endphp

  <div class="space-y-6" x-cloak x-data='skillsList(@json($items, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    {{-- Toolbar --}}
    <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:100ms">
      <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center gap-4">
        <div class="relative flex-1 min-w-0 group/search">
          <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 pointer-events-none group-focus-within/search:text-indigo-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
          </span>
          <input type="search" x-model="query" placeholder="Cari nama keahlian atau kategori..."
            class="w-full pl-11 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-400 placeholder:text-gray-400 transition-all duration-200">
          <button x-show="query" x-transition.opacity.duration.150ms @click="query = ''" type="button"
            class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 hover:rotate-90 transition-transform duration-200" title="Bersihkan pencarian">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-2 shrink-0 flex-wrap">
          <template x-for="f in filters" :key="f.key">
            <button type="button" @click="catFilter = f.key"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 active:scale-95"
              :class="catFilter === f.key
                ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/25 scale-[1.03]'
                : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-indigo-300 hover:text-indigo-600'">
              <span :class="f.dot"></span>
              <span x-text="f.label"></span>
            </button>
          </template>
          <a href="{{ route('admin.skills.create') }}" class="shimmer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Skill
          </a>
        </div>
      </div>

      <div class="px-5 py-2.5 bg-gray-50/60 border-b border-gray-100 flex items-center gap-2 text-xs text-gray-400">
        <span x-show="filtered.length === 0" class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg> Tidak ada hasil</span>
        <span x-show="filtered.length > 0" class="flex items-center gap-1.5"><span class="text-indigo-500 font-bold" x-text="filtered.length"></span> keahlian ditampilkan</span>
      </div>

      {{-- Grouped by kategori --}}
      <template x-if="filtered.length > 0">
        <div class="p-5 space-y-5">
          <template x-for="(g, gi) in grouped" :key="'cat-' + g.key">
            <section x-show="g.items.length > 0" class="anim-in" :style="'animation-delay:' + (gi * 70) + 'ms'">
              <div class="flex items-center gap-3 mb-3">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow-sm shrink-0" :class="g.solid">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                </span>
                <div class="flex-1 min-w-0">
                  <div class="flex items-baseline gap-2">
                    <h3 class="text-sm font-extrabold text-gray-800 truncate" x-text="g.label"></h3>
                    <span class="text-xs font-bold text-gray-400 tabular-nums" x-text="'(' + g.items.length + ')'"></span>
                  </div>
                  <div class="mt-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 ease-out" :class="g.bar" :style="'width:' + (total ? Math.round(100 * g.items.length / total) : 0) + '%'"></div>
                  </div>
                </div>
                <span class="text-xs font-extrabold tabular-nums" :class="g.chipText" x-text="Math.round(100 * g.items.length / (total || 1)) + '%'"></span>
              </div>

              <div class="flex flex-wrap gap-2.5">
                <template x-for="(s, si) in g.items" :key="s.id">
                  <div class="chip-enter group inline-flex items-center gap-2 pl-3 pr-1.5 py-1.5 rounded-2xl border shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
                       :class="s.chipClass" :style="'animation-delay:' + (si * 50) + 'ms'">
                    <span class="text-[11px] font-extrabold text-gray-400 tabular-nums" x-text="String(s.sortOrder).padStart(2, '0')"></span>
                    <span class="text-sm font-bold text-inherit max-w-[200px] truncate" x-text="s.name"></span>
                    <span class="w-px h-4 bg-current opacity-20"></span>
                    <a :href="s.editUrl" class="w-7 h-7 rounded-lg inline-flex items-center justify-center transition-all duration-200 hover:bg-white hover:shadow active:scale-90 text-current opacity-60 hover:opacity-100">
                      <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                    </a>
                    <button type="button" @click="deleteTarget = s" class="w-7 h-7 rounded-lg inline-flex items-center justify-center transition-all duration-200 hover:bg-white hover:shadow active:scale-90 text-red-400 hover:text-red-600">
                      <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    </button>
                  </div>
                </template>
              </div>
            </section>
          </template>
        </div>
      </template>

      {{-- Empty states --}}
      <template x-if="total > 0">
        <div x-show="filtered.length === 0" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95" class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Tidak ada keahlian yang cocok</p>
          <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci atau filter kategorimu.</p>
        </div>
      </template>

      <template x-if="total === 0">
        <div class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Belum ada data keahlian</p>
          <p class="mt-1 text-xs text-gray-400">Tambahkan keahlian pertamamu.</p>
          <a href="{{ route('admin.skills.create') }}" class="shimmer mt-5 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Skill
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
            <h3 class="text-base font-bold text-gray-800">Hapus keahlian ini?</h3>
            <p class="mt-1 text-sm text-gray-500">Keahlian <span class="font-semibold text-gray-700" x-text="deleteTarget && deleteTarget.name"></span> akan dihapus permanen dari portfolio. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
        </div>
        <template x-if="deleteTarget">
          <div class="mt-4 flex items-center gap-3 rounded-xl bg-gray-50 border border-gray-100 px-3 py-2.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold" :class="deleteTarget.chipClass">
              <span class="w-1.5 h-1.5 rounded-full" :class="deleteTarget.dot"></span>
              <span x-text="deleteTarget.catLabel"></span>
            </span>
            <p class="text-xs font-bold text-gray-700 truncate" x-text="deleteTarget.name"></p>
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
    function skillsList(items) {
      return {
        items: items,
        query: '',
        catFilter: 'all',
        deleteTarget: null,
        displayTotal: 0,

        filters: [
          { key: 'all', label: 'Semua', dot: 'hidden' },
          { key: 'marketplace', label: 'Marketplace', dot: 'w-2 h-2 rounded-full bg-amber-500' },
          { key: 'uiux', label: 'UI/UX', dot: 'w-2 h-2 rounded-full bg-indigo-500' },
          { key: 'data', label: 'Data', dot: 'w-2 h-2 rounded-full bg-emerald-500' },
          { key: 'technical', label: 'Technical', dot: 'w-2 h-2 rounded-full bg-violet-500' },
          { key: 'general', label: 'General', dot: 'w-2 h-2 rounded-full bg-sky-500' },
        ],

        catGroups: [
          { key: 'marketplace', label: 'Marketplace', solid: 'bg-amber-500', bar: 'bg-amber-400', chipText: 'text-amber-600', hex: 'amber' },
          { key: 'uiux', label: 'UI/UX', solid: 'bg-indigo-500', bar: 'bg-indigo-400', chipText: 'text-indigo-600', hex: 'indigo' },
          { key: 'data', label: 'Data', solid: 'bg-emerald-500', bar: 'bg-emerald-400', chipText: 'text-emerald-600', hex: 'emerald' },
          { key: 'technical', label: 'Technical', solid: 'bg-violet-500', bar: 'bg-violet-400', chipText: 'text-violet-600', hex: 'violet' },
          { key: 'general', label: 'General', solid: 'bg-sky-500', bar: 'bg-sky-400', chipText: 'text-sky-600', hex: 'sky' },
        ],

        init() {
          this.$nextTick(() => {
            this.animateNumber('displayTotal', this.total, 750);
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

        get usedCategoryCount() {
          return new Set(this.items.map((s) => s.category)).size;
        },

        get topCategory() {
          const counts = {};
          this.items.forEach((s) => { counts[s.catLabel] = (counts[s.catLabel] || 0) + 1; });
          let best = null;
          Object.entries(counts).forEach(([k, v]) => { if (!best || v > best.v) best = { k, v }; });
          return best ? best.k : '-';
        },

        get topCount() {
          const counts = {};
          this.items.forEach((s) => { counts[s.catLabel] = (counts[s.catLabel] || 0) + 1; });
          let best = null;
          Object.entries(counts).forEach(([k, v]) => { if (!best || v > best.v) best = { k, v }; });
          return best ? best.v : 0;
        },

        get filtered() {
          const q = (this.query || '').trim().toLowerCase();
          return this.items.filter((s) => {
            if (this.catFilter !== 'all' && s.category !== this.catFilter) return false;
            if (q && ![s.name, s.catLabel].filter(Boolean).join(' ').toLowerCase().includes(q)) return false;
            return true;
          });
        },

        get grouped() {
          return this.catGroups.map((g) => ({
            ...g,
            items: this.filtered.filter((s) => s.category === g.key),
          }));
        },
      };
    }
  </script>
@endpush