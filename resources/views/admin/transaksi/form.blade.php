@php
    $isEdit = isset($transaksi);
@endphp

@if ($errors->any())
    <div class="mb-4 text-red-600 bg-red-100 border border-red-300 rounded p-4">
        <ul class="list-disc pl-4 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $isEdit ? route('admin.transaksi.update', $transaksi->id) : route('admin.transaksi.store') }}" method="POST"
    class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- Pelanggan --}}
    <div>
        <x-input-label for="pelanggan_id" :value="'Pelanggan'" />
        <select name="pelanggan_id" id="pelanggan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Pilih Pelanggan --</option>
            @foreach ($pelanggans as $p)
                <option value="{{ $p->id }}"
                    {{ old('pelanggan_id', $transaksi->pelanggan_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('pelanggan_id')" class="mt-2" />
    </div>

    {{-- Mobil --}}
    <div>
        <x-input-label for="mobil_id" :value="'Mobil'" />
        <select name="mobil_id" id="mobil_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Pilih Mobil --</option>
            @foreach ($mobils as $m)
                <option value="{{ $m->id }}"
                    {{ old('mobil_id', $transaksi->mobil_id ?? '') == $m->id ? 'selected' : '' }}>
                    {{ $m->nama_mobil }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('mobil_id')" class="mt-2" />
    </div>

    {{-- Supir --}}
    <div>
        <x-input-label for="supir_id" :value="'Supir (Opsional)'" />
        <select name="supir_id" id="supir_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Tanpa Supir --</option>
            @foreach ($supirs as $s)
                <option value="{{ $s->id }}"
                    {{ old('supir_id', $transaksi->supir_id ?? '') == $s->id ? 'selected' : '' }}>
                    {{ $s->nama }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('supir_id')" class="mt-2" />
    </div>

    {{-- Tanggal Sewa --}}
    <div>
        <x-input-label for="tanggal_sewa" :value="'Tanggal Sewa'" />
        <x-text-input id="tanggal_sewa" type="date" name="tanggal_sewa" :value="old('tanggal_sewa', $transaksi->tanggal_sewa ?? '')"
            class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('tanggal_sewa')" class="mt-2" />
    </div>

    {{-- Tanggal Kembali --}}
    <div>
        <x-input-label for="tanggal_kembali" :value="'Tanggal Kembali'" />
        <x-text-input id="tanggal_kembali" type="date" name="tanggal_kembali" :value="old('tanggal_kembali', $transaksi->tanggal_kembali ?? '')"
            class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
    </div>

    {{-- Status --}}
    <div>
        <x-input-label for="status" :value="'Status Transaksi'" />
        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="1" {{ old('status', $transaksi->status ?? '') == 1 ? 'selected' : '' }}>Booked</option>
            <option value="2" {{ old('status', $transaksi->status ?? '') == 2 ? 'selected' : '' }}>Berjalan
            </option>
            <option value="3" {{ old('status', $transaksi->status ?? '') == 3 ? 'selected' : '' }}>Selesai
            </option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <!-- Tombol Submit -->
    <div class="mt-6">
        <x-primary-button>
            Simpan Transaksi
        </x-primary-button>
    </div>
</form>
