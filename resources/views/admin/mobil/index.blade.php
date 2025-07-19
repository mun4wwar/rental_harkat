@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Daftar Mobil</h2>

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('mobil.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                + Tambah Mobil
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left tracking-wider">No</th>
                        <th class="px-6 py-3 text-left tracking-wider">Nama
                            Mobil</th>
                        {{-- <th class="px-6 py-3 text-left tracking-wider">Plat
                            Nomor</th> --}}
                        <th class="px-6 py-3 text-left tracking-wider">Merk</th>
                        <th class="px-6 py-3 text-left tracking-wider">Tahun
                        </th>
                        <th class="px-6 py-3 text-left tracking-wider">Harga
                            Sewa</th>
                        <th class="px-6 py-3 text-left tracking-wider">Harga
                            Sewa ALL IN</th>
                        <th class="px-6 py-3 text-left tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($mobils as $index => $mobil)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mobil->nama_mobil }}</td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mobil->plat_nomor }}</td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mobil->merk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mobil->tahun }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Rp. {{ number_format($mobil->harga_sewa, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Rp. {{ number_format($mobil->harga_all_in, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $mobil->status_badge_class }}">
                                    {{ $mobil->status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('mobil.show', $mobil->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('mobil.edit', $mobil->id) }}"
                                        class="text-yellow-600 hover:text-indigo-900 font-medium" title="Edit">
                                        <i data-lucide="pencil" class="w-5 h-5"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('mobil.destroy', $mobil->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus mobil ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-indigo-900 font-medium"
                                            title="Hapus">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
