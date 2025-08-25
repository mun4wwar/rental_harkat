@extends('layouts.landing')

@section('content')
    <div class="max-w-xl mx-auto px-4 pt-20">
        <h1 class="text-2xl font-bold mb-6">💳 Bayar DP Booking</h1>

        <div class="mb-6">
            <p class="text-gray-700 mb-2">Scan QRIS berikut untuk bayar DP:</p>
            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS Harkat" class="w-64 mx-auto border rounded-lg shadow">
        </div>

        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <p><span class="font-semibold">Uang Muka:</span> {{ $booking->uang_muka_rp }}</p>
            <p><span class="font-semibold">Jatuh Tempo:</span> {{ $pembayaran->jatuh_tempo ?? '-' }}</p>
        </div>

        @if ($pembayaran->status_pembayaran == 0)
            {{-- Form Upload Bukti --}}
            <form action="{{ route('pembayaran.upload', $booking->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium text-gray-700">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_bayar" class="mt-2 block w-full border rounded p-2">
                    @error('bukti_bayar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
                    Upload & Konfirmasi
                </button>
            </form>
        @elseif($pembayaran->status_pembayaran == 2)
            <p class="text-yellow-600 font-semibold">⚠️ Bukti bayar sudah dikirim, tunggu verifikasi admin.</p>
        @elseif($pembayaran->status_pembayaran == 1)
            <p class="text-green-600 font-semibold">✅ Pembayaran sudah diverifikasi.</p>
        @endif
    </div>
@endsection
