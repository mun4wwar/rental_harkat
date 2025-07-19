@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">Daftar Pelanggan</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pelanggan.create') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4">+ Tambah Pelanggan</a>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">No HP</th>
                        <th class="px-4 py-3">Alamat</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggans as $index => $pelanggan)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $pelanggan->nama }}</td>
                            <td class="px-4 py-2">{{ $pelanggan->no_telp }}</td>
                            <td class="px-4 py-2">{{ $pelanggan->alamat }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                                {{-- Hapus --}}
                                <x-delete-button :id="$pelanggan->id" :route="route('pelanggan.destroy', $pelanggan->id)" :item="$pelanggan->nama" />
                            </td>
                        </tr>
                    @endforeach

                    @if ($pelanggans->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data Pelanggan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
