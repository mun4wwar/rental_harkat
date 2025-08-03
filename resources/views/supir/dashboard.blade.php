@extends('layouts.supir')

@section('title', 'Dashboard Supir')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Halo, {{ auth()->guard('supir')->user()->nama }}</h1>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Status</h5>
                    <p class="card-text">
                        <strong class="text-success">Siap Jalan</strong>
                        {{-- nanti bisa diganti dinamis --}}
                    </p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Ubah Status</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Job Aktif</h5>
                    <p class="card-text">1 job sedang berlangsung</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Riwayat Nyupir</h5>
                    <p class="card-text">Total 18 Transaksi</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
