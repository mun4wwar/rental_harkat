@extends('layouts.landing')

@section('content')
    <div class="max-w-3xl mx-auto px-4 pt-20">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📅 Form Booking Mobil</h1>
        @if ($errors->any())
            <div class="text-red-500 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf

            {{-- Pilih Mobil --}}
            <div class="mb-4">
                <label for="mobil_id" class="block text-gray-700 font-semibold mb-1">🚗 Pilih Mobil</label>
                <select name="mobil_id" id="mobil_id" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option disabled selected>-- Pilih Mobil --</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}">{{ $mobil->merk }} - {{ $mobil->nama_mobil }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Checkbox Pakai Supir --}}
            <div class="mb-4 flex items-center">
                <input type="hidden" name="pakai_supir" value="0">
                <input type="checkbox" name="pakai_supir" id="pakai_supir" value="1" class="mr-2" onchange="toggleSupir()">
                <label for="pakai_supir" class="text-gray-700 font-semibold">🧑‍✈️ Pakai Supir</label>
            </div>

            {{-- Tanggal Sewa --}}
            <div class="mb-4">
                <label for="tanggal_sewa" class="block text-gray-700 font-semibold mb-1">📆 Tanggal Sewa</label>
                <input type="date" name="tanggal_sewa" id="tanggal_sewa" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            {{-- Tanggal Kembali --}}
            <div class="mb-4">
                <label for="tanggal_kembali" class="block text-gray-700 font-semibold mb-1">📆 Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            {{-- Lama Sewa --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">⏳ Lama Sewa (hari)</label>
                <input type="text" name="lama_sewa" id="lama_sewa"
                    class="w-full bg-gray-100 px-4 py-2 rounded border border-gray-300" readonly>
            </div>

            {{-- Total Harga --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">💰 Total Harga</label>
                <input type="text" name="total_harga" id="total_harga"
                    class="w-full bg-gray-100 px-4 py-2 rounded border border-gray-300" readonly>
            </div>

            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-md shadow-md transition duration-200">
                🚀 Booking Sekarang
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const tanggalSewa = document.getElementById('tanggal_sewa');
        const tanggalKembali = document.getElementById('tanggal_kembali');
        const lamaSewa = document.getElementById('lama_sewa');
        const totalHarga = document.getElementById('total_harga');
        const mobilSelect = document.getElementById('mobil_id');
        const pakaiSupir = document.getElementById('pakai_supir');

        function toggleSupir() {
            document.getElementById('supirField').classList.toggle('hidden', !pakaiSupir.checked);
        }

        function hitungLamaDanHarga() {
            const tglAwal = new Date(tanggalSewa.value);
            const tglAkhir = new Date(tanggalKembali.value);

            if (tanggalSewa.value && tanggalKembali.value && tglAkhir >= tglAwal) {
                const hari = Math.ceil((tglAkhir - tglAwal) / (1000 * 60 * 60 * 24)) + 1;
                lamaSewa.value = hari;

                // Dummy harga - bisa diganti pakai JS fetch harga mobil
                const hargaMobil = 300000; // misal 300rb per hari
                const hargaSupir = 100000; // misal 100rb per hari
                let total = hargaMobil * hari;
                if (pakaiSupir.checked) total += hargaSupir * hari;
                totalHarga.value = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                lamaSewa.value = '';
                totalHarga.value = '';
            }
        }

        tanggalSewa.addEventListener('change', hitungLamaDanHarga);
        tanggalKembali.addEventListener('change', hitungLamaDanHarga);
        pakaiSupir.addEventListener('change', hitungLamaDanHarga);
    </script>
@endpush
