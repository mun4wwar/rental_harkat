<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Supir Panel - Rental Mobil Harkat Yogyakarta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 h-full">
    <div class="flex min-h-screen">
        <!-- Sidebar (Desktop only) -->
        <x-supir.sidebar />

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <x-supir.topbar />

            <main class="flex-1 p-4 md:ml-64">
                @yield('content')
            </main>
        </div>
    </div>
    <x-supir.bottomnav />

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
