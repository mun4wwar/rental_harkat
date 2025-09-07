<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterMobil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\TipeMobil;
use Illuminate\Support\Facades\Auth;

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
        $masterMobils = MasterMobil::all();
        return view('admin.mobil.create', compact('tipeMobil', 'masterMobils'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'master_mobil_id' => 'required|exists:master_mobils,id',
            'plat_nomor' => [
                'required',
                'unique:mobils,plat_nomor,' . ($mobil->id ?? 'NULL'),
                'regex:/^[A-Z]{1,2}\s\d{1,4}\s[A-Z]{1,3}$/'
            ],
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'harga_all_in' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        $data = $request->except('gambar', 'images');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_mobil', 'public');
        }
        $data['status_approval'] = 2;

        $mobil = Mobil::create($data);

        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('mobil_images', 'public');
                $mobil->images()->create(['image_path' => $path]);
            }
        }

        // ✅ Buat request approval
        $mobil->approvals()->create([
            'requested_by' => $user->id,
            'status' => 2, // pending
            'old_data' => null,
            'new_data' => $mobil,
        ]);

        return redirect()->route('admin.mobil.index')->with('success', "Mobil berhasil ditambahkan, menunggu approval super admin.");
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
        $mobilData = $mobil; // ini instance mobil yang mau diedit
        $mobilData->load('images'); // load relasi gambar

        $tipeMobil = TipeMobil::all();
        $masterMobils = MasterMobil::all(); // ini list master mobil buat dropdown

        return view('admin.mobil.edit', compact('mobilData', 'masterMobils', 'tipeMobil'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mobil $mobil)
    {
        $user = Auth::user();
        $request->validate([
            'master_mobil_id' => 'required|exists:master_mobils,id',
            'plat_nomor' => [
                'required',
                'unique:mobils,plat_nomor,' . ($mobil->id ?? 'NULL'),
                'regex:/^[A-Z]{1,2}\s\d{1,4}\s[A-Z]{1,3}$/'
            ],
            'merk' => 'required',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
            'harga_all_in' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        // 1) snapshot data lama
        $old = $mobil->only([
            'master_mobil_id',
            'plat_nomor',
            'merk',
            'tahun',
            'harga_sewa',
            'harga_all_in',
            'status',
            'gambar'
        ]);

        $data = $request->except('gambar', 'images');
        if ($request->hasFile('gambar')) {
            if ($mobil->gambar) {
                Storage::disk('public')->delete($mobil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gambar_mobil', 'public');
        }
        $data['status_approval'] = 2;

        $mobil->update($data);

        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('mobil_images', 'public');
                $mobil->images()->create(['image_path' => $path]);
            }
        }

        // 4) simpan approval snapshot
        $mobil->approvals()->create([
            'requested_by' => $user->id,
            'status' => 2,
            'old_data' => $old,
            'new_data' => $mobil->only([
                'master_mobil_id',
                'plat_nomor',
                'merk',
                'tahun',
                'harga_sewa',
                'harga_all_in',
                'status',
                'gambar'
            ]),
        ]);

        return redirect()->route('admin.mobil.index')->with('success', "Mobil berhasil diupdate, menunggu approval super admin.");
    }

    public function updateStatus($id)
    {
        $mobil = Mobil::findOrFail($id);

        if ($mobil->status === Mobil::STATUS_MAINTENANCE) {
            $mobil->status = Mobil::STATUS_TERSEDIA;
        } elseif ($mobil->status === Mobil::STATUS_TERSEDIA) {
            $mobil->status = Mobil::STATUS_MAINTENANCE;
        } else {
            return response()->json(['success' => false, 'message' => 'Status tidak bisa diubah'], 400);
        }

        $mobil->save();

        return response()->json([
            'success' => true,
            'new_status' => $mobil->status_text,
            'badge_class' => $mobil->status_badge_class,
        ]);
    }
}
