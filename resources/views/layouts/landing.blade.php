{{-- resources/views/layouts/landing.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harkat Rental Yogyakarta</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-b from-white via-gray-100 to-gray-200 text-gray-800 font-sans">

    <!-- Header -->
    <x-layouts.header />

    <!-- Main Content -->
    <main class="flex-1 pt-36 pb-20 px-6 max-w-6xl mx-auto w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <x-layouts.footer />

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
</body>

</html>
