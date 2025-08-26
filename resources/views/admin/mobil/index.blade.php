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
            <a href="{{ route('admin.mobil.create') }}"
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
                        <th class="px-6 py-3 text-left tracking-wider">Tipe
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
                        @php
                            $isDisabled = $mobil->status_approval != 1;
                            $rowClass =
                                $mobil->status_approval == 0
                                    ? 'bg-red-100 opacity-80 line-through'
                                    : ($mobil->status_approval == 2
                                        ? 'bg-gray-200 opacity-70'
                                        : '');
                        @endphp

                        <tr class="{{ $rowClass }}">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                {{ $loop->iteration }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                {{ $mobil->nama_mobil }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                {{ $mobil->type->nama_tipe ?? '-' }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                {{ $mobil->merk }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                {{ $mobil->tahun }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                Rp. {{ number_format($mobil->harga_sewa, 0, ',', '.') }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $isDisabled ? 'text-gray-500' : 'text-gray-700' }}">
                                Rp. {{ number_format($mobil->harga_all_in, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($mobil->status_approval == 0)
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 font-bold">Data
                                        ditolak admin</span>
                                @elseif($mobil->status_approval == 2)
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Waiting for
                                        approval</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full {{ $mobil->status_badge_class }}">
                                        {{ $mobil->status_text }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.mobil.show', $mobil->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium {{ $isDisabled ? 'pointer-events-none opacity-50' : '' }}"
                                        title="Lihat Detail">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>
                                    <a href="{{ route('admin.mobil.edit', $mobil->id) }}"
                                        class="text-yellow-600 hover:text-indigo-900 font-medium {{ $isDisabled ? 'pointer-events-none opacity-50' : '' }}"
                                        title="Edit">
                                        <i data-lucide="pencil" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
