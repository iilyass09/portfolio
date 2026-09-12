<aside class="w-64 text-white flex flex-col fixed inset-y-0 left-0 z-40 overflow-hidden"
  style="background: linear-gradient(165deg, #01203C 0%, #041634 42%, #241b52 78%, #4C1D95 100%);">
  <div class="absolute -top-24 -right-16 w-52 h-52 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-24 -left-16 w-52 h-52 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

  <div class="relative px-6 py-6 border-b border-white/10">
    <a href="{{ route('home') }}" class="text-lg font-extrabold tracking-tight hover:text-purple-200 transition-colors duration-200">MUHAMMAD ILYAS</a>
    <p class="text-xs text-white/40 mt-1">Admin Panel</p>
  </div>

  <nav class="relative flex-1 px-4 py-6 space-y-1.5">
    <a href="{{ route('admin.dashboard') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>
      Dashboard
    </a>
    <a href="{{ route('admin.settings.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.settings.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Pengaturan
    </a>
    <a href="{{ route('admin.projects.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.projects.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.projects.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Proyek & Studi Kasus
    </a>
    <a href="{{ route('admin.casestudies.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.casestudies.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.casestudies.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Konten Case Study
    </a>
    <a href="{{ route('admin.skills.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.skills.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.skills.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Keahlian
    </a>
    <a href="{{ route('admin.educations.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.educations.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.educations.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Pendidikan
    </a>
    <a href="{{ route('admin.experiences.index') }}" class="block relative px-4 py-2.5 rounded-xl text-sm font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.experiences.*') ? 'bg-white/15 text-white shadow-lg shadow-purple-900/30' : 'text-white/60 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
      <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-1 rounded-r-full bg-purple-400 transition-opacity duration-200 {{ request()->routeIs('admin.experiences.*') ? 'opacity-100' : 'opacity-0' }}"></span>
      Pengalaman Kerja
    </a>
  </nav>

  <div class="relative px-6 py-4 border-t border-white/10">
    <a href="{{ route('home') }}" class="text-xs text-white/40 hover:text-purple-200 transition-colors duration-200">← Lihat website</a>
  </div>
</aside>