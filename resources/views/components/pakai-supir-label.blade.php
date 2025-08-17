@props(['pakaiSupir', 'supir', 'transaksi'])

@if ($pakaiSupir == 0)
    Tanpa Supir
@elseif ($pakaiSupir == 1 && $supir == null)
    ✅ Pakai Supir (Belum Ditentukan)
    @if ($transaksi->supir)
        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
            {{ $transaksi->supir->nama }}
        </span>
    @else
        <form action="{{ route('admin.assign-supir', $transaksi->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-full">
                Assign Job
            </button>
        </form>
    @endif
@elseif ($pakaiSupir == 2)
    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
        🚕 Menunggu supir merespon...
    </span>
@elseif ($pakaiSupir == 1 && $supir)
    🧍 Supir: {{ $supir->nama }}
@endif
