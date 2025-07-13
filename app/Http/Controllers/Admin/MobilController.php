<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::all();
        return view('admin.mobil.index', compact('mobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mobil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required',
            'plat_nomor' => 'required|unique:mobils',
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        Mobil::create($request->all());

        return redirect()->route('mobil.index')->with('success', "Mobil berhasil di tambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        return view('admin.mobil.show', compact('mobil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        return view('admin.mobil.edit', compact('mobil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'nama_mobil' => 'required',
            'plat_nomor' => 'required|unique:mobils,plat_nomor,' . $mobil->id,
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'status' => 'required|in:0,1',
        ]);

        $mobil->update($request->all());

        return redirect()->route('mobil.index')->with('success', "Mobil berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus!');
    }
}
