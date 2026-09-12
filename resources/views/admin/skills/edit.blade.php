@extends('layouts.admin')

@section('title', 'Edit Skill')
@section('header-title', 'Edit Skill')

@push('styles')
  <style>
    @keyframes floatUpS {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpS .55s cubic-bezier(.22, 1, .36, 1) both; }

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
      background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.5) 50%, transparent 60%);
      animation: shineS 2.6s ease-in-out infinite;
    }

    .csl-field { transition: box-shadow .25s, border-color .25s; }
    .csl-field:focus-within { box-shadow: 0 0 0 4px rgba(99, 102, 241, .1); border-color: #818cf8; }
  </style>
@endpush

@section('content')
  <div class="max-w-4xl mx-auto space-y-6" x-cloak x-data='skillForm(@json([
    'name' => old('name', $skill->name),
    'category' => old('category', $skill->category),
    'sortOrder' => old('sort_order', $skill->sort_order),
  ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG))'>

    {{-- Hero banner --}}
    <div class="anim-in relative bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 rounded-2xl p-7 sm:p-8 overflow-hidden shadow-lg shadow-orange-500/25">
      <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/15 blur-2xl animate-floaty"></div>
      <div class="absolute -left-12 -bottom-12 w-40 h-40 rounded-full bg-yellow-300/30 blur-2xl animate-floaty" style="animation-delay:1s"></div>
      <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center text-white animate-floaty" style="animation-delay:.3s">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
        </div>
        <div>
          <h2 class="text-lg font-extrabold text-white" x-text="name || 'Edit Skill'"></h2>
          <p class="text-sm text-orange-100 mt-0.5">Perbarui keahlian, pratinjau langsung di kanan.</p>
        </div>
        <span class="ml-auto hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 text-white text-xs font-bold backdrop-blur">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Live Editor
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">
      {{-- Form --}}
      <form method="POST" action="{{ route('admin.skills.update', $skill) }}" x-on:submit="submitting = true" class="xl:col-span-3 space-y-5">
        @csrf
        @method('PUT')

        {{-- Data skill --}}
        <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:80ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-800">Data Keahlian</h3>
              <p class="text-xs text-gray-400">Nama, kategori, dan urutan tampil</p>
            </div>
          </div>

          <div class="p-6 space-y-5">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Skill <span class="text-red-400">*</span></label>
              <input type="text" name="name" x-model="name" required maxlength="80" placeholder="cth. Microsoft Excel, Figma, UI Research"
                class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-amber-400 transition-all duration-200">
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="name.length > 60 ? 'bg-rose-500' : 'bg-amber-400'" :style="'width:' + Math.min(100, (name.length / 80) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="name.length > 60 ? 'text-rose-500' : 'text-gray-400'" x-text="name.length + '/80'"></span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-400">*</span></label>
              <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-2">
                <template x-for="c in cats" :key="c.key">
                  <button type="button" @click="category = c.key"
                    class="py-2.5 px-2 rounded-xl text-xs font-bold border transition-all duration-200 active:scale-95 inline-flex items-center justify-center gap-1.5"
                    :class="category === c.key ? c.active : c.chip">
                    <span class="w-1.5 h-1.5 rounded-full" :class="category === c.key ? 'bg-white' : c.dot"></span>
                    <span x-text="c.label"></span>
                  </button>
                </template>
              </div>
              <input type="hidden" name="category" :value="category">
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan <span class="text-red-400">*</span></label>
              <div class="csl-field flex items-center gap-2 border border-gray-200 rounded-xl px-3.5 py-2.5 focus-within:border-amber-400 transition-all duration-200">
                <svg class="w-4 h-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <input type="number" name="sort_order" x-model.number="sortOrder" required placeholder="0"
                  class="flex-1 text-sm bg-transparent outline-none placeholder:text-gray-300 min-w-0">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-50 text-gray-400 text-[10px] font-bold shrink-0">Urutan #<b class="text-indigo-500 tabular-nums" x-text="Number(sortOrder) || 0"></b></span>
              </div>
            </div>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="anim-in flex flex-col sm:flex-row gap-3 sm:justify-end" style="animation-delay:160ms">
          <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
            Batal
          </a>
          <button type="submit" :disabled="submitting" class="shimmer inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 active:scale-95 shadow-sm shadow-amber-500/25 transition-all duration-200 hover:-translate-y-0.5" :class="submitting ? 'opacity-70 cursor-wait' : ''">
            <template x-if="!submitting">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
            </template>
            <template x-if="submitting">
              <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            </template>
            <span x-text="submitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
          </button>
        </div>
      </form>

      {{-- Live preview --}}
      <div class="xl:col-span-2 xl:sticky xl:top-6">
        <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:140ms">
          <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <div class="w-7 h-7 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              </div>
              <p class="text-sm font-bold text-gray-700">Pratinjau Chip</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live
            </span>
          </div>
          <div class="p-5 space-y-4">
            <div>
              <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">Tampil sebagai chip di halaman Tentang</p>
              <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl border shadow-sm text-sm font-bold animate-floaty"
                     :class="activeCat().chip">
                  <span class="w-2 h-2 rounded-full" :class="activeCat().dot"></span>
                  <span :class="!name ? 'opacity-30' : ''" x-text="name || 'Nama skill...'"></span>
                </div>
              </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-4">
              <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-3">Ringkasan</p>
              <div class="space-y-2.5">
                <div class="flex items-center justify-between text-xs">
                  <span class="text-gray-500 font-medium">Kategori</span>
                  <span class="inline-flex items-center gap-1.5 text-sm font-bold" :class="activeCat()['text']">
                    <span class="w-1.5 h-1.5 rounded-full" :class="activeCat().dot"></span>
                    <span x-text="activeCat().label"></span>
                  </span>
                </div>
                <div class="flex items-center justify-between text-xs">
                  <span class="text-gray-500 font-medium">Panjang nama</span>
                  <span class="font-bold text-gray-600 tabular-nums" :class="name.length > 60 ? 'text-rose-500' : ''" x-text="name.length + ' karakter'"></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                  <span class="text-gray-500 font-medium">Urutan tampil</span>
                  <span class="font-bold text-indigo-600 tabular-nums">#<span x-text="Number(sortOrder) || 0"></span></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                  <span class="text-gray-500 font-medium">Kesesuaian</span>
                  <span class="inline-flex items-center gap-1 font-bold text-emerald-600">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Siap ditampilkan
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function skillForm(initial) {
      return {
        name: initial.name || '',
        category: initial.category || 'marketplace',
        sortOrder: initial.sortOrder ?? 0,
        submitting: false,

        cats: [
          { key: 'marketplace', label: 'Marketplace', dot: 'bg-amber-500', chip: 'bg-amber-50 text-amber-700 border-amber-200', active: 'bg-amber-600 text-white border-amber-600 shadow-sm shadow-amber-600/25', text: 'text-amber-600' },
          { key: 'uiux', label: 'UI/UX', dot: 'bg-indigo-500', chip: 'bg-indigo-50 text-indigo-700 border-indigo-200', active: 'bg-indigo-600 text-white border-indigo-600 shadow-sm shadow-indigo-600/25', text: 'text-indigo-600' },
          { key: 'data', label: 'Data', dot: 'bg-emerald-500', chip: 'bg-emerald-50 text-emerald-700 border-emerald-200', active: 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-600/25', text: 'text-emerald-600' },
          { key: 'technical', label: 'Technical', dot: 'bg-violet-500', chip: 'bg-violet-50 text-violet-700 border-violet-200', active: 'bg-violet-600 text-white border-violet-600 shadow-sm shadow-violet-600/25', text: 'text-violet-600' },
          { key: 'general', label: 'General', dot: 'bg-sky-500', chip: 'bg-sky-50 text-sky-700 border-sky-200', active: 'bg-sky-600 text-white border-sky-600 shadow-sm shadow-sky-600/25', text: 'text-sky-600' },
        ],

        activeCat() {
          return this.cats.find((c) => c.key === this.category) || this.cats[0];
        },
      };
    }
  </script>
@endpush