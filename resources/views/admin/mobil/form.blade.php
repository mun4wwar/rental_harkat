@if ($errors->any())
    <div class="mb-4 text-red-600 bg-red-100 border border-red-300 rounded p-4">
        <ul class="list-disc pl-4 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@csrf
{{-- Nama Mobil --}}
<div>
    <label for="nama_mobil" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
    <input type="text" name="nama_mobil" id="nama_mobil"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('nama_mobil', $mobil->nama_mobil ?? '') }}" required>
</div>

{{-- Plat Nomor --}}
{{-- <div>
    <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
    <input type="text" name="plat_nomor" id="plat_nomor"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('plat_nomor', $mobil->plat_nomor ?? '') }}">
</div> --}}

{{-- Merk --}}
<div>
    <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
    <input type="text" name="merk" id="merk"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('merk', $mobil->merk ?? '') }}" required>
</div>

{{-- Tahun --}}
<div>
    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
    <input type="number" name="tahun" id="tahun"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('tahun', $mobil->tahun ?? '') }}" required>
</div>

{{-- Harga Sewa --}}
<div>
    <label for="harga_sewa" class="block text-sm font-medium text-gray-700">Harga Sewa</label>
    <input type="number" name="harga_sewa" id="harga_sewa"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('harga_sewa', $mobil->harga_sewa ?? '') }}" required>
</div>

{{-- Harga Sewa All In --}}
<div>
    <label for="harga_all_in" class="block text-sm font-medium text-gray-700">Harga Sewa ALL IN</label>
    <input type="number" name="harga_all_in" id="harga_all_in"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        value="{{ old('harga_all_in', $mobil->harga_all_in ?? '') }}" required>
</div>

{{-- Gambar --}}
<div>
    <label for="gambar" class="block text-sm font-medium text-gray-700">Foto Mobil</label>
    <input type="file" name="gambar" id="gambar"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        @if (!isset($mobil)) required @endif>
</div>

{{-- Tombol Submit --}}
<div class="flex justify-end space-x-2">
    <a href="{{ route('mobil.index') }}"
        class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        {{ isset($mobil) ? 'Update' : 'Simpan' }}
    </button>
</div>
