<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Support\Facades\File;

class LaporanController extends Controller
{
    public function generateLaporanAdmin()
    {
        // total booking
        $jumlahBooking = Booking::count();

        // jumlah mobil yang pernah dibooking
        $jumlahMobil = BookingDetail::distinct('mobil_id')->count('mobil_id');

        // total pendapatan
        $totalPendapatan = Booking::sum('total_harga');

        // mobil yang paling sering dibooking (top 5)
        $mobilTerpopuler = BookingDetail::select('mobil_id', DB::raw('COUNT(*) as total'))
            ->groupBy('mobil_id')
            ->orderByDesc('total')
            ->with('mobil') // relasi mobil di model BookingDetail
            ->take(5)
            ->get();

        $pdf = Pdf::loadView('laporan.admin', compact(
            'jumlahBooking',
            'jumlahMobil',
            'totalPendapatan',
            'mobilTerpopuler'
        ));

        // bikin folder kalau belum ada
        $folderPath = storage_path('app/public/laporan');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // nama file unik per generate
        $filename = 'laporan_admin_' . now()->format('Ymd_His') . '.pdf';
        $path = $folderPath . '/' . $filename;

        // simpan ke storage
        $pdf->save($path);

        return back()->with('success', 'Laporan berhasil digenerate dan disimpan!');
    }
}
