@props(['mobils'])

<section class="mt-20" data-aos="fade-up">
    <h3 class="text-2xl font-bold text-center mb-10">Pilihan Mobil Kami</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($mobils as $mobil)
            <a href="{{ route('mobil.show', $mobil->id) }}">
                <div class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                    <img src="{{ Storage::url($mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}"
                        class="w-full h-40 object-contain mb-4">
                    <h4 class="font-semibold text-lg">{{ $mobil->nama_mobil }}</h4>
                    <p class="text-gray-500 text-sm">Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }} / hari</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
