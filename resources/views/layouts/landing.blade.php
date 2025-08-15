{{-- resources/views/layouts/landing.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harkat Rental Yogyakarta</title>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#ffffff] flex flex-col min-h-screen bg-gradient-to-b from-white via-gray-100 to-gray-200 text-gray-800 font-sans">
    <!-- Loading Screen -->
    <div id="loading-screen"
        class="fixed inset-0 flex flex-col items-center justify-center z-50 bg-gradient-to-b from-green-900 to-green-500 text-white opacity-100 transition-opacity duration-700">
        <img src="/images/logo.png" alt="Harkat Rent Car" class="w-24 h-24 animate-bounce" />
        <p class="mt-4 text-lg font-semibold animate-pulse">Memuat...</p>
    </div>
    <!-- Header -->
    <x-layouts.header />

    <!-- Hero (full width) -->
    @yield('hero')

    <!-- Main Content -->
    <main class="flex-1 pt-15 pb-20 px-4 max-w-6xl mx-auto w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-layouts.footer :types="$types" />

    <!-- JS Dropdown -->
    <script>
        document.getElementById('loginDropdownBtn')?.addEventListener('click', function() {
            const dropdown = document.getElementById('loginDropdown');
            dropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', function(e) {
            const btn = document.getElementById('loginDropdownBtn');
            const dropdown = document.getElementById('loginDropdown');
            if (!btn?.contains(e.target) && !dropdown?.contains(e.target)) {
                dropdown?.classList.add('hidden');
            }
        });
    </script>

    <!-- Loading Screen Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                let loader = document.getElementById('loading-screen');
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                    document.getElementById('content').classList.remove('hidden');
                }, 700);
            }, 1500); // Delay 1.5 detik biar animasinya kebaca
        });
    </script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif
    @stack('scripts') {{-- ini yang penting buat munculin script dari @push --}}
</body>

</html>
