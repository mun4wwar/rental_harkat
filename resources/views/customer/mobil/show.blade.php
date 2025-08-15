{{-- resources/views/customer/mobil/show.blade.php --}}
@extends('layouts.landing')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">
        <img src="{{ Storage::url($mobil->gambar) }}" class="w-full h-64 object-contain mb-4">
        <h2 class="text-2xl font-bold mb-2">{{ $mobil->nama_mobil }}</h2>
        <p class="text-gray-700 mb-2">Harga Sewa: Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }} / hari</p>
        <p class="text-gray-600 mb-4">Deskripsi mobil bisa ditambahkan di sini (kalau ada).</p>

        <a href="{{ route('booking.create', ['mobil_id' => $mobil->id]) }}"
            class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Booking Sekarang
        </a>
    </div>
@endsection
