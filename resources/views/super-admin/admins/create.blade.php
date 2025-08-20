@extends('layouts.superadmin')

@section('title', 'Tambah Admin')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Admin</h2>

<form method="POST" action="{{ route('superadmin.admins.store') }}" class="space-y-4">
    @csrf
    <div>
        <label>Nama</label>
        <input type="text" name="name" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
    </div>

    {{-- Pilih Permissions --}}
    <div>
        <label class="font-semibold">Permissions</label>
        <div class="grid grid-cols-2 gap-2 mt-2">
            @foreach($permissions as $perm)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                    <span>{{ $perm->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
</form>
@endsection
