<h2>📑 Daftar Laporan Admin</h2>

<ul>
    @forelse($files as $file)
        <li>
            <a href="{{ asset('storage/laporan/' . basename($file)) }}" target="_blank">
                {{ basename($file) }}
            </a>
        </li>
    @empty
        <li>Belum ada laporan yang digenerate admin.</li>
    @endforelse
</ul>
