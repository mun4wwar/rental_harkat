<!DOCTYPE html>
<html>

<head>
    <title>Laporan Admin</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Laporan Admin ke Super Admin</h2>
    <p><strong>Jumlah Booking:</strong> {{ $jumlahBooking }}</p>
    <p><strong>Jumlah Mobil Dibooking:</strong> {{ $jumlahMobil }}</p>
    <p><strong>Total Pendapatan:</strong> Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>

    <h3>Mobil Paling Sering Dibooking</h3>
    <table>
        <thead>
            <tr>
                <th>Mobil</th>
                <th>Jumlah Booking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mobilTerpopuler as $item)
                <tr>
                    <td>{{ $item->mobil->nama_mobil ?? 'Unknown' }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong></strong></strong> {{ $jumlahBooking }}</p>
    <p><strong>..., 28 Agustus 2025</strong> {{ $jumlahBooking }}</p>
    <p><strong></strong> {{ $jumlahMobil }}</p>
</body>

</html>
