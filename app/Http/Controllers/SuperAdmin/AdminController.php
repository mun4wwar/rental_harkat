<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 2)->get();
        return view('super-admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign roles & permissions
        $admin->assignRole('Admin');
        if ($request->filled('permissions')) {
            $admin->givePermissionTo($request->permissions);
        }

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit(User $admin)
    {
        return view('superadmin.admin.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        // Reset roles & permissions dulu
        $admin->syncRoles($request->roles ?? []);
        $admin->syncPermissions($request->permissions ?? []);

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin berhasil diupdate');
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin berhasil dihapus');
    }
}
