<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\TipeMobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $mobils = Mobil::latest()->take(3)->get();
        $user = Auth::user();
        return view('main-content', compact('mobils', 'user'));
    }
}
