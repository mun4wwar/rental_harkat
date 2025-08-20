<h2 class="text-xl font-bold mb-3">Riwayat Pesanan</h2>
@forelse($riwayat as $booking)
    <div class="border p-3 rounded mb-2">
        <p><strong>Mobil:</strong> {{ $booking->mobil->nama }}</p>
        <p><strong>Supir:</strong> {{ $booking->supir->nama ?? 'Tanpa Supir' }}</p>
        <p><strong>Tanggal Sewa:</strong> {{ $booking->tanggal_sewa }}</p>
        <p><strong>Status:</strong> {{ $booking->status == 0 ? 'Canceled' : 'Done' }}</p>
    </div>
@empty
    <p>Tidak ada riwayat pesanan.</p>
@endforelse
