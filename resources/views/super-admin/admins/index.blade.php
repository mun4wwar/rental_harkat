@extends('layouts.superadmin')

@section('title', 'Kelola Admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Kelola Admin</h2>

    <a href="{{ route('superadmin.admins.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg mb-4 inline-block">+
        Tambah Admin</a>

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">ID</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td class="border p-2">{{ $admin->id }}</td>
                    <td class="border p-2">{{ $admin->name }}</td>
                    <td class="border p-2">{{ $admin->email }}</td>
                    <td class="border p-2">
                        <a href="{{ route('superadmin.admins.edit', $admin) }}" class="text-yellow-600">Edit</a> |
                        <form action="{{ route('superadmin.admins.destroy', $admin) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600"
                                onclick="return confirm('Hapus admin ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
