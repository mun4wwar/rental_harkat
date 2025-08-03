<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Supir - Rental Mobil Harkat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Topbar -->
    <header class="bg-white shadow p-4 flex items-center justify-between sticky top-0 z-50">
        <h1 class="text-xl font-semibold">Dashboard Supir</h1>
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium">Halo, {{ Auth::guard('supir')->user()->nama }}</span>
            <form method="POST" action="{{ route('supir.logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-4">
        @yield('content')
    </main>

    <!-- Optional Footer -->
    <footer class="bg-white text-center p-3 shadow-sm text-sm text-gray-600">
        &copy; {{ date('Y') }} Rental Mobil Harkat Yogyakarta
    </footer>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
