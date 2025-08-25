<?php

namespace App\Http\Controllers\Admin;

use App\Events\JobAssigned;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\JobOffer;
use App\Models\Mobil;
use App\Models\Supir;
use App\Models\User;
use App\Notifications\JobAssignedEmail;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['details'])->latest()->get();
        return view('admin.transaksi.index', compact('bookings'));
    }

    public function create()
    {
        $pelanggans = User::all();
        $mobils = Mobil::all();
        $supirs = Supir::all();

        return view('admin.transaksi.create', compact('pelanggans', 'mobils', 'supirs'));
    }

    public function store(TransaksiRequest $request): RedirectResponse
    {
        $data = $this->prepareTransaksiData($request->validated());

        Booking::create($data);

        // Update status mobil
        Mobil::where('id', $data['mobil_id'])->update([
            'status' => 2,
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Booking $booking)
    {
        $pelanggans = User::all();
        $mobils = Mobil::all();
        $supirs = Supir::all();

        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'mobils', 'supirs'));
    }

    public function update(TransaksiRequest $request, Booking $booking): RedirectResponse
    {
        $data = $this->prepareTransaksiData($request->validated());

        // Step 1: Cek apakah mobil atau supir sebelumnya dipakai
        $oldMobilId = $booking->mobil_id;
        $oldSupirId = $booking->supir_id;

        $booking->update($data);

        // Step 3: Kalau status transaksi jadi
        if ($data['status'] === 2) {
            // Mobil dan supir jadi tersedia lagi
            Mobil::where('id', $booking->mobil_id)->update(['status' => 3]);
            if ($booking->supir_id) {
                Supir::where('id', $booking->supir_id)->update(['status' => 0]);
            }
        } else {
            // Kalau mobil diganti, balikin mobil lama jadi tersedia
            if ($oldMobilId !== $data['mobil_id']) {
                Mobil::where('id', $oldMobilId)->update(['status' => 1]);
            }

            // Mobil baru jadi tidak tersedia
            Mobil::where('id', $data['mobil_id'])->update(['status' => 3]);

            // Supir juga dicek
            if ($oldSupirId !== $data['supir_id']) {
                if ($oldSupirId) {
                    Supir::where('id', $oldSupirId)->update(['status' => 1]);
                }
            }

            if (!empty($data['supir_id'])) {
                Supir::where('id', $data['supir_id'])->update(['status' => 0]);
            }
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function assignJobSupir(Request $request, BookingDetail $bookingDtl)
    {
        try {
            // Ambil semua supir available
            $availableSupirs = Supir::where('status', 1)->get();
            if ($availableSupirs->isEmpty()) {
                return back()->with('error', 'Tidak ada supir yang available.');
            }

            // Mulai transaksi DB
            DB::transaction(function () use ($availableSupirs, $bookingDtl) {
                foreach ($availableSupirs as $supir) {
                    $offer = JobOffer::firstOrCreate([
                        'booking_detail_id' => $bookingDtl->id,
                        'supir_id' => $supir->id,
                    ]);
                    Log::info("Job offer created/exists:", $offer->toArray());
                    // Cek kalau supir punya user_id
                    if ($supir->user_id) {
                        event(new JobAssigned($offer));
                    }
                    // Kirim email
                    if ($supir->user && $supir->user->email) {
                        $supir->user->notify(new JobAssignedEmail($bookingDtl));
                    }
                }
            });
            $bookingDtl->update(['pakai_supir' => 2]);
            return back()->with('success', 'Job dikirim ke semua supir available.');
        } catch (\Exception $e) {
            Log::error('AssignJob error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal assign job: ' . $e->getMessage());
        }
    }

    /**
     * Prepare data for create or update transaksi
     */
    private function prepareTransaksiData(array $data): array
    {
        $tanggalSewa = Carbon::parse($data['tanggal_sewa']);
        $tanggalKembali = Carbon::parse($data['tanggal_kembali']);
        $lamaSewa = $tanggalSewa->diffInDays($tanggalKembali) + 1;

        $mobil = Mobil::findOrFail($data['mobil_id']);
        $hargaPerHari = $mobil->getHargaPerHari(isset($data['supir_id']));
        $totalHarga = $hargaPerHari * $lamaSewa;

        return array_merge($data, [
            'lama_sewa' => $lamaSewa,
            'total_harga' => $totalHarga,
        ]);
    }
}
