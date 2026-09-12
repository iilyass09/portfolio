@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')

@section('content')
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('admin.projects.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition">
      <div class="text-3xl mb-3">📁</div>
      <div class="text-4xl font-extrabold text-gray-800">{{ $stats['projects'] }}</div>
      <div class="text-sm text-gray-500 mt-1">Proyek / Studi Kasus</div>
    </a>
    <a href="{{ route('admin.skills.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition">
      <div class="text-3xl mb-3">💡</div>
      <div class="text-4xl font-extrabold text-gray-800">{{ $stats['skills'] }}</div>
      <div class="text-sm text-gray-500 mt-1">Keahlian</div>
    </a>
    <a href="{{ route('admin.educations.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition">
      <div class="text-3xl mb-3">🎓</div>
      <div class="text-4xl font-extrabold text-gray-800">{{ $stats['educations'] }}</div>
      <div class="text-sm text-gray-500 mt-1">Pendidikan</div>
    </a>
    <a href="{{ route('admin.experiences.index') }}" class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition">
      <div class="text-3xl mb-3">💼</div>
      <div class="text-4xl font-extrabold text-gray-800">{{ $stats['experiences'] }}</div>
      <div class="text-sm text-gray-500 mt-1">Pengalaman Kerja</div>
    </a>
  </div>

  <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Mulai Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('admin.settings.index') }}" class="border border-gray-200 rounded-lg p-4 hover:border-indigo-400 transition">
        <div class="text-sm font-semibold">⚙️ Edit Pengaturan Situs</div>
        <p class="text-xs text-gray-500 mt-1">Ubah teks hero, resume, tautan LinkedIn, foto profil & lainnya.</p>
      </a>
      <a href="{{ route('admin.projects.index') }}" class="border border-gray-200 rounded-lg p-4 hover:border-indigo-400 transition">
        <div class="text-sm font-semibold">📁 Kelola Proyek</div>
        <p class="text-xs text-gray-500 mt-1">Tambah / edit kartu proyek di halaman utama.</p>
      </a>
    </div>
  </div>
@endsection