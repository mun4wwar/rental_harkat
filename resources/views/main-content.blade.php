{{-- resources/views/landing.blade.php --}}
@extends('layouts.landing')

@section('hero')
    {{-- HERO: full width background image + fade bottom --}}
    <section class="relative w-full h-[80vh] bg-cover bg-center"
        style="background-image: url('{{ asset('images/hero.jpg') }}');">

        {{-- overlay putih semi transparan biar teks kebaca --}}
        <div class="absolute inset-0 bg-white/40"></div>

        {{-- fade transparan di bawah --}}
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>

        {{-- text content --}}
        <div class="relative z-10 flex items-center justify-center h-full text-center px-4">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4 drop-shadow-lg">Harkat Rent Car</h1>
                <p class="text-lg md:text-xl text-gray-700 mb-8">
                    Nikmati perjalanan yang aman, nyaman, dan terjangkau bersama Harkat Yogyakarta.
                    Booking online kapan pun kamu butuh mobil!
                </p>

                @if (Auth::check() && Auth::user()->role == 3)
                    <a href="{{ route('booking.create') }}"
                        class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition">
                        Booking Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition">
                        Booking Sekarang
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
    <!-- Section Info + Jam Operasional -->
    <section class="py-16">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-10">

            <!-- Kiri: Deskripsi + Button -->
            <div class="flex-1">
                <p class="uppercase tracking-wide text-sm text-gray-500 font-semibold">
                    Harkat Rental – Solusi Transportasi Andal!
                </p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">
                    Cari kendaraan nyaman untuk perjalanan Anda?
                </h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    <span class="font-bold">Harkat Rental</span> siap memenuhi kebutuhan transportasi Anda!
                    Kami menyediakan berbagai pilihan mobil dengan kondisi prima, harga terjangkau,
                    dan layanan profesional, baik untuk penggunaan harian, perjalanan bisnis,
                    maupun liburan keluarga.
                </p>
                <a href="#kontak"
                    class="inline-block mt-6 px-5 py-2 border border-green-700 text-green-500 rounded-full hover:bg-green-700 hover:text-white transition">
                    Hubungi Kami!
                </a>
            </div>

            <!-- Kanan: Jam Operasional -->
            <div class="flex-1 max-w-sm w-full">
                <div class="flex-1" data-aos="fade-left"> <img src="{{ asset('images/carFinance.gif') }}"
                        alt="Ilustrasi Mobil" class="w-full max-w-md mx-auto drop-shadow-lg" loading="lazy"> </div>
            </div>

        </div>
    </section>
    {{-- PILIHAN ARMADA --}}
    <section class="py-16">
        <div class="container mx-auto text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold">Pilihan Armada</h2>
        </div>
        <x-layouts.showcase :mobils="$mobils" />
    </section>
@endsection
