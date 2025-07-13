<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMobil = Mobil::count();
        $mobilTersedia = Mobil::where('status', 1)->count();
        $mobilDisewa = Mobil::where('status', 0)->count();

        return view('admin.dashboard', compact('totalMobil', 'mobilTersedia', 'mobilDisewa'));
    }
}
