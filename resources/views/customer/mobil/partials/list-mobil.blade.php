<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($mobils as $mobil)
        <div
            class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300">

            <!-- Gambar Mobil -->
            <div class="aspect-[16/9] bg-gray-50 flex items-center justify-center relative">
                <img src="{{ Storage::url($mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}"
                    class="max-h-full max-w-full object-contain p-2">

                <!-- Badge tipe mobil -->
                @if ($mobil->type)
                    <span
                        class="absolute top-3 left-3 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                        {{ $mobil->type->nama_tipe }}
                    </span>
                @endif
            </div>

            <!-- Info Mobil -->
            <div class="p-4 flex flex-col h-full">
                <h2 class="text-lg font-bold text-gray-800">{{ $mobil->nama }}</h2>
                <p class="text-sm text-gray-500 mb-3">{{ $mobil->nama_mobil }}</p>

                <!-- Harga -->
                <div class="mb-4">
                    <p class="text-green-600 font-extrabold text-xl">
                        Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}
                        <span class="text-sm font-medium">/hari</span>
                    </p>
                    <p class="text-green-500 font-semibold text-sm">
                        Rp {{ number_format($mobil->harga_all_in, 0, ',', '.') }}
                        <span class="font-normal">/hari (dengan supir)</span>
                    </p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between"> <a href="{{ route('mobil.show', $mobil->id) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm"> Detail </a>
                    @auth('web')
                        <a href="{{ route('booking.create', ['mobil_id' => $mobil->id]) }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm"> Sewa Sekarang
                        </a>
                    @else
                        <a href="#" id="openCustomerLoginModal"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm"> Sewa Sekarang
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
