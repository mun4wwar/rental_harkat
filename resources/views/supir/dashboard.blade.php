@extends('layouts.supir')

@section('title', 'Dashboard Supir')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-xl p-6 flex flex-col items-center">
            <div class="text-blue-600 text-3xl font-bold">⚡</div>
            <p class="mt-2 text-gray-600">Status</p>
            <span class="mt-1 font-semibold text-gray-800">
                @if (auth('supir')->user()->is_available)
                    <p class="text-green-600 font-semibold">Ready to Drive 🚗</p>
                @else
                    <p class="text-gray-500">Not Available</p>
                @endif
            </span>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex flex-col items-center">
            <div class="text-green-600 text-3xl font-bold">📋</div>
            <p class="mt-2 text-gray-600">Job Aktif</p>
            <span class="mt-1 font-semibold text-gray-800">3</span>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex flex-col items-center">
            <div class="text-purple-600 text-3xl font-bold">✅</div>
            <p class="mt-2 text-gray-600">Selesai</p>
            <span class="mt-1 font-semibold text-gray-800">12</span>
        </div>
    </div>
@endsection
