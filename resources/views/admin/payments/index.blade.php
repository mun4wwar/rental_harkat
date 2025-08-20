@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">Daftar Pembayaran Customer</h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Booking ID</th>
                    <th class="border px-4 py-2">Pelanggan</th>
                    <th class="border px-4 py-2">Tanggal Booking</th>
                    <th class="border px-4 py-2">Tanggal Mulai Sewa</th>
                    <th class="border px-4 py-2">Jatuh Tempo</th>
                    <th class="border px-4 py-2">Jenis</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">
                            #{{ $payment->booking->id }} <br>
                            <small>{{ $payment->booking_id }}
                                ({{ $payment->booking->user_id }} -
                                {{ $payment->booking->tanggal_booking }})
                            </small>
                        </td>
                        <td class="border px-4 py-2">{{ $payment->booking->user->name }}</td>
                        <td class="border px-4 py-2">{{ $payment->booking->tanggal_booking }}</td>
                        <td class="border px-4 py-2">{{ $payment->booking->details->tanggal_sewa }}</td>
                        <td class="border px-4 py-2">{{ $payment->jatuh_tempo }}</td>
                        <td class="border px-4 py-2 font-semibold">
                            {{ strtoupper($payment->jenis) }}
                        </td>
                        <td class="border px-4 py-2">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">
                            {{ $payment->status_pembayaran }}
                        </td>
                        <td class="border px-4 py-2 space-x-2">
                            <span class="text-gray-400">-</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="border px-4 py-4 text-center text-gray-500">
                            Belum ada pembayaran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
