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

            <div id="mobils-container">
                <div class="mobil-item mb-4 border p-4 rounded">
                    {{-- Pilih Mobil --}}
                    <div class="mb-2">
                        <label class="block mb-1 font-semibold">Pilih Mobil</label>
                        <select name="mobils[0][mobil_id]" class="w-full border rounded p-2 mobil-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach ($mobils as $mobil)
                                <option value="{{ $mobil->id }}" data-harga="{{ $mobil->harga_sewa }}"
                                    data-harga-allin="{{ $mobil->harga_all_in }}">
                                    {{ $mobil->nama_mobil }} - Rp{{ number_format($mobil->harga_sewa, 0, ',', '.') }}/hari |
                                    Include Supir: Rp{{ number_format($mobil->harga_all_in, 0, ',', '.') }}/hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pakai Supir --}}
                    <div class="mb-2 flex items-center gap-2">
                        <input type="hidden" class="hidden-pakai-supir" name="mobils[0][pakai_supir]" value="0">
                        <input type="checkbox" class="pakai-supir-checkbox w-5 h-5">
                        <label class="font-semibold">🧑‍✈️ Pakai Supir</label>
                    </div>

                    {{-- Tanggal Sewa & Kembali --}}
                    <div class="flex gap-2 mb-2">
                        <div>
                            <label class="block mb-1 font-semibold">📆 Tanggal Sewa</label>
                            <input type="date" name="mobils[0][tanggal_sewa]"
                                class="w-full border rounded p-2 tanggal-sewa" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold">📆 Tanggal Kembali</label>
                            <input type="date" name="mobils[0][tanggal_kembali]"
                                class="w-full border rounded p-2 tanggal-kembali" required>
                        </div>
                    </div>

                    {{-- Lama Sewa --}}
                    <div class="mb-2">
                        <label class="block mb-1 font-semibold">⏳ Lama Sewa (hari)</label>
                        <input type="number" class="w-full border rounded p-2 bg-gray-100 lama-sewa" readonly>
                    </div>

                    {{-- Total Harga Mobil --}}
                    <div class="mb-2">
                        <label class="block mb-1 font-semibold">💰 Total Harga Mobil</label>
                        <input type="text" class="w-full border rounded p-2 bg-gray-100 total-harga-mobil" readonly>
                    </div>

                    <button type="button" class="remove-mobil mt-2 text-red-500">Hapus</button>
                </div>
            </div>

            <button type="button" id="add-mobil" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Tambah
                Mobil</button>

            <hr class="my-4">

            {{-- Asal Kota --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Asal Kota</label>
                <select name="asal_kota" id="asalKota" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Asal Kota --</option>
                    <option value="1">Warga Yogyakarta</option>
                    <option value="2">Lainnya...</option>
                </select>
            </div>

            {{-- Nama Kota --}}
            <div class="mb-4 hidden" id="namaKotaWrapper">
                <label class="block mb-1 font-semibold">Nama Kota</label>
                <input type="text" name="nama_kota" id="namaKota" class="w-full border rounded p-2">
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

            {{-- Uang Muka --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Uang Muka (50%)</label>
                <input type="text" name="uang_muka" id="uangMuka" class="w-full border rounded p-2 bg-gray-100"
                    readonly>
            </div>

            {{-- Total Booking --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">💰 Total Harga Semua Mobil</label>
                <input type="text" name="total_harga" id="totalHarga" class="w-full border rounded p-2 bg-gray-100"
                    readonly>
            </div>


            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Booking
                Sekarang</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let index = 1;

                function attachListeners(item) {
                    const tanggalSewa = item.querySelector('.tanggal-sewa');
                    const tanggalKembali = item.querySelector('.tanggal-kembali');
                    const mobilSelect = item.querySelector('.mobil-select');
                    const pakaiSupir = item.querySelector('.pakai-supir-checkbox');
                    const hiddenSupir = item.querySelector('.hidden-pakai-supir');
                    const lamaSewaInput = item.querySelector('.lama-sewa');
                    const totalHargaInput = item.querySelector('.total-harga-mobil');
                    const removeBtn = item.querySelector('.remove-mobil');

                    function hitungHarga() {
                        if (!tanggalSewa.value || !tanggalKembali.value || !mobilSelect.value) return;

                        let tglSewa = new Date(tanggalSewa.value);
                        let tglKembali = new Date(tanggalKembali.value);
                        let lama = (tglKembali - tglSewa) / (1000 * 60 * 60 * 24);
                        if (lama <= 0) lama = 1;
                        lamaSewaInput.value = lama;

                        let hargaSewa = parseInt(mobilSelect.selectedOptions[0].dataset.harga);
                        let hargaAllIn = parseInt(mobilSelect.selectedOptions[0].dataset.hargaAllin);
                        let total = pakaiSupir.checked ? lama * hargaAllIn : lama * hargaSewa;
                        totalHargaInput.value = total.toLocaleString('id-ID');

                        // update total global & uang muka
                        let totalAll = 0;
                        document.querySelectorAll('.total-harga-mobil').forEach(el => {
                            totalAll += parseInt(el.value.replace(/\./g, '')) || 0;
                        });
                        document.getElementById('totalHarga').value = totalAll.toLocaleString('id-ID');
                        document.getElementById('uangMuka').value = (totalAll / 2).toLocaleString('id-ID');
                    }

                    tanggalSewa.addEventListener('change', hitungHarga);
                    tanggalKembali.addEventListener('change', hitungHarga);
                    pakaiSupir.addEventListener('change', () => {
                        hiddenSupir.value = pakaiSupir.checked ? 1 : 0;
                        hitungHarga();
                    });
                    mobilSelect.addEventListener('change', hitungHarga);
                    removeBtn.addEventListener('click', () => {
                        item.remove();
                        hitungHarga();
                    });
                }

                // attach initial listeners
                document.querySelectorAll('.mobil-item').forEach(attachListeners);

                // tombol tambah mobil
                document.getElementById('add-mobil').addEventListener('click', () => {
                    let container = document.getElementById('mobils-container');
                    let template = document.querySelector('.mobil-item').cloneNode(true);

                    // update semua name & reset values
                    template.querySelectorAll('select,input').forEach(el => {
                        let name = el.getAttribute('name');
                        if (name) name = name.replace(/\d+/, index);
                        if (name) el.setAttribute('name', name);

                        if (el.type === 'checkbox') el.checked = false;
                        if (el.classList.contains('hidden-pakai-supir')) {
                            el.value = 0;
                        }

                        if (el.type === 'date') el.value = '';
                        if (el.classList.contains('lama-sewa') || el.classList.contains(
                                'total-harga-mobil')) el.value = '';
                    });

                    container.appendChild(template);
                    attachListeners(template);
                    index++;
                });

                // toggle nama kota
                const asalKota = document.getElementById('asalKota');
                asalKota.addEventListener('change', () => {
                    document.getElementById('namaKotaWrapper').classList.toggle('hidden', asalKota.value !==
                        '2');
                });
            });
        </script>
    @endpush
@endsection
