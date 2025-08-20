<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Mobil;
use App\Models\TipeMobil;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Transaksi::where('user_id', Auth::id())
            ->where('status', '!=', 3) // filter status selain selesai
            ->latest()
            ->get();

        return view('booking.index', compact('bookings'));
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
            'jaminan' => 'required|in:1,2',
        ], [
            'mobils.*.mobil_id.required' => 'Mobil harus dipilih.',
            'mobils.*.tanggal_sewa.required' => 'Tanggal sewa harus diisi.',
            'mobils.*.tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal sewa.',
            'asal_kota.required' => 'Asal Kota harus diisi.',
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

        return redirect()->route('home')->with('success', 'Booking berhasil! Silakan tunggu konfirmasi dari admin.');
    }

    // Riwayat booking (sudah selesai)
    public function riwayat()
    {
        $riwayats = Transaksi::where('user_id', Auth::id())
            ->where('status', 3)
            ->latest()
            ->get();

        return view('booking.riwayat', compact('riwayats'));
    }
}
