@if ($pakaiSupir == 0)
    Tanpa Supir
@elseif ($pakaiSupir == 1 && $supir == null)
    ✅ Pakai Supir (Belum Ditentukan)
@elseif ($pakaiSupir == 1 && $supir)
    🧍 Supir: {{ $supir->nama }}
@endif