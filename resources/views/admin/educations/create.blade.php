@extends('layouts.admin')

@section('title', 'Tambah Pendidikan')
@section('header-title', 'Tambah Pendidikan')

@push('styles')
  <style>
    @keyframes floatUpE {
      0% { opacity: 0; transform: translateY(22px) scale(.97); }
      100% { opacity: 1; transform: none; }
    }
    .anim-in { animation: floatUpE .55s cubic-bezier(.22, 1, .36, 1) both; }

    @keyframes floatyE {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .animate-floaty { animation: floatyE 3.4s ease-in-out infinite; }

    @keyframes shineE {
      100% { transform: translateX(250%); }
    }
    .shimmer { position: relative; overflow: hidden; }
    .shimmer::after {
      content: '';
      position: absolute;
      inset: 0;
      transform: translateX(-120%);
      background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.5) 50%, transparent 60%);
      animation: shineE 2.6s ease-in-out infinite;
    }

    .csl-field { transition: box-shadow .25s, border-color .25s; }
    .csl-field:focus-within { box-shadow: 0 0 0 4px rgba(16, 185, 129, .1); border-color: #34d399; }
  </style>
@endpush

@section('content')
  <div class="max-w-4xl mx-auto space-y-6" x-cloak x-data='educationForm({
    institution: "{{ old('institution') }}",
    degree: "{{ old('degree') }}",
    startDate: "{{ old('start_date') }}",
    endDate: "{{ old('end_date') }}",
    isCurrent: {{ old('end_date') === '' && old('start_date') !== null ? 'true' : 'false' }},
    sortOrder: "{{ old('sort_order', 0) }}",
  })'>

    {{-- Hero banner --}}
    <div class="anim-in relative bg-gradient-to-r from-emerald-500 via-teal-500 to-sky-500 rounded-2xl p-7 sm:p-8 overflow-hidden shadow-lg shadow-emerald-600/20">
      <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/15 blur-2xl animate-floaty"></div>
      <div class="absolute -left-12 -bottom-12 w-40 h-40 rounded-full bg-sky-300/30 blur-2xl animate-floaty" style="animation-delay:1s"></div>
      <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center text-white animate-floaty" style="animation-delay:.3s">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
        </div>
        <div>
          <h2 class="text-lg font-extrabold text-white">Tambah Riwayat Pendidikan</h2>
          <p class="text-sm text-emerald-50 mt-0.5">Lengkapi data, pratinjau kartu timeline langsung di kanan.</p>
        </div>
        <span class="ml-auto hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 text-white text-xs font-bold backdrop-blur">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span> Live Editor
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">
      {{-- Form --}}
      <form method="POST" action="{{ route('admin.educations.store') }}" x-on:submit="submitting = true" class="xl:col-span-3 space-y-5">
        @csrf

        {{-- Data pendidikan --}}
        <div class="anim-in bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" style="animation-delay:80ms">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-gray-800">Riwayat Pendidikan</h3>
              <p class="text-xs text-gray-400">Institusi, bidang, dan periode studi</p>
            </div>
          </div>

          <div class="p-6 space-y-5">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Institusi <span class="text-red-400">*</span></label>
              <input type="text" name="institution" x-model="institution" required maxlength="120" placeholder="cth. Universitas Indonesia"
                class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-emerald-400 transition-all duration-200">
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="institution.length > 100 ? 'bg-rose-500' : 'bg-emerald-500'" :style="'width:' + Math.min(100, (institution.length / 120) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="institution.length > 100 ? 'text-rose-500' : 'text-gray-400'" x-text="institution.length + '/120'"></span>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bidang / Jurusan <span class="text-red-400">*</span></label>
              <input type="text" name="degree" x-model="degree" required maxlength="120" placeholder="cth. S1 Teknik Informatika"
                class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-teal-400 transition-all duration-200">
              <div class="mt-1.5 flex items-center gap-2">
                <div class="flex-1 h-1 rounded-full bg-gray-100 overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500" :class="degree.length > 100 ? 'bg-rose-500' : 'bg-teal-400'" :style="'width:' + Math.min(100, (degree.length / 120) * 100) + '%'"></div>
                </div>
                <span class="text-[11px] font-medium tabular-nums" :class="degree.length > 100 ? 'text-rose-500' : 'text-gray-400'" x-text="degree.length + '/120'"></span>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Mulai <span class="text-red-400">*</span></label>
                <input type="text" name="start_date" x-model="startDate" required maxlength="30" placeholder="cth: 2021"
                  class="csl-field w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl placeholder:text-gray-300 focus:outline-none focus:border-emerald-400 transition-all duration-200">
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Selesai</label>
                <div class="relative">
                  <input type="text" x-model="endDate" maxlength="30" placeholder="cth: 2025"
                    class="w-full px-3.5 py-2.5 text-sm border rounded-xl placeholder:text-gray-300 focus:outline-none transition-all duration-200"
                    :class="isCurrent ? 'border-emerald-200 bg-emerald-50/50 text-gray-400 cursor-not-allowed' : 'border-gray-200 focus:border-teal-400'"
                    :disabled="isCurrent">
                  <span x-show="isCurrent" x-cloak class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Sekarang
                    </span>
                  </span>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between p-4 rounded-2xl border transition-all duration-300"
                 :class="isCurrent ? 'bg-emerald-50/60 border-emerald-200' : 'bg-gray-50 border-gray-200'">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center transition-colors duration-300" :class="isCurrent ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-400'">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4.5-5.419V15a9 9 0 009 0V6.581l-4.5 2.5z"/></svg>
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-700">Masih berjalan / sedang kuliah</p>
                  <p class="text-xs mt-0.5" :class="isCurrent ? 'text-emerald-600' : 'text-gray-400'"><span x-text="isCurrent ? 'Periode disimpan sebagai "Sekarang".' : 'Matikan jika sudah menyelesaikan studi ini.'"></span></p>
                </div>
              </div>
              <label class="relative inline-flex items-center cursor-pointer shrink-0">
                <input type="checkbox" class="sr-only peer" x-model="isCurrent">
                <div class="w-12 h-7 rounded-full transition-all duration-300 peer-focus:ring-4 peer-focus:ring-emerald-500/20" :class="isCurrent ? 'bg-emerald-500' : 'bg-gray-300'"></div>
                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow transition-transform duration-300" :class="isCurrent ? 'translate-x-5' : ''"></div>
              </label>
            </div>

            <input type="hidden" name="end_date" :value="isCurrent ? 'Sekarang' : endDate">

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan <span class="text-red-400">*</span></label>
              <div class="csl-field flex items-center gap-2 border border-gray-200 rounded-xl px-3.5 py-2.5 focus-within:border-emerald-400 transition-all duration-200">
                <svg class="w-4 h-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <input type="number" name="sort_order" x-model.number="sortOrder" required placeholder="0"
                  class="flex-1 text-sm bg-transparent outline-none placeholder:text-gray-300 min-w-0">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-50 text-gray-400 text-[10px] font-bold shrink-0">Urutan #<b class="text-emerald-600 tabular-nums" x-text="Number(sortOrder) || 0"></b></span>
              </div>
            </div>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="anim-in flex flex-col sm:flex-row gap-3 sm:justify-end" style="animation-delay:160ms">
          <a href="{{ route('admin.educations.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-all duration-200 hover:-translate-y-0.5 active:scale-95">
            Batal
          </a>
          <button type="submit" :disabled="submitting" class="shimmer inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 shadow-sm shadow-emerald-600/25 transition-all duration-200 hover:-translate-y-0.5" :class="submitting ? 'opacity-70 cursor-wait' : ''">
            <template x-if="!submitting">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
            <template x-if="submitting">
              <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            </template>
            <span x-text="submitting ? 'Menyimpan...' : 'Simpan Pendidikan'"></span>
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
            <div class="rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md relative">
              <div class="absolute inset-y-0 left-0 w-1" :class="isCurrent ? 'bg-gradient-to-b from-emerald-400 to-teal-600' : 'bg-gradient-to-b from-sky-400 to-indigo-500'"></div>
              <div class="p-4 flex items-start gap-3">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shrink-0"
                     :class="isCurrent ? 'bg-gradient-to-br from-emerald-400 to-teal-600' : 'bg-gradient-to-br from-sky-400 to-indigo-600'"
                     x-text="(institution.trim() || '?').charAt(0).toUpperCase()"></div>
                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <p class="text-sm font-extrabold text-gray-800 truncate" :class="!institution ? 'opacity-30' : ''" x-text="institution || 'Nama institusi...'"></p>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                      :class="isCurrent ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-sky-50 text-sky-600 border border-sky-200'">
                      <span class="w-1.5 h-1.5 rounded-full" :class="isCurrent ? 'bg-emerald-500 animate-pulse' : 'bg-sky-400'"></span>
                      <span x-text="isCurrent ? 'Berjalan' : 'Selesai'"></span>
                    </span>
                  </div>
                  <p class="text-xs text-gray-500 font-semibold mt-0.5 truncate" :class="!degree ? 'opacity-30' : ''" x-text="degree || 'Bidang / jurusan...'"></p>
                  <div class="mt-2.5 flex items-center gap-2 text-xs font-bold text-gray-500">
                    <svg class="w-3.5 h-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span :class="!startDate ? 'opacity-30' : ''"><span x-text="startDate || 'yyyy'"></span><span x-show="effectivePeriod"> — <span x-text="effectivePeriod"></span></span></span>
                  </div>
                </div>
              </div>
              <div class="px-4 py-2.5 bg-gray-50/60 border-t border-gray-100 flex items-center justify-between text-[11px] font-semibold text-gray-400">
                <span>Urutan #<b class="text-emerald-600 tabular-nums" x-text="Number(sortOrder) || 0"></b></span>
                <template x-if="yearSpan">
                  <span class="inline-flex items-center gap-1">
                    <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-text="yearSpan"></span>
                  </span>
                </template>
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
    function educationForm(initial) {
      return {
        institution: initial.institution || '',
        degree: initial.degree || '',
        startDate: initial.startDate || '',
        endDate: initial.endDate || '',
        isCurrent: !!initial.isCurrent,
        sortOrder: initial.sortOrder ?? 0,
        submitting: false,

        get effectivePeriod() {
          if (this.isCurrent) return 'Sekarang';
          return this.endDate || '';
        },

        get yearSpan() {
          const s = parseInt(this.startDate, 10);
          if (isNaN(s)) return '';
          if (this.isCurrent) return 'Sejak ' + s;
          const e = parseInt(this.endDate, 10);
          if (isNaN(e)) return '';
          const years = e - s;
          if (years <= 0) return '';
          return '±' + years + (years === 1 ? ' tahun' : ' tahun');
        },
      };
    }
  </script>
@endpush