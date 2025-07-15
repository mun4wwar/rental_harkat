<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Supir;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supirs = Supir::all();
        return view('admin.supir.index', compact('supirs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_supir', 'public');
        }

        Supir::create($data);

        return redirect()->route('supir.index')->with('success', 'Supir berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supir $supir)
    {
        return view('admin.supir.show', compact('supir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supir $supir)
    {
        return view('admin.supir.edit', compact('supir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supir $supir)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required|in:0,1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // Optional: Hapus gambar lama kalau ada
            if ($supir->gambar) {
                Storage::disk('public')->delete($supir->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gambar_supir', 'public');
        }

        $supir->update($data);

        return redirect()->route('supir.index')->with('success', 'Data supir berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supir $supir)
    {
        $supir->delete();

        return redirect()->route('supir.index')->with('success', 'Supir berhasil dihapus.');
    }
}
