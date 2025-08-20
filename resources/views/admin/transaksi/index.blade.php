@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">Daftar Booking</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.booking.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                + Tambah Booking
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Pelanggan</th>
                    <th class="border px-4 py-2">Asal Kota</th>
                    <th class="border px-4 py-2">Jumlah Mobil</th>
                    <th class="border px-4 py-2">Jaminan</th>
                    <th class="border px-4 py-2">Uang Muka</th>
                    <th class="border px-4 py-2">Total Harga</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="bg-white hover:bg-gray-50 cursor-pointer"
                        onclick="document.getElementById('detail-{{ $booking->id }}').classList.toggle('hidden')">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $booking->user->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $booking->asal_kota_label }}</td>
                        <td class="border px-4 py-2">{{ $booking->details->count() }}</td>
                        <td class="border px-4 py-2">{{ $booking->jaminan_label }}</td>
                        <td class="border px-4 py-2">{{ $booking->uang_muka_rp }}</td>
                        <td class="border px-4 py-2">{{ $booking->total_harga_rp }}</td>
                        <td class="border px-4 py-2">{!! $booking->status_badge !!}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                class="text-yellow-600 hover:underline">Edit</a>
                        </td>
                    </tr>

                    {{-- Row buat detail --}}
                    <tr id="detail-{{ $booking->id }}" class="hidden">
                        <td colspan="6" class="border px-4 py-2 bg-gray-50">
                            <table class="w-full border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border px-2 py-1">Mobil</th>
                                        <th class="border px-2 py-1">Supir</th>
                                        <th class="border px-2 py-1">Tanggal</th>
                                        <th class="border px-2 py-1">Status Mobil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->details as $detail)
                                        <tr>
                                            <td class="border px-2 py-1">{{ $detail->mobil->nama_mobil ?? '-' }}</td>
                                            <td class="border px-2 py-1">
                                                <x-pakai-supir-label :pakaiSupir="$detail->pakai_supir" :supir="$detail->supir"
                                                    :detail="$detail" />
                                            </td>
                                            <td class="border px-2 py-1">
                                                {{ $detail->tanggal_mulai_format }} s/d
                                                {{ $detail->tanggal_selesai_format }}
                                            </td>
                                            <td class="border px-2 py-1">
                                                {{ $detail->status_label }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
