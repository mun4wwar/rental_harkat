<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
            'pakai_supir' => 'required|in:0,1',
            'asal_kota' => 'required|in:1,2',
            'jaminan' => 'required|in:1,2',
        ], [
            'mobil_id.required' => 'Mobil harus dipilih.',
            'asal_kota.required' => 'Asal Kota harus diisi.',
            'jaminan.required' => 'Jaminan harus diisi.',
            'tanggal_sewa.required' => 'Tanggal sewa harus diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal sewa.',
        ]);

        $lama_sewa = Carbon::parse($request->tanggal_sewa)
            ->diffInDays(Carbon::parse($request->tanggal_kembali));
        if ($lama_sewa <= 0) $lama_sewa = 1;

        $mobil = Mobil::findOrFail($request->mobil_id);

        // logika harga
        $total_harga = $request->pakai_supir
            ? $mobil->harga_all_in * $lama_sewa
            : $mobil->harga_sewa * $lama_sewa;

        // hitung uang muka (misal 50% dari total)
        $uang_muka = $total_harga / 2;

        $user = auth()->guard('web')->user();
        if (!$user) {
            abort(403, 'Anda harus login dulu');
        }

        Transaksi::create([
            'user_id' => $user->id,
            'mobil_id' => $request->mobil_id,
            'supir_id' => null,
            'asal_kota' => $request->asal_kota,
            'nama_kota' => $request->nama_kota,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jaminan' => $request->jaminan,
            'lama_sewa' => $lama_sewa,
            'uang_muka' => $uang_muka,
            'total_harga' => $total_harga,
            'status' => 1, // Booked
            'pakai_supir' => $request->pakai_supir, // kalau mau disimpan
        ]);
        // Update status mobil jadi 2 (Telah di-booking)
        $mobil->status = 2;
        $mobil->save();

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
