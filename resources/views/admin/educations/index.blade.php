@extends('layouts.admin')

@section('title', 'Pendidikan')
@section('header-title', 'Daftar Pendidikan')

@push('styles')
  <style>
    @keyframes floatUpE {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpE .6s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyE {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyE 3.4s ease-in-out infinite; }

    @keyframes wiggleE {
      0%, 100% { transform: rotate(-4deg); }
      50% { transform: rotate(4deg); }
    }
    .animate-wiggle { animation: wiggleE 2.6s ease-in-out infinite; }

    @keyframes shakeE {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(3px); }
      30%, 50%, 70% { transform: translateX(-5px); }
      40%, 60% { transform: translateX(5px); }
    }
    .animate-shake { animation: shakeE .55s ease both; }

    @keyframes shineE {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
      animation: shineE 2.6s ease-in-out infinite;
    }

    @keyframes pulseRingE {
      0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, .45); }
      100% { box-shadow: 0 0 0 16px rgba(239, 68, 68, 0); }
    }
    .animate-pulse-ring { animation: pulseRingE 1.6s ease-out infinite; }
  </style>
@endpush

@section('content')
  @php
    $items = $educations->map(fn ($e) => [
      'id' => $e->id,
      'institution' => $e->institution,
      'degree' => $e->degree,
      'startDate' => $e->start_date,
      'endDate' => $e->end_date,
      'isCurrent' => in_array(strtolower($e->end_date), ['sekarang', 'present', 'now', 'ongoing', '']),
      'sortOrder' => $e->sort_order,
      'period' => trim($e->start_date . ($e->end_date ? ' — ' . $e->end_date : '')),
      'editUrl' => route('admin.educations.edit', $e),
      'deleteUrl' => route('admin.educations.destroy', $e),
      'initial' => mb_substr($e->institution, 0, 1),
    ])->values();
  @endphp

  <div class="space-y-6" x-cloak x-data='educationsList(@json($items, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    {{-- Toolbar --}}
    <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:100ms">
      <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center gap-4">
        <div class="relative flex-1 min-w-0 group/search">
          <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 pointer-events-none group-focus-within/search:text-emerald-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
          </span>
          <input type="search" x-model="query" placeholder="Cari institusi, bidang, atau periode..."
            class="w-full pl-11 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-400 placeholder:text-gray-400 transition-all duration-200">
          <button x-show="query" x-transition.opacity.duration.150ms @click="query = ''" type="button"
            class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 hover:rotate-90 transition-transform duration-200" title="Bersihkan pencarian">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-2 shrink-0 flex-wrap">
          <template x-for="f in filters" :key="f.key">
            <button type="button" @click="statusFilter = f.key"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-200 active:scale-95"
              :class="statusFilter === f.key
                ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/25 scale-[1.03]'
                : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-emerald-300 hover:text-emerald-600'">
              <span :class="f.dot"></span>
              <span x-text="f.label"></span>
            </button>
          </template>
          <a href="{{ route('admin.educations.create') }}" class="shimmer inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-emerald-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pendidikan
          </a>
        </div>
      </div>

      <div class="px-5 py-2.5 bg-gray-50/60 border-b border-gray-100 flex items-center gap-2 text-xs text-gray-400">
        <span x-show="filtered.length === 0" class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg> Tidak ada hasil</span>
        <span x-show="filtered.length > 0" class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold" x-text="filtered.length"></span> pendidikan ditampilkan</span>
      </div>

      {{-- Timeline --}}
      <template x-if="filtered.length > 0">
        <div class="p-6 relative">
          <div class="absolute left-[46px] top-8 bottom-8 w-px bg-gradient-to-b from-emerald-200 via-gray-200 to-gray-100"></div>
          <div class="space-y-5">
            <template x-for="(e, i) in filtered" :key="e.id">
              <div class="anim-in group relative flex gap-5 rounded-2xl border border-gray-100 shadow-sm p-5 overflow-hidden hover:shadow-xl hover:-translate-y-1 hover:border-emerald-100 transition-all duration-300"
                   :style="'animation-delay:' + (i * 70) + 'ms'">
                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b transition-colors duration-300" :class="e.isCurrent ? 'from-emerald-400 to-emerald-600' : 'from-sky-400 to-indigo-500'"></div>
                <div class="shrink-0 z-10">
                  <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-extrabold shadow-md transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6"
                       :class="e.isCurrent ? 'bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-emerald-500/30' : 'bg-gradient-to-br from-sky-400 to-indigo-600 shadow-indigo-500/30'"
                       x-text="e.initial.toUpperCase()"></div>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-sm font-extrabold text-gray-800 group-hover:text-emerald-700 transition-colors duration-200 truncate" x-text="e.institution"></h3>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                      :class="e.isCurrent
                        ? 'bg-emerald-50 text-emerald-600 border border-emerald-200'
                        : 'bg-sky-50 text-sky-600 border border-sky-200'">
                      <span class="w-1.5 h-1.5 rounded-full" :class="e.isCurrent ? 'bg-emerald-500 animate-pulse' : 'bg-sky-400'"></span>
                      <span x-text="e.isCurrent ? 'Berjalan' : 'Selesai'"></span>
                    </span>
                  </div>
                  <p class="text-xs text-gray-500 font-semibold mt-0.5" x-text="e.degree"></p>
                  <div class="mt-2.5 flex flex-wrap items-center gap-x-4 gap-y-1.5">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500">
                      <svg class="w-3.5 h-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                      <span x-text="e.period"></span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400">
                      <svg class="w-3.5 h-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                      Urutan #<b class="tabular-nums" x-text="e.sortOrder"></b>
                    </span>
                  </div>
                </div>
                <div class="shrink-0 flex flex-col sm:flex-row items-center gap-1.5 self-center">
                  <a :href="e.editUrl" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                    Edit
                  </a>
                  <button type="button" @click="deleteTarget = e" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-white bg-red-50 hover:bg-red-600 px-3 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    Hapus
                  </button>
                </div>
              </div>
            </template>
          </div>
        </div>
      </template>

      {{-- Empty states --}}
      <template x-if="total > 0">
        <div x-show="filtered.length === 0" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95" class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Tidak ada pendidikan yang cocok</p>
          <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci atau filter pencarianmu.</p>
        </div>
      </template>

      <template x-if="total === 0">
        <div class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-400 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Belum ada data pendidikan</p>
          <p class="mt-1 text-xs text-gray-400">Tambahkan riwayat pendidikanmu.</p>
          <a href="{{ route('admin.educations.create') }}" class="shimmer mt-5 inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pendidikan
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
            <h3 class="text-base font-bold text-gray-800">Hapus riwayat ini?</h3>
            <p class="mt-1 text-sm text-gray-500">Pendidikan dari <span class="font-semibold text-gray-700" x-text="deleteTarget && deleteTarget.institution"></span> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
        </div>
        <template x-if="deleteTarget">
          <div class="mt-4 flex items-center gap-3 rounded-xl bg-gray-50 border border-gray-100 px-3 py-2.5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-extrabold text-sm shrink-0" :class="deleteTarget.isCurrent ? 'bg-gradient-to-br from-emerald-400 to-emerald-600' : 'bg-gradient-to-br from-sky-400 to-indigo-600'" x-text="deleteTarget.initial.toUpperCase()"></div>
            <div class="min-w-0">
              <p class="text-xs font-bold text-gray-700 truncate" x-text="deleteTarget.institution"></p>
              <p class="text-[11px] text-gray-400 truncate" x-text="deleteTarget.degree + ' · ' + deleteTarget.period"></p>
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
    function educationsList(items) {
      return {
        items: items,
        query: '',
        statusFilter: 'all',
        deleteTarget: null,
        displayTotal: 0,
        displayDone: 0,
        displayCurrent: 0,

        filters: [
          { key: 'all', label: 'Semua', dot: 'hidden' },
          { key: 'done', label: 'Selesai', dot: 'w-2 h-2 rounded-full bg-sky-500' },
          { key: 'current', label: 'Berjalan', dot: 'w-2 h-2 rounded-full bg-emerald-500' },
        ],

        init() {
          this.$nextTick(() => {
            this.animateNumber('displayTotal', this.total, 750);
            setTimeout(() => this.animateNumber('displayDone', this.doneCount, 650), 200);
            setTimeout(() => this.animateNumber('displayCurrent', this.currentCount, 650), 350);
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
        get doneCount() { return this.items.filter((e) => !e.isCurrent).length; },
        get currentCount() { return this.items.filter((e) => e.isCurrent).length; },

        get filtered() {
          const q = (this.query || '').trim().toLowerCase();
          return this.items.filter((e) => {
            if (this.statusFilter === 'done' && e.isCurrent) return false;
            if (this.statusFilter === 'current' && !e.isCurrent) return false;
            if (q && ![e.institution, e.degree, e.period].filter(Boolean).join(' ').toLowerCase().includes(q)) return false;
            return true;
          });
        },
      };
    }
  </script>
@endpush