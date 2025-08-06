<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function homepage()
    {
        $mobils = Mobil::latest()->take(6)->get();
        $user = Auth::user();
        return view('main-content', compact('mobils', 'user'));
    }
}
