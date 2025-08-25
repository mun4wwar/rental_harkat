<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        return view('superadmin.dashboard');
    }

    public function listLaporan()
    {
        $folderPath = storage_path('app/public/laporan');
        $files = [];

        if (File::exists($folderPath)) {
            $files = File::files($folderPath);
        }

        return view('superadmin.laporan.index', compact('files'));
    }
}
