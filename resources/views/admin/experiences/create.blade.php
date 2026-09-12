@extends('layouts.admin')

@section('title', 'Tambah Pengalaman')
@section('header-title', 'Tambah Pengalaman Kerja')

@push('styles')
  <style>
    @keyframes floatUpForm {
      0% { opacity: 0; transform: translateY(20px) scale(.98); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpForm .5s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes shine {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, .5) 50%, transparent 60%);
      animation: shine 2.4s ease-in-out infinite;
    }

    @keyframes popIn {
      0% { opacity: 0; transform: scale(.5); }
      60% { transform: scale(1.12); }
      100% { opacity: 1; transform: scale(1); }
    }
    .anim-pop { animation: popIn .4s cubic-bezier(.22, 1, .36, 1) both; }
  </style>
@endpush

@section('content')
  <div class="max-w-3xl" x-cloak x-data='experienceForm({
    jobType: @js(old('job_type', '')),
    description: @js((string) old('description')),
    company: @js((string) old('company', '')),
    location: @js((string) old('location', '')),
  })'>

    <div class="flex items-center gap-3 mb-6 anim-in">
      <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center animate-pulse">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
      </div>
      <div>
        <p class="text-lg font-bold text-gray-800">Tambahkan Pengalaman Baru</p>
        <p class="text-xs text-gray-400">Lengkapi detail pengalaman kerja untuk ditampilkan di portfolio.</p>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.experiences.store') }}" class="space-y-6" @submit="submitting = true">
      @csrf

      {{-- Card: Posisi & Perusahaan --}}
      <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5" style="animation-delay:80ms">
        <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
          <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
          </span>
          Posisi & Perusahaan
        </div>

        <div class="relative">
          <input type="text" name="title" value="{{ old('title') }}" placeholder=" " required
            class="peer w-full rounded-xl border border-gray-300 bg-white px-4 pt-6 pb-2 text-sm text-gray-800 outline-none transition-all duration-200 placeholder-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
          <label class="pointer-events-none absolute left-4 top-[0.8rem] text-xs font-semibold text-indigo-600 transition-all duration-200 peer-placeholder-shown:top-[0.9rem] peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:text-gray-400 peer-focus:top-[0.8rem] peer-focus:text-xs peer-focus:font-semibold peer-focus:text-indigo-600">Judul / Posisi <span class="text-red-500">*</span></label>
        </div>
        @error('title')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="relative">
            <input type="text" name="company" value="{{ old('company') }}" placeholder=" " x-model="company"
              class="peer w-full rounded-xl border border-gray-300 bg-white px-4 pt-6 pb-2 text-sm text-gray-800 outline-none transition-all duration-200 placeholder-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
            <label class="pointer-events-none absolute left-4 top-[0.8rem] text-xs font-semibold text-indigo-600 transition-all duration-200 peer-placeholder-shown:top-[0.9rem] peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:text-gray-400 peer-focus:top-[0.8rem] peer-focus:text-xs peer-focus:font-semibold peer-focus:text-indigo-600">Perusahaan</label>
          </div>

          <div class="relative">
            <input type="text" name="location" value="{{ old('location') }}" placeholder=" " x-model="location"
              class="peer w-full rounded-xl border border-gray-300 bg-white px-4 pt-6 pb-2 text-sm text-gray-800 outline-none transition-all duration-200 placeholder-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
            <label class="pointer-events-none absolute left-4 top-[0.8rem] text-xs font-semibold text-indigo-600 transition-all duration-200 peer-placeholder-shown:top-[0.9rem] peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:text-gray-400 peer-focus:top-[0.8rem] peer-focus:text-xs peer-focus:font-semibold peer-focus:text-indigo-600">Lokasi</label>
          </div>
        </div>
        @error('company')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
        @error('location')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">Tipe Pekerjaan</label>
          <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
            <template x-for="(item, key) in jobTypes" :key="key">
              <button type="button" @click="jobType = key"
                class="flex items-center justify-center gap-1.5 rounded-xl border-2 px-3 py-2.5 text-xs font-semibold transition-all duration-200 active:scale-95"
                :class="jobType === key
                  ? 'border-indigo-600 bg-indigo-50 text-indigo-700 shadow-sm scale-[1.03]'
                  : 'border-gray-200 bg-white text-gray-500 hover:border-indigo-300 hover:bg-indigo-50/40 hover:text-indigo-600'">
                <span class="w-1.5 h-1.5 rounded-full" :class="item.dot"></span>
                <span x-text="item.label"></span>
              </button>
            </template>
          </div>
          <input type="hidden" name="job_type" :value="jobType">
          <p class="mt-2 text-xs text-gray-400" x-show="!jobType" x-transition>Pilih salah satu tipe, atau biarkan kosong.</p>
        </div>
        @error('job_type')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Card: Periode & Urutan --}}
      <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5" style="animation-delay:160ms">
        <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
          <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
          </span>
          Periode & Urutan
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="relative">
            <input type="text" name="period" value="{{ old('period') }}" placeholder=" " required
              class="peer w-full rounded-xl border border-gray-300 bg-white px-4 pt-6 pb-2 text-sm text-gray-800 outline-none transition-all duration-200 placeholder-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
            <label class="pointer-events-none absolute left-4 top-[0.8rem] text-xs font-semibold text-indigo-600 transition-all duration-200 peer-placeholder-shown:top-[0.9rem] peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:text-gray-400 peer-focus:top-[0.8rem] peer-focus:text-xs peer-focus:font-semibold peer-focus:text-indigo-600">Periode <span class="text-red-500">*</span></label>
          </div>

          <div class="relative">
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" placeholder=" " required
              class="peer w-full rounded-xl border border-gray-300 bg-white px-4 pt-6 pb-2 text-sm text-gray-800 outline-none transition-all duration-200 placeholder-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
            <label class="pointer-events-none absolute left-4 top-[0.8rem] text-xs font-semibold text-indigo-600 transition-all duration-200 peer-placeholder-shown:top-[0.9rem] peer-placeholder-shown:text-sm peer-placeholder-shown:font-medium peer-placeholder-shown:text-gray-400 peer-focus:top-[0.8rem] peer-focus:text-xs peer-focus:font-semibold peer-focus:text-indigo-600">Urutan</label>
          </div>
        </div>
        @error('period')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
        @error('sort_order')
          <p class="anim-pop -mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror

        <div class="flex items-start gap-2 text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-xl px-3 py-2.5">
          <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
          <p>Urutan terendah (0, 1, 2, ...) tampil paling atas di halaman portfolio. Periode ditulis bebas, cth: <span class="font-semibold text-gray-500">2024 - 2025</span></p>
        </div>
      </div>

      {{-- Card: Deskripsi --}}
      <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3" style="animation-delay:240ms">
        <div class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
            <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
            </span>
            Deskripsi <span class="text-red-500">*</span>
          </div>
          <span class="inline-flex items-center gap-1 text-xs font-semibold rounded-full px-2.5 py-1 transition-colors duration-200"
            :class="description.length > 1500 ? 'text-amber-700 bg-amber-50' : 'text-gray-400 bg-gray-50'"
            x-text="description.length + ' karakter'"></span>
        </div>
        <textarea name="description" rows="7" required x-model="description"
          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15"></textarea>
        @error('description')
          <p class="anim-pop text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-300"
               :style="'width:' + Math.min(100, description.length / 20) + '%'"></div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="anim-in flex items-center justify-end gap-3 pt-2" style="animation-delay:320ms">
        <a href="{{ route('admin.experiences.index') }}"
          class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
          Batal
        </a>
        <button type="submit" :disabled="submitting"
          class="shimmer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm shadow-indigo-600/25 transition-all duration-200 hover:-translate-y-0.5 active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed">
          <svg x-show="!submitting" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-6.219-8.56"/></svg>
          <span x-text="submitting ? 'Menyimpan...' : 'Simpan Pengalaman'"></span>
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    function experienceForm(initial) {
      return {
        jobType: initial.jobType || '',
        description: initial.description || '',
        company: initial.company || '',
        location: initial.location || '',
        submitting: false,

        jobTypes: {
          full_time: { label: 'Full-time', dot: 'bg-indigo-500' },
          part_time: { label: 'Part-time', dot: 'bg-sky-500' },
          freelance: { label: 'Freelance', dot: 'bg-emerald-500' },
          internship: { label: 'Internship', dot: 'bg-amber-500' },
          contract: { label: 'Kontrak', dot: 'bg-violet-500' },
        },
      };
    }
  </script>
@endpush