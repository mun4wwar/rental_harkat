@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4">Daftar Supir</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('supir.create') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4">+ Tambah Supir</a>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">No HP</th>
                        <th class="px-4 py-3">Alamat</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supirs as $index => $supir)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $supir->nama }}</td>
                            <td class="px-4 py-2">{{ $supir->no_hp }}</td>
                            <td class="px-4 py-2">{{ $supir->alamat }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $supir->status == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $supir->status == 1 ? 'Siap' : 'Sedang Bertugas' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('supir.edit', $supir->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('supir.destroy', $supir->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Yakin hapus supir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($supirs->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data supir.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
