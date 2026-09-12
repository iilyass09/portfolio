@extends('layouts.admin')

@section('title', 'Tambah Proyek')
@section('header-title', 'Tambah Proyek')

@push('styles')
  <style>
    @keyframes floatUpP {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpP .55s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyP {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyP 3.4s ease-in-out infinite; }

    @keyframes shineP {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.5) 50%, transparent 60%);
      animation: shineP 2.6s ease-in-out infinite;
    }

    .field-card { transition: box-shadow .25s, border-color .25s, transform .25s; }
    .field-card:focus-within { box-shadow: 0 0 0 4px rgba(99, 102, 241, .1); border-color: #818cf8; }
  </style>
@endpush

@section('content')
  <div class="max-w-4xl mx-auto space-y-6" x-cloak x-data='projectForm({
    type: "{{ old('type', 'ux') }}",
    sortOrder: "{{ old('sort_order', 0) }}",
    isActive: true,
    title: "{{ old('title') }}",
    subtitle: "{{ old('subtitle') }}",
    description: "{{ old('description') }}",
  })'>

    {{-- Hero banner --}}
    <div class="anim-in relative bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-600 rounded-2xl p-7 sm:p-8 overflow-hidden shadow-lg shadow-indigo-600/20">
      <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10 blur-2xl animate-floaty"></div>
      <div class="absolute -left-12 -bottom-12 w-40 h-40 rounded-full bg-fuchsia-400/20 blur-2xl animate-floaty" style="animation-delay:1s"></div>
      <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center text-white animate-floaty" style="animation-delay:.3s">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z"/></svg>
        </div>
        <div>
          <h2 class="text-lg font-extrabold text-white">Tambah Proyek Baru</h2>
          <p class="text-sm text-indigo-100 mt-0.5">Lengkapi informasi di bawah, pratinjau langsung di panel kanan.</p>
        </div>
        <span class="ml-auto hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 text-white text-xs font-bold backdrop-blur">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Live Editor
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">
      {{-- Form --}}
      <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" x-on:submit="submitting = true" class="xl:col-span-3 space-y-5">
        @csrf

        {{-- Info dasar --}}
        <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:80ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-800">Informasi Dasar</h3>
              <p class="text-xs text-gray-400">Judul, subtitle, deskripsi, dan thumbnail proyek</p>
            </div>
          </div>

          <div class="p-6 space-y-5">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul <span class="text-red-400">*</span></label>
              <input type="text" name="title" x-model="title" required maxlength="120" placeholder="cth. Aplikasi Dashboard Analitik"
                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200" style="border-color:2px solid gray">
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="title.length > 100 ? 'bg-rose-500' : title.length > 60 ? 'bg-amber-400' : 'bg-emerald-500'" :style="'width:' + Math.min(100, (title.length / 120) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="title.length > 100 ? 'text-rose-500' : 'text-gray-400'" x-text="title.length + '/120'"></span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Subtitle <span class="text-red-400">*</span></label>
              <input type="text" name="subtitle" x-model="subtitle" required maxlength="160" placeholder="cth. Analisa penjualan real-time"
                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-violet-400 transition-all duration-200">
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="subtitle.length > 130 ? 'bg-rose-500' : 'bg-violet-400'" :style="'width:' + Math.min(100, (subtitle.length / 160) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="subtitle.length > 130 ? 'text-rose-500' : 'text-gray-400'" x-text="subtitle.length + '/160'"></span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-red-400">*</span></label>
              <textarea name="description" x-model="description" rows="4" required placeholder="Ceritakan tentang proyek ini..." class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200 resize-none"></textarea>
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="description.length > 500 ? 'bg-rose-500' : 'bg-indigo-500'" :style="'width:' + Math.min(100, (description.length / 600) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="description.length > 500 ? 'text-rose-500' : 'text-gray-400'" x-text="description.length + ' karakter'"></span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Thumbnail</label>
              <label for="thumb-input" class="group field-card cursor-pointer relative block rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50/60 hover:border-indigo-300 hover:bg-indigo-50/40 transition-all duration-300 overflow-hidden">
                <input id="thumb-input" type="file" name="thumbnail" accept="image/*" class="sr-only" x-on:change="onThumbChange($event)">
                <template x-if="!thumbnailPreview">
                  <div class="py-8 px-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300 animate-floaty">
                      <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z"/></svg>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-gray-600">Klik untuk unggah thumbnail</p>
                    <p class="mt-1 text-xs text-gray-400">Format JPG/PNG/WebP, disarankan rasio 16:9</p>
                  </div>
                </template>
                <template x-if="thumbnailPreview">
                  <div class="relative aspect-video">
                    <img :src="thumbnailPreview" class="w-full h-full object-cover" alt="Pratinjau thumbnail">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                      <span class="text-xs font-bold text-white bg-black/50 px-3 py-1.5 rounded-lg backdrop-blur">Ganti gambar</span>
                    </div>
                  </div>
                </template>
              </label>
            </div>

            {{-- Tipe + urutan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Proyek <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                  <button type="button" @click="type = 'ux'" class="py-2.5 rounded-xl text-sm font-bold transition-all duration-200 active:scale-95 flex items-center justify-center gap-1.5"
                    :class="type === 'ux' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/25 scale-[1.02]' : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-indigo-300'">
                    <span class="w-2 h-2 rounded-full" :class="type === 'ux' ? 'bg-white' : 'bg-indigo-400'"></span> UI/UX
                  </button>
                  <button type="button" @click="type = 'data_analyst'" class="py-2.5 rounded-xl text-sm font-bold transition-all duration-200 active:scale-95 flex items-center justify-center gap-1.5"
                    :class="type === 'data_analyst' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/25 scale-[1.02]' : 'bg-gray-50 text-gray-500 border border-gray-200 hover:border-emerald-300'">
                    <span class="w-2 h-2 rounded-full" :class="type === 'data_analyst' ? 'bg-white' : 'bg-emerald-400'"></span> Data
                  </button>
                </div>
                <input type="hidden" name="type" :value="type">
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan <span class="text-red-400">*</span></label>
                <input type="number" name="sort_order" x-model.number="sortOrder" required placeholder="0"
                  class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-indigo-400 transition-all duration-200">
              </div>
            </div>

            {{-- Toggle aktif --}}
            <div class="flex items-center justify-between p-4 rounded-2xl border transition-all duration-300"
              :class="isActive ? 'bg-emerald-50/60 border-emerald-200' : 'bg-gray-50 border-gray-200'">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center transition-colors duration-300" :class="isActive ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-400'">
                  <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-700">Tampilkan di website</p>
                  <p class="text-xs mt-0.5" :class="isActive ? 'text-emerald-600' : 'text-gray-400'"><span x-text="isActive ? 'Proyek ini akan tampil di halaman portfolio publik.' : 'Saat ini tersembunyi dari portfolio.'"></span></p>
                </div>
              </div>
              <label class="relative inline-flex items-center cursor-pointer shrink-0">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" x-model="isActive">
                <div class="w-12 h-6.5 h-7 rounded-full transition-all duration-300 peer-focus:ring-4 peer-focus:ring-indigo-500/20" :class="isActive ? 'bg-emerald-500' : 'bg-gray-300'"></div>
                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow transition-transform duration-300" :class="isActive ? 'translate-x-5' : ''"></div>
              </label>
            </div>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="anim-in flex flex-col sm:flex-row gap-3 sm:justify-end" style="animation-delay:160ms">
          <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
            Batal
          </a>
          <button type="submit" :disabled="submitting" class="shimmer inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 shadow-sm shadow-indigo-600/25 transition-all duration-200 hover:-translate-y-0.5" :class="submitting ? 'opacity-70 cursor-wait' : ''">
            <template x-if="!submitting">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
            </template>
            <template x-if="submitting">
              <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            </template>
            <span x-text="submitting ? 'Menyimpan...' : 'Simpan Proyek'"></span>
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
              <p class="text-sm font-bold text-gray-700">Pratinjau Kartu</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live
            </span>
          </div>
          <div class="p-5">
            <div class="rounded-2xl border border-gray-100 shadow-sm overflow-hidden group transition-all duration-300 hover:shadow-md">
              <div class="relative aspect-video bg-gradient-to-br from-indigo-100 to-violet-100">
                <template x-if="thumbnailPreview">
                  <img :src="thumbnailPreview" class="w-full h-full object-cover" alt="">
                </template>
                <div x-show="!thumbnailPreview" class="w-full h-full flex items-center justify-center text-indigo-300" x-cloak>
                  <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25z"/></svg>
                </div>
                <span class="absolute top-3 right-3 inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold text-white shadow" :class="type === 'data_analyst' ? 'bg-emerald-600' : 'bg-indigo-600'">
                  <span x-text="type === 'data_analyst' ? 'Data Analyst' : 'UI/UX'"></span>
                </span>
              </div>
              <div class="p-4">
                <p class="text-sm font-extrabold text-gray-800 truncate" :class="!title ? 'opacity-30' : ''" x-text="title || 'Judul proyek...'"></p>
                <p class="text-xs text-gray-400 font-medium mt-0.5 truncate" :class="!subtitle ? 'opacity-30' : ''" x-text="subtitle || 'Subtitle singkat proyek...'"></p>
                <p class="mt-2.5 text-xs text-gray-500 leading-relaxed line-clamp-2 whitespace-pre-line" :class="!description ? 'opacity-30' : ''" x-text="description || 'Deskripsi singkat akan ditampilkan di sini...'"></p>
              </div>
              <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold" :class="isActive ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-400'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="isActive ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400'"></span>
                  <span x-text="isActive ? 'Aktif' : 'Non-aktif'"></span>
                </span>
                <span class="text-xs font-extrabold text-indigo-500">#<span x-text="('0' + (Number(sortOrder) || 0)).slice(-2)"></span></span>
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
    function projectForm(initial) {
      return {
        title: initial.title || '',
        subtitle: initial.subtitle || '',
        description: initial.description || '',
        type: initial.type || 'ux',
        sortOrder: initial.sortOrder ?? 0,
        isActive: initial.isActive !== false,
        submitting: false,
        thumbnailPreview: null,

        onThumbChange(event) {
          const file = event.target.files && event.target.files[0];
          if (!file) return;
          if (!file.type.startsWith('image/')) return;
          const reader = new FileReader();
          reader.onload = (e) => { this.thumbnailPreview = e.target.result; };
          reader.readAsDataURL(file);
        },
      };
    }
  </script>
@endpush