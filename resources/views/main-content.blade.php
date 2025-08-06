{{-- resources/views/landing.blade.php --}}
@extends('layouts.landing')

@section('content')
    {{-- Hero Section --}}
    <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10">
        <div class="flex-1" data-aos="fade-right">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Sewa Mobil Mudah &amp; Cepat 🚘
            </h2>
            <p class="text-lg text-gray-600 max-w-xl mb-8">
                Nikmati perjalanan yang aman, nyaman, dan terjangkau bersama Harkat Yogyakarta. Booking online kapan pun kamu butuh mobil!
            </p>
            @if (Auth::check() && Auth::user()->role == 2)
                <a href="{{ route('booking') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition duration-200">
                    Booking Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition duration-200">
                    Booking Sekarang
                </a>
            @endif
        </div>
        <div class="flex-1" data-aos="fade-left">
            <img src="{{ asset('images/car-illustrator.svg') }}" alt="Ilustrasi Mobil" class="w-full max-w-md mx-auto drop-shadow-lg" loading="lazy">
        </div>
    </div>

    {{-- Showcase --}}
    <x-layouts.showcase :mobils="$mobils" />
@endsection
