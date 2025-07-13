@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Supir</h2>

        <form action="{{ route('pelanggan.store') }}" method="POST" class="space-y-6 bg-white p-6 shadow-md rounded">
            @csrf

            {{-- Nama Supir --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" name="nama" id="nama"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="number" name="no_telp" id="no_telp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('no_telp') }}" required>
                @error('no_telp')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="number" name="email" id="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea type="text" name="alamat" id="alamat"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('alamat') }}" required></textarea>
                @error('alamat')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('supir.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
