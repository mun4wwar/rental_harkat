@extends('layouts.landing') {{-- atau layout utama lu --}}

@section('content')
    <div class="max-w-7xl mx-auto px-6 pt-20">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">🚗 Armada Harkat</h1>

        <!-- Search & Filter -->
        <form id="filterForm" method="GET" class="flex flex-col md:flex-row gap-3 mb-4">
            <!-- Search -->
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari mobil..."
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:ring focus:ring-green-200">

            <!-- Filter Tipe -->
            <select name="type" id="typeFilter"
                class="w-full md:w-1/4 px-4 py-2 border rounded-lg focus:ring focus:ring-green-200">
                <option value="">Semua Tipe</option>
                @foreach ($tipeMobils as $tipe)
                    <option value="{{ $tipe->nama_tipe }}" {{ request('type') == $tipe->nama_tipe ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- List Mobil -->
        <div id="mobilList">
            @include('customer.mobil.partials.list-mobil', ['mobils' => $mobils])
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let timer;

            function fetchMobils() {
                $.ajax({
                    url: "{{ route('mobil.index') }}",
                    data: $('#filterForm').serialize(),
                    success: function(data) {
                        $('#mobilList').html(data);
                    }
                });
            }

            // Live search dengan debounce 300ms
            $('#searchInput').on('keyup', function() {
                clearTimeout(timer);
                timer = setTimeout(fetchMobils, 300);
            });

            // Auto filter saat ganti tipe
            $('#typeFilter').on('change', function() {
                fetchMobils();
            });
        });
    </script>
@endpush
