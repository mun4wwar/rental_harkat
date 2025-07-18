@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-6 px-4">
        <h2 class="text-xl font-bold mb-4">Edit Pelanggan</h2>

        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST"
            class="space-y-6 bg-white p-6 shadow-md rounded">
            @csrf
            @method('PUT')

            {{-- Nama Supir --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" name="nama" id="nama"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('nama', $pelanggan->nama) }}">
                @error('nama')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Pelanggan</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('email', $pelanggan->email) }}">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">No Telp</label>
                <input type="text" name="no_telp" id="no_telp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('no_telp', $pelanggan->no_telp) }}">
                @error('no_telp')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea type="text" name="alamat" id="alamat"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('supir.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
@endsection
