<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupirDashboardController extends Controller
{
    public function index()
    {
        $supir = Auth::guard('supir')->user();

        $transaksiAktif = Transaksi::where('supir_id', $supir->id)
            ->where('status', 2)
            ->with('mobil', 'pelanggan')
            ->first();

        $riwayat = Transaksi::where('supir_id', $supir->id)
            ->where('status', 3)
            ->latest()
            ->with('mobil', 'pelanggan')
            ->take(5)
            ->get();

        return view('supir.dashboard', compact('supir', 'transaksiAktif', 'riwayat'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:available,unavailable,on_trip'
        ]);

        $supir = Auth::guard('supir')->user();
        dd(get_class($supir));
        $supir->status = $request->status;
        $supir->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
