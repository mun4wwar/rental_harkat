@props(['mobils'])

<section class="mt-10" data-aos="fade-up">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($mobils as $mobil)
            <div class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                <a href="{{ route('mobil.show', $mobil->id) }}">
                    <img src="{{ Storage::url($mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-40 object-contain mb-4">
                    <h4 class="font-semibold text-lg">{{ $mobil->nama_mobil }}</h4>
                    <p class="text-gray-500 text-sm">Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }} / hari</p>
                </a>

                {{-- Tombol booking --}}
                <div class="mt-4">
                    @if (Auth::check() && Auth::user()->role == 3)
                        <a href="{{ route('booking.create') }}"
                            class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                            Booking Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                            Booking Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
