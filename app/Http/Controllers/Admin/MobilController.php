<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\TipeMobil;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::with('images')->get();
        return view('admin.mobil.index', compact('mobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeMobil = TipeMobil::all();
        return view('admin.mobil.create', compact('tipeMobil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required',
            'tipe_id' => 'required|exists:tipe_mobils,id',
            'plat_nomor' => 'nullable|unique:mobils',
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'harga_all_in' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $data = $request->except('gambar', 'images');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_mobil', 'public');
        }

        $mobil = Mobil::create($data);

        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('mobil_images', 'public');
                $mobil->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.mobil.index')->with('success', "Mobil berhasil di tambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        $mobil->load('images'); // eager load
        return view('admin.mobil.show', compact('mobil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        $tipeMobil = TipeMobil::all();
        $mobil->load('images');
        return view('admin.mobil.edit', compact('mobil', 'tipeMobil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'nama_mobil' => 'required',
            'tipe_id' => 'required|exists:tipe_mobils,id',
            'plat_nomor' => 'nullable|unique:mobils,plat_nomor,' . $mobil->id,
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'harga_all_in' => 'required|numeric',
            'status' => 'required|in:0,1,2,3,4',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $data = $request->except('gambar', 'images');

        if ($request->hasFile('gambar')) {
            // Optional: Hapus gambar lama kalau ada
            if ($mobil->gambar) {
                Storage::disk('public')->delete($mobil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gambar_mobil', 'public');
        }

        $mobil->update($data);

        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('mobil_images', 'public');
                $mobil->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.mobil.index')->with('success', "Mobil berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mobil $mobil)
    {
        // Hapus cover image
        if ($mobil->gambar) {
            Storage::disk('public')->delete($mobil->gambar);
        }

        // Hapus additional images
        foreach ($mobil->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $mobil->delete();
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus!');
    }
}
