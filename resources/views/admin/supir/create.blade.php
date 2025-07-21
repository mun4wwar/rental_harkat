@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Supir</h2>

        <form action="{{ route('supir.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 shadow-md rounded">
            @include('admin.supir.form')
        </form>
    </div>
@endsection
