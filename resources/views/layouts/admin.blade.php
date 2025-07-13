<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Rental Mobil Harkat Yogyakarta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 h-full" x-data="{ sidebarOpen: window.innerWidth >= 768 }">
    <!-- Debug Alpine aktif -->
    <div x-init="console.log('Alpine aktif 🎉')"></div>
    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-40 transform transition-transform duration-300 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="p-5 font-bold text-xl border-b flex items-center justify-between">
                <span>Admin Panel</span>
                <!-- Tombol close (visible di mobile) -->
                <button @click="sidebarOpen = false"
                    class="md:hidden text-2xl text-gray-600 hover:text-black focus:outline-none">
                    ✖️
                </button>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin') ? 'bg-gray-200' : '' }}">
                    🏠 Dashboard
                </a>
                <a href="{{ route('mobil.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/mobil') ? 'bg-gray-200' : '' }}">
                    🚗 Manajemen Mobil
                </a>
                <a href="{{ route('supir.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/supir') ? 'bg-gray-200' : '' }}">
                    🧑‍✈️ Manajemen Supir
                </a>
                <a href="{{ route('pelanggan.index') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/pelanggan') ? 'bg-gray-200' : '' }}">
                    👥 Manajemen Pelanggan
                </a>
            </nav>
        </div>

        <!-- Overlay (mobile) -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
            @click="sidebarOpen = false"></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-0'">

            <!-- Topbar -->
            <header class="bg-white shadow p-4 flex items-center justify-between transition-all duration-300">
                <button @click="sidebarOpen = !sidebarOpen"
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
