@extends('layouts.admin')

@section('title', 'Pengalaman Kerja')
@section('header-title', 'Daftar Pengalaman Kerja')

@push('styles')
  <style>
    @keyframes floatUp {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUp .65s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floaty {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floaty 3.2s ease-in-out infinite; }

    @keyframes wiggle {
      0%, 100% { transform: rotate(-4deg); }
      50% { transform: rotate(4deg); }
    }
    .animate-wiggle { animation: wiggle 2.6s ease-in-out infinite; }

    @keyframes shakeX {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(3px); }
      30%, 50%, 70% { transform: translateX(-5px); }
      40%, 60% { transform: translateX(5px); }
    }
    .animate-shake { animation: shakeX .55s ease both; }

    @keyframes shimmerSlide {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
      animation: shimmerSlide 2.6s ease-in-out infinite;
    }

    @keyframes pulseRing {
      0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, .45); }
      100% { box-shadow: 0 0 0 16px rgba(239, 68, 68, 0); }
    }
    .animate-pulse-ring { animation: pulseRing 1.6s ease-out infinite; }

    .drag-grab { cursor: grab; }
    .drag-grab:active { cursor: grabbing; }

    .list-enter {
      animation: floatUp .5s cubic-bezier(.22, 1, .36, 1) both;
    }
  </style>
@endpush

@section('content')
  <div class="space-y-6" x-cloak x-data='experienceList(@json($items))'>

    {{-- Toolbar + list --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="relative flex-1 min-w-0 group/search">
          <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 pointer-events-none group-focus-within/search:text-indigo-500 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
          </span>
          <input type="search" x-model="query" placeholder="Cari judul, perusahaan, periode, atau deskripsi..."
            class="w-full pl-11 pr-10 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-400 placeholder:text-gray-400 transition-all duration-200">
          <button x-show="query" x-transition.opacity.duration.150ms @click="query = ''" type="button"
            class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 hover:rotate-90 transition-transform duration-200" title="Bersihkan pencarian">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <div x-show="savingOrder" x-transition class="inline-flex items-center gap-2 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-full px-3 py-1.5">
            <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-6.219-8.56"/></svg>
            Menyimpan...
          </div>
          <div x-show="savedNotice && !savingOrder" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" class="inline-flex items-center gap-2 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-full px-3 py-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Urutan disimpan
          </div>
          <a href="{{ route('admin.experiences.create') }}" class="shimmer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm shadow-indigo-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pengalaman
          </a>
        </div>
      </div>

      <div x-show="total > 0" x-transition class="px-5 py-2.5 bg-gray-50/60 border-b border-gray-100 flex items-center gap-2 text-xs text-gray-400">
        <svg class="w-3.5 h-3.5 animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <span>Seret kartu untuk mengatur urutan tampilan</span>
      </div>

      {{-- List --}}
      <ul class="divide-y divide-gray-100">
        <template x-for="(exp, i) in filteredItems" :key="exp.id">
          <li draggable="true"
              @dragstart="onDragStart(i)"
              @dragenter.prevent="onDragEnter(i)"
              @dragover.prevent
              @dragend="onDragEnd()"
              class="list-enter group relative flex items-start sm:items-center gap-3 sm:gap-4 px-4 sm:px-6 py-4 transition-all duration-200 hover:bg-indigo-50/40"
              :style="'animation-delay:' + (i * 70) + 'ms'"
              :class="draggingIndex === i ? 'bg-indigo-50/70 shadow-inner' : 'hover:bg-gray-50/70'">

            {{-- Drag handle + order --}}
            <div class="flex items-center gap-3 shrink-0 pt-0.5 sm:pt-0 sm:w-20">
              <span class="drag-grab text-gray-300 group-hover:text-gray-500 group-hover:scale-110 transition-all duration-200" title="Seret untuk mengurutkan">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM10 5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM13 5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM7 10a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM10 10a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM13 10a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM7 15a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM10 15a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM13 15a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
              </span>
              <span class="hidden sm:inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-110 text-xs font-semibold text-gray-500 transition-all duration-200" x-text="i + 1"></span>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                  <h3 class="text-sm font-semibold text-gray-800 leading-snug group-hover:text-indigo-700 transition-colors duration-200" x-text="exp.title"></h3>
                  <div class="mt-1 flex items-center gap-2 flex-wrap text-xs text-gray-400">
                    <template x-if="exp.company">
                      <span class="inline-flex items-center gap-1 group-hover:text-gray-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                        <span x-text="exp.company"></span>
                      </span>
                    </template>
                    <template x-if="exp.location">
                      <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <span x-text="exp.location"></span>
                      </span>
                    </template>
                    <template x-if="exp.job_type && jobTypes[exp.job_type]">
                      <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 font-semibold" :class="jobTypes[exp.job_type].cls">
                        <span class="w-1.5 h-1.5 rounded-full" :class="jobTypes[exp.job_type].dot"></span>
                        <span x-text="jobTypes[exp.job_type].label"></span>
                      </span>
                    </template>
                  </div>
                </div>
                <button type="button" @click="toggleEntry(exp.id)"
                        class="shrink-0 p-1 rounded-lg text-gray-300 hover:text-indigo-600 hover:bg-indigo-50 transition-colors duration-150 sm:hidden"
                        title="Lihat deskripsi">
                  <svg class="w-5 h-5 transition-transform duration-200" :class="expandedEntries[exp.id] && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
              </div>

              <div class="mt-1.5 flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-full px-2.5 py-0.5 transition-transform duration-200 group-hover:scale-[1.03]">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                  <span x-text="exp.period"></span>
                </span>
                <template x-if="exp.company">
                  <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    <span x-text="exp.company"></span>
                  </span>
                </template>
              </div>

              <p class="mt-2 text-sm text-gray-500 whitespace-pre-line line-clamp-2"
                 :class="expandedEntries[exp.id] ? 'line-clamp-none' : 'line-clamp-2'"
                 x-text="exp.description"></p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-1.5 shrink-0">
              <a :href="exp.editUrl" class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 hover:scale-110 transition-all duration-200" title="Edit">
                <svg class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
              </a>
              <button type="button" @click="setDeleteTarget(exp)" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 hover:scale-110 transition-all duration-200" title="Hapus">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
              </button>
            </div>
          </li>
        </template>
      </ul>

      {{-- Empty states --}}
      <template x-if="total > 0">
        <div x-show="filteredItems.length === 0" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95" class="px-6 py-14 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Tidak ada hasil untuk pencarian</p>
          <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci pencarianmu.</p>
        </div>
      </template>

      <template x-if="total === 0">
        <div x-transition:enter="transition ease-out duration-500" class="px-6 py-16 text-center">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 animate-floaty">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          </div>
          <p class="mt-3 text-sm font-semibold text-gray-600">Belum ada data pengalaman</p>
          <p class="mt-1 text-xs text-gray-400">Tambahkan pengalaman kerja pertamamu untuk mulai membangun portfolio.</p>
          <a href="{{ route('admin.experiences.create') }}" class="shimmer mt-5 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pengalaman
          </a>
        </div>
      </template>
    </div>

    {{-- Delete confirmation modal (animated) --}}
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
            <h3 class="text-base font-bold text-gray-800">Hapus pengalaman ini?</h3>
            <p class="mt-1 text-sm text-gray-500">Data <span class="font-semibold text-gray-700" x-text="deleteTarget && (deleteTarget.company ? deleteTarget.company + ' — ' : '') + (deleteTarget ? deleteTarget.title : '')"></span> akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
        </div>
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
    function experienceList(initialItems) {
      return {
        items: initialItems,
        query: '',
        savingOrder: false,
        savedNotice: false,
        draggingIndex: null,
        deleteTarget: null,
        expandedEntries: {},
        displayTotal: 0,

        jobTypes: {
          full_time: { label: 'Full-time', cls: 'bg-indigo-50 text-indigo-700 border-indigo-100', dot: 'bg-indigo-500' },
          part_time: { label: 'Part-time', cls: 'bg-sky-50 text-sky-700 border-sky-100', dot: 'bg-sky-500' },
          freelance: { label: 'Freelance', cls: 'bg-emerald-50 text-emerald-700 border-emerald-100', dot: 'bg-emerald-500' },
          internship: { label: 'Internship', cls: 'bg-amber-50 text-amber-700 border-amber-100', dot: 'bg-amber-500' },
          contract: { label: 'Kontrak', cls: 'bg-violet-50 text-violet-700 border-violet-100', dot: 'bg-violet-500' },
        },

        init() {
          this.$nextTick(() => this.animateCount());
        },

        animateCount() {
          const target = this.items.length;
          const duration = 750;
          const start = performance.now();
          const step = (t) => {
            const p = Math.min((t - start) / duration, 1);
            this.displayTotal = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(step);
          };
          requestAnimationFrame(step);
        },

        get total() {
          return this.items.length;
        },

        get latestTitle() {
          return this.items.length ? this.items[0].title : '—';
        },

        get periodRange() {
          const years = [];
          this.items.forEach((e) => (e.period.match(/\d{4}/g) || []).forEach((y) => years.push(Number(y))));
          if (!years.length) return '—';
          const min = Math.min(...years);
          const max = Math.max(...years);
          return min === max ? String(min) : min + ' — ' + max;
        },

        get filteredItems() {
          const q = (this.query || '').trim().toLowerCase();
          if (!q) return this.items;
          return this.items.filter((e) =>
            [e.title, e.company, e.location, e.period, e.description].filter(Boolean).join(' ').toLowerCase().includes(q)
          );
        },

        onDragStart(index) {
          if (this.query) return;
          this.draggingIndex = index;
        },

        onDragEnter(index) {
          if (this.draggingIndex === null || this.draggingIndex === index) return;
          const moved = this.items.splice(this.draggingIndex, 1)[0];
          this.items.splice(index, 0, moved);
          this.draggingIndex = index;
        },

        onDragEnd() {
          if (this.draggingIndex !== null) this.saveOrder();
          this.draggingIndex = null;
        },

        saveOrder() {
          this.savingOrder = true;
          this.savedNotice = false;
          fetch('{{ route("admin.experiences.reorder") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': window.csrfToken,
            },
            body: JSON.stringify({ order: this.items.map((e) => e.id) }),
          })
            .then((r) => r.json())
            .then(() => {
              this.savingOrder = false;
              this.savedNotice = true;
              this.animateCount();
              setTimeout(() => (this.savedNotice = false), 2500);
            })
            .catch(() => (this.savingOrder = false));
        },

        toggleEntry(id) {
          this.expandedEntries[id] = !this.expandedEntries[id];
        },

        setDeleteTarget(item) {
          this.deleteTarget = item;
        },
      };
    }
  </script>
  <script>window.csrfToken = @json(csrf_token());</script>
@endpush