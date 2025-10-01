@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 pt-20">
        <h2 class="text-3xl font-bold mb-6 text-center">Detail Mobil</h2>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            {{-- Gambar --}}
            <div class="md:flex">
                <div class="md:w-1/2 p-4">
                    {{-- Cover Image --}}
                    @if ($mobil->gambar)
                        <img src="{{ Storage::url($mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}"
                            class="w-full h-64 object-cover rounded mb-4 shadow">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded mb-4">
                            <span class="text-gray-500">Cover image tidak tersedia</span>
                        </div>
                    @endif

                    {{-- Galeri Additional Images --}}
                    @if ($mobil->images->count())
                        <h3 class="text-lg font-semibold mb-2">Galeri Tambahan</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($mobil->images as $img)
                                <img src="{{ Storage::url($img->image_path) }}" alt="Additional Image"
                                    class="w-24 h-16 object-cover rounded shadow-sm">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Detail Info --}}
                <div class="md:w-1/2 p-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <p><span class="font-semibold">Nama Mobil:</span> {{ $mobil->nama_mobil }}</p>
                        {{-- <p><span class="font-semibold">Plat Nomor:</span> {{ $mobil->plat_nomor }}</p> --}}
                        <p><span class="font-semibold">Merk:</span> {{ $mobil->merk }}</p>
                        <p><span class="font-semibold">Tahun:</span> {{ $mobil->tahun }}</p>
                        <p><span class="font-semibold">Harga Sewa:</span> Rp
                            {{ number_format($mobil->harga_sewa, 0, ',', '.') }}</p>
                        <p><span class="font-semibold">Harga Sewa ALL IN:</span> Rp
                            {{ number_format($mobil->harga_all_in, 0, ',', '.') }}</p>
                        <p>
                            <span class="font-semibold">Status:</span>
                            @if ($mobil->status == 1)
                                <span
                                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Tersedia</span>
                            @elseif ($mobil->status == 0)
                                <span
                                    class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Rusak</span>
                            @elseif ($mobil->status == 2)
                                <span
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Telah
                                    Dibooking</span>
                            @elseif ($mobil->status == 3)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Telah
                                    Disewa</span>
                            @elseif ($mobil->status == 4)
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">Sedang
                                    Diservis</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">Tidak
                                    diketahui</span>
                            @endif
                        </p>
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="mt-6 text-center md:text-left">
                        <a href="{{ route('admin.mobil.index') }}"
                            class="inline-block bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                            ← Kembali ke Daftar Mobil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
