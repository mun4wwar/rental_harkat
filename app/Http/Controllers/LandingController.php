<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
{
    $mobils = Mobil::latest()->take(6)->get(); // ambil 6 mobil terbaru
    return view('main-content', compact('mobils'));
}
}
