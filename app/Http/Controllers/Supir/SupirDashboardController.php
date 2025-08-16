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
            ->with('mobil', 'user')
            ->first();

        $riwayat = Transaksi::where('supir_id', $supir->id)
            ->where('status', 3)
            ->latest()
            ->with('mobil', 'user')
            ->take(5)
            ->get();

        return view('supir.dashboard', compact('supir', 'transaksiAktif', 'riwayat'));
    }

    public function updateStatus(Request $request)
    {

        $supir = Supir::findOrFail(auth('supir')->id());
        $supir->status = $request->has('status') ? 1 : 0;
        $supir->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
