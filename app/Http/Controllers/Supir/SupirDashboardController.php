<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupirDashboardController extends Controller
{
    public function index()
    {
        $supir = auth('supir')->id();

        // Job aktif
        $jobAktif = Transaksi::where('supir_id', $supir)
            ->where('status', '!=', 3)
            ->get();

        // Riwayat job
        $riwayatJob = Transaksi::where('supir_id', $supir)
            ->where('status', 3)
            ->get();

        return view('supir.dashboard', compact('supir', 'jobAktif', 'riwayatJob'));
    }

    public function updateStatus(Request $request)
    {

        $supir = Supir::findOrFail(auth('supir')->id());
        $supir->status = $request->has('status') ? 1 : 0;
        $supir->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function acceptJob(Request $request, $transaksiId)
    {
        try {
            $supir = Supir::findOrFail(auth('supir')->id()); // harus object Supir
            $transaksi = Transaksi::findOrFail($transaksiId);

            if ($transaksi->supir_id) {
                return response()->json(['status' => 'failed', 'message' => 'Job sudah diambil supir lain']);
            }

            $transaksi->supir_id = $supir->id;
            $transaksi->pakai_supir = 1;

            $supir->status = 2;
            $supir->save();

            $transaksi->save();

            return response()->json(['status' => 'success', 'message' => 'Job berhasil diterima']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
