<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\Mobil;
use App\Models\Supir;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'mobil', 'supir'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksis'));
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

        Transaksi::create($data);

        // Update status mobil
        Mobil::where('id', $data['mobil_id'])->update([
            'status' => 2,
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $pelanggans = User::all();
        $mobils = Mobil::all();
        $supirs = Supir::all();

        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'mobils', 'supirs'));
    }


    public function update(TransaksiRequest $request, Transaksi $transaksi): RedirectResponse
    {
        $data = $this->prepareTransaksiData($request->validated());

        // Step 1: Cek apakah mobil atau supir sebelumnya dipakai
        $oldMobilId = $transaksi->mobil_id;
        $oldSupirId = $transaksi->supir_id;

        $transaksi->update($data);

        // Step 3: Kalau status transaksi jadi
        if ($data['status'] === 2) {
            // Mobil dan supir jadi tersedia lagi
            Mobil::where('id', $transaksi->mobil_id)->update(['status' => 3]);
            if ($transaksi->supir_id) {
                Supir::where('id', $transaksi->supir_id)->update(['status' => 0]);
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

    public function destroy(Transaksi $transaksi): RedirectResponse
    {
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
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
