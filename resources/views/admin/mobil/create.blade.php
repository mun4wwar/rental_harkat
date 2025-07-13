@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Mobil</h2>

        <form action="{{ route('mobil.store') }}" method="POST" class="space-y-6 bg-white p-6 shadow-md rounded">
            @csrf

            {{-- Nama Mobil --}}
            <div>
                <label for="nama_mobil" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                <input type="text" name="nama_mobil" id="nama_mobil"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('nama_mobil') }}" required>
            </div>

            {{-- Plat Nomor --}}
            <div>
                <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                <input type="text" name="plat_nomor" id="plat_nomor"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('plat_nomor') }}" required>
            </div>

            {{-- Merk --}}
            <div>
                <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                <input type="text" name="merk" id="merk"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('merk') }}" required>
            </div>

            {{-- Tahun --}}
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('tahun') }}" required>
            </div>

            {{-- Harga Sewa --}}
            <div>
                <label for="harga_sewa" class="block text-sm font-medium text-gray-700">Harga Sewa</label>
                <input type="number" name="harga_sewa" id="harga_sewa"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('harga_sewa') }}" required>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>--Status--</option>
                    <option value="1">Tersedia</option>
                    <option value="0">Disewa</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('mobil.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
