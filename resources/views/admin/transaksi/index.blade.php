@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">Daftar Transaksi</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.transaksi.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                + Tambah Transaksi
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Pelanggan</th>
                    <th class="border px-4 py-2">Mobil</th>
                    <th class="border px-4 py-2">Supir</th>
                    <th class="border px-4 py-2">Asal Kota</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Total Harga</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td class="border px-4 py-2">{{ $transaksi->user->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $transaksi->mobil->nama_mobil ?? '-' }}</td>
                        <td class="border px-4 py-2"><x-pakai-supir-label :pakaiSupir="$transaksi->pakai_supir" :supir="$transaksi->supir" />
                        </td>
                        <td class="border px-4 py-2">{{ $transaksi->asal_kota_label }}</td>
                        <td class="border px-4 py-2">
                            {{ $transaksi->tanggal_mulai_format }} s/d {{ $transaksi->tanggal_selesai_format }}
                        </td>
                        <td class="border px-4 py-2">{{ $transaksi->total_harga_rp }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($transaksi->status_label) }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}"
                                class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
