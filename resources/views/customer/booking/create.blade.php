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
                <label class="block mb-1 font-semibold">Pilih Mobil</label>
                <select name="mobil_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Mobil --</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}" data-harga="{{ $mobil->harga_sewa }}"
                            data-harga-allin="{{ $mobil->harga_all_in }}">
                            {{ $mobil->nama_mobil }} - Rp{{ number_format($mobil->harga_sewa, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pakai Supir (checkbox) --}}
            <div class="mb-4 flex items-center gap-2">
                <input type="hidden" name="pakai_supir" value="0" class="w-5 h-5">
                <input type="checkbox" name="pakai_supir" id="pakaiSupir" value="1" class="w-5 h-5"
                    onchange="toggleSupir()>
                <label for="pakaiSupir" class="font-semibold">🧑‍✈️ Pakai
                Supir</label>
            </div>

            {{-- Asal Kota --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Asal Kota</label>
                <select name="asal_kota" id="asalKota" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Asal Kota --</option>
                    <option value="1">Warga Yogyakarta</option>
                    <option value="2">Lainnya...</option>
                </select>
            </div>

            {{-- Nama Kota (hidden default) --}}
            <div class="mb-4 hidden" id="namaKotaWrapper">
                <label class="block mb-1 font-semibold">Nama Kota</label>
                <input type="text" name="nama_kota" id="namaKota" class="w-full border rounded p-2">
            </div>

            {{-- Tanggal Sewa --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">📆 Tanggal Sewa</label>
                <input type="date" name="tanggal_sewa" id="tanggalSewa" class="w-full border rounded p-2" required>
            </div>

            {{-- Tanggal Kembali --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">📆 Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggalKembali" class="w-full border rounded p-2" required>
            </div>

            {{-- Lama Sewa (auto) --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">⏳ Lama Sewa (hari)</label>
                <input type="number" name="lama_sewa" id="lamaSewa" class="w-full border rounded p-2 bg-gray-100"
                    readonly>
            </div>

            {{-- Jaminan --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Jaminan</label>
                <select name="jaminan" id="jaminan" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Jaminan --</option>
                    <option value="1">KTP/ID CARD</option>
                    <option value="2">KTP & Motor (untuk warga lokal)</option>
                </select>
            </div>

            {{-- Uang Muka (auto 50%) --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Uang Muka (50%)</label>
                <input type="number" name="uang_muka" id="uangMuka" class="w-full border rounded p-2 bg-gray-100"
                    readonly>
            </div>

            {{-- Total Harga (auto) --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">💰 Total Harga</label>
                <input type="text" name="total_harga" id="totalHarga" class="w-full border rounded p-2 bg-gray-100"
                    readonly>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Booking Sekarang
            </button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const asalKota = document.querySelector("[name='asal_kota']");
                const namaKotaWrapper = document.getElementById('namaKotaWrapper');
                const tanggalSewa = document.querySelector("[name='tanggal_sewa']");
                const tanggalKembali = document.querySelector("[name='tanggal_kembali']");
                const pakaiSupir = document.querySelector("[name='pakai_supir']");
                const mobilSelect = document.querySelector("[name='mobil_id']");
                const lamaSewaInput = document.querySelector("[name='lama_sewa']");
                const jaminan = document.querySelector("[name='jaminan']");
                const uangMukaInput = document.querySelector("[name='uang_muka']");
                const totalHargaInput = document.querySelector("[name='total_harga']");

                function toggleSupir() {
                    document.getElementById('supirField').classList.toggle('hidden', !pakaiSupir.checked);
                }
                // toggle nama kota
                asalKota.addEventListener('change', () => {
                    if (asalKota.value === '2') {
                        namaKotaWrapper.classList.remove('hidden');
                    } else {
                        namaKotaWrapper.classList.add('hidden');
                    }
                });

                function hitungHarga() {
                    if (!tanggalSewa.value || !tanggalKembali.value || !mobilSelect.value) return;

                    let tglSewa = new Date(tanggalSewa.value);
                    let tglKembali = new Date(tanggalKembali.value);
                    let lama = (tglKembali - tglSewa) / (1000 * 60 * 60 * 24); // hasil dalam hari

                    if (lama <= 0) lama = 1; // minimal 1 hari
                    lamaSewaInput.value = lama;

                    // ambil harga mobil dari option dataset
                    let hargaSewa = parseInt(mobilSelect.selectedOptions[0].dataset.harga);
                    let hargaAllIn = parseInt(mobilSelect.selectedOptions[0].dataset.hargaAllin);

                    let total = 0;
                    if (pakaiSupir.checked) {
                        total = lama * hargaAllIn;
                    } else {
                        total = lama * hargaSewa;
                    }

                    totalHargaInput.value = total.toLocaleString("id-ID");
                    uangMukaInput.value = (total / 2).toLocaleString("id-ID");
                }

                tanggalSewa.addEventListener("change", hitungHarga);
                tanggalKembali.addEventListener("change", hitungHarga);
                pakaiSupir.addEventListener("change", hitungHarga);
                mobilSelect.addEventListener("change", hitungHarga);
            });
        </script>
    @endpush
@endsection
