<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Mobil;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $bookings = Booking::where('user_id', $userId)
            ->whereIn('status', [1, 2]) // booked & ongoing
            ->with(['details'])
            ->latest()
            ->get();

        return view('customer.booking.index', compact('bookings'));
    }
    public function create(Request $request)
    {
        $mobils = Mobil::all();
        if ($mobils->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada mobil tersedia.');
        }


        return view('customer.booking.create', compact('mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobils.*.mobil_id' => 'required|exists:mobils,id',
            'mobils.*.tanggal_sewa' => 'required|date',
            'mobils.*.tanggal_kembali' => 'required|date|after_or_equal:mobils.*.tanggal_sewa',
            'mobils.*.pakai_supir' => 'required|in:0,1',
            'asal_kota' => 'required|in:1,2',
            'nama_kota' => 'required_if:asal_kota,2|nullable|string',
            'jaminan' => 'required|in:1,2',
        ], [
            'mobils.*.mobil_id.required' => 'Mobil harus dipilih.',
            'mobils.*.tanggal_sewa.required' => 'Tanggal sewa harus diisi.',
            'mobils.*.tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal sewa.',
            'asal_kota.required' => 'Asal Kota harus diisi.',
            'nama_kota.required_if' => 'Nama kota harus diisi jika asal kota = luar kota.',
            'jaminan.required' => 'Jaminan harus diisi.',
        ]);

        $user = auth()->guard('web')->user();
        if (!$user) abort(403, 'Anda harus login dulu');

        $uangMuka = str_replace('.', '', $request->uang_muka);
        $uangMuka = (float) $uangMuka;

        $booking = Booking::create([
            'user_id' => $user->id,
            'tanggal_booking' => now(),
            'total_harga' => 0,
            'status' => 1,
            'asal_kota' => $request->asal_kota,
            'nama_kota' => $request->nama_kota,
            'jaminan' => $request->jaminan,
            'uang_muka' => $uangMuka,
        ]);

        $totalBooking = 0;

        foreach ($request->mobils as $item) {
            $mobil = Mobil::findOrFail($item['mobil_id']);
            $lama = Carbon::parse($item['tanggal_sewa'])->diffInDays(Carbon::parse($item['tanggal_kembali']));
            if ($lama <= 0) $lama = 1;

            $harga = $item['pakai_supir'] ? $mobil->harga_all_in * $lama : $mobil->harga_sewa * $lama;

            BookingDetail::create([
                'booking_id' => $booking->id,
                'mobil_id' => $mobil->id,
                'pakai_supir' => $item['pakai_supir'],
                'supir_id' => null,
                'tanggal_sewa' => $item['tanggal_sewa'],
                'tanggal_kembali' => $item['tanggal_kembali'],
                'lama_sewa' => $lama,
                'harga' => $harga,
            ]);

            $mobil->status = 2; // booked
            $mobil->save();

            $totalBooking += $harga;
        }

        $booking->update([
            'total_harga' => $totalBooking,
            'uang_muka' => $totalBooking / 2,
        ]);
        $dp = $uangMuka;
        // langsung generate pembayaran DP (belum bayar)
        Pembayaran::create([
            'booking_id' => $booking->id,
            'jenis' => 1,
            'jumlah' => $dp,
            'status' => 0,
            'jatuh_tempo' => Carbon::parse($request->mobils[0]['tanggal_sewa'])->subDays(3), // H-3 sebelum sewa
        ]);

        return redirect()->route('home')->with('success', 'Booking berhasil! Silakan tunggu konfirmasi dari admin.');
    }

    // Riwayat booking (sudah selesai)
    public function riwayat()
    {
        $userId = Auth::id();

        $riwayat = Booking::where('user_id', $userId)
            ->whereIn('status', [0, 3]) // canceled & done
            ->with(['mobil', 'supir'])
            ->latest()
            ->get();

        return view('customer.booking.riwayat', compact('riwayat'));
    }
}
