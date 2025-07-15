@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-6 px-4">
        <h2 class="text-xl font-bold mb-4">Edit Supir</h2>

        <form action="{{ route('supir.update', $supir->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 shadow-md rounded">
            @csrf
            @method('PUT')

            {{-- Nama Supir --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Supir</label>
                <input type="text" name="nama" id="nama"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('nama', $supir->nama) }}" required>
            </div>

            {{-- No HP --}}
            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="number" name="no_hp" id="no_hp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('no_hp', $supir->no_hp) }}" required>
            </div>

            {{-- Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea type="text" name="alamat" id="alamat"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('alamat', $supir->alamat) }}" required></textarea>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="1" {{ $supir->status == 1 ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ $supir->status == 0 ? 'selected' : '' }}>Bertugas</option>
                </select>
            </div>

            {{-- Gambar Supir --}}
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700">Foto Supir</label>
                <input type="file" name="gambar" id="gambar"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    value="{{ old('gambar') }}" required>
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
