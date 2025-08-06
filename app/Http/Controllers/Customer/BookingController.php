<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
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
        ], [
            'mobil_id.required' => 'Mobil harus dipilih.',
            'tanggal_sewa.required' => 'Tanggal sewa harus diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal sewa.',
        ]);

        $lama_sewa = Carbon::parse($request->tanggal_sewa)->diffInDays(Carbon::parse($request->tanggal_kembali)) + 1;

        $mobil = Mobil::findOrFail($request->mobil_id);

        // logika harga
        $total_harga = $request->pakai_supir
            ? $mobil->harga_all_in * $lama_sewa
            : $mobil->harga_sewa * $lama_sewa;

        $user = auth()->guard('web')->user();
        if (!$user) {
            abort(403, 'Anda harus login dulu');
        }

        Transaksi::create([
            'user_id' => $user->id,
            'mobil_id' => $request->mobil_id,
            'supir_id' => null,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'lama_sewa' => $lama_sewa,
            'total_harga' => $total_harga,
            'status' => 1, // Booked
            'pakai_supir' => $request->pakai_supir, // kalau mau disimpan
        ]);
        // Update status mobil jadi 2 (Telah di-booking)
        $mobil->status = 2;
        $mobil->save();

        return redirect()->route('home')->with('success', 'Booking berhasil! Silakan tunggu konfirmasi dari admin.');
    }
}
