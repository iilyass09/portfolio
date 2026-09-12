<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Admin Panel</h1>
        <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola konten website</p>
      </div>

      @if (session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
      @endif

      @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required autofocus
            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
          <input type="password" name="password" required
            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
          </div>
          <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Kembali ke website</a>
        </div>
        <button type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition">
          Masuk
        </button>
      </form>

      <div class="mt-6 p-4 bg-gray-50 rounded-lg text-xs text-gray-500">
        <p class="font-semibold mb-1">Akun default admin:</p>
        <p>Email: <code class="bg-gray-200 px-1 rounded">admin@portfolio.local</code></p>
        <p>Password: <code class="bg-gray-200 px-1 rounded">password</code></p>
      </div>
    </div>
  </div>
</body>
</html>