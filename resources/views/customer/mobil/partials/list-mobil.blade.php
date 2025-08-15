<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($mobils as $mobil)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
            <img src="{{ Storage::url($mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}" class="w-full h-48 object-cover">

            <div class="p-4">
                <h2 class="text-lg font-bold text-gray-800">{{ $mobil->nama }}</h2>
                <p class="text-sm text-gray-500 mb-2">
                    {{ $mobil->nama_mobil }} • {{ $mobil->types->nama_tipe }} Kursi • {{ $mobil->bahan_bakar }}
                </p>
                <p class="text-green-600 font-bold text-lg mb-4">
                    Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}/hari
                </p>

                <div class="flex justify-between">
                    <a href="{{ route('mobil.show', $mobil->id) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm">
                        Detail
                    </a>

                    @auth('web')
                        <a href="{{ route('booking.create', ['mobil_id' => $mobil->id]) }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            Sewa Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            Sewa Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <p class="col-span-4 text-center text-gray-500">Mobil tidak ditemukan.</p>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $mobils->links() }}
</div>
