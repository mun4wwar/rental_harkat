<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Rental Mobil Harkat Yogyakarta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 h-full" x-data="{ sidebarOpen: true }"
    :class="{ 'overflow-hidden': sidebarOpen && window.innerWidth < 768 }">
    <!-- Debug Alpine aktif -->
    <div x-init="console.log('Alpine aktif 🎉')"></div>
    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-40 h-full transition-all duration-300 flex flex-col"
            :class="sidebarOpen ? 'w-64' : 'w-16 fixed inset-y-0 left-0'">

            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b">
                <span x-show="sidebarOpen" class="text-xl font-bold">Admin Panel</span>

                <!-- Tombol toggle buka (saat sidebar tertutup) -->
                <button x-show="!sidebarOpen" @click="sidebarOpen = true"
                    class="text-2xl text-gray-600 hover:text-black focus:outline-none">
                    ☰
                </button>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 hover:bg-gray-200 px-3 py-2 rounded transition group {{ request()->is('admin') ? 'bg-gray-200' : '' }}">
                    <span class="text-xl">🏠</span>
                    <span x-show="sidebarOpen" class="text-sm">Dashboard</span>
                </a>

                <!-- Manajemen Mobil -->
                <a href="{{ route('mobil.index') }}"
                    class="flex items-center space-x-3 hover:bg-gray-200 px-3 py-2 rounded transition group {{ request()->is('admin/mobil') ? 'bg-gray-200' : '' }}">
                    <span class="text-xl">🚗</span>
                    <span x-show="sidebarOpen" class="text-sm">Manajemen Mobil</span>
                </a>

                <!-- Manajemen Supir -->
                <a href="{{ route('supir.index') }}"
                    class="flex items-center space-x-3 hover:bg-gray-200 px-3 py-2 rounded transition group {{ request()->is('admin/supir') ? 'bg-gray-200' : '' }}">
                    <span class="text-xl">🧑‍✈️</span>
                    <span x-show="sidebarOpen" class="text-sm">Manajemen Supir</span>
                </a>

                <!-- Manajemen Pelanggan -->
                <a href="{{ route('pelanggan.index') }}"
                    class="flex items-center space-x-3 hover:bg-gray-200 px-3 py-2 rounded transition group {{ request()->is('admin/pelanggan') ? 'bg-gray-200' : '' }}">
                    <span class="text-xl">👥</span>
                    <span x-show="sidebarOpen" class="text-sm">Manajemen Pelanggan</span>
                </a>
            </nav>
        </div>

        <!-- Overlay (mobile) -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
            @click="sidebarOpen = false"></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-16'">


            <!-- Topbar -->
            <header class="bg-white shadow p-4 flex items-center justify-between transition-all duration-300">
                <button @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen"
                    class="text-2xl text-gray-600 hover:text-black focus:outline-none">
                    ☰
                </button>
                <h1 class="text-xl font-semibold">Admin</h1>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-y-auto transition-all duration-300">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
