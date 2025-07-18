@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Detail Mobil</h2>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Gambar Mobil -->
            <div class="flex-shrink-0">
                @if ($mobil->gambar)
                    <img src="{{ Storage::url($mobil->gambar) }}" alt="Gambar Mobil"
                        class="w-64 h-40 object-cover rounded shadow">
                @else
                    <div class="w-64 h-40 bg-gray-200 flex items-center justify-center rounded">
                        <span class="text-gray-500">Gambar tidak tersedia</span>
                    </div>
                @endif
            </div>

            <!-- Detail Data -->
            <div class="flex-1 space-y-2">
                <p><strong>Nama Mobil:</strong> {{ $mobil->nama_mobil }}</p>
                {{-- <p><strong>Plat Nomor:</strong> {{ $mobil->plat_nomor }}</p> --}}
                <p><strong>Merk:</strong> {{ $mobil->merk }}</p>
                <p><strong>Tahun:</strong> {{ $mobil->tahun }}</p>
                <p><strong>Harga Sewa:</strong> Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}</p>
                <p><strong>Harga Sewa ALL IN:</strong> Rp {{ number_format($mobil->harga_all_in, 0, ',', '.') }}</p>
                <p><strong>Status:</strong>
                    @if ($mobil->status == 1)
                        <span class="text-green-600 font-semibold">Tersedia</span>
                    @else
                        <span class="text-red-600 font-semibold">Disewa</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 text-center">
            <a href="{{ route('mobil.index') }}"
                class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                ← Kembali ke Daftar Mobil
            </a>
        </div>
    </div>
@endsection
