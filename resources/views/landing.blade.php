{{-- resources/views/landing.blade.php --}}
<!DOCTYPE html>
<html lang="id">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harkat Rent Car</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-800">
    <header class="p-4 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold">Harkat Rent Car</h1>
        <nav>
            <a href="{{ route('login') }}" class="text-green-600 hover:underline">Login Customer</a>
            <a href="{{ route('admin.login') }}" class="ml-4 hover:underline">Login Admin</a>
            <a href="{{ route('supir.login') }}" class="ml-4 hover:underline">Login Supir</a>
        </nav>
    </header>

    <main class="p-8 text-center">
        <h2 class="text-4xl font-semibold mb-4">Sewa Mobil Mudah dan Cepat</h2>
        <p class="text-lg text-gray-600">Nikmati perjalanan dengan aman dan nyaman bersama Harkat Yogyakarta.</p>
        <a href="{{ route('register') }}" class="mt-6 inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">Daftar Sekarang</a>
    </main>
</body>
</html>
