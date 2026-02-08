<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN PEMBAYARAN LISTRIK</h2>
        <p>Periode: {{ $bulan }} / {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>No KWH</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->tanggal_pembayaran }}</td>
                <td>{{ $row->pelanggan->name }}</td>
                <td>{{ $row->pelanggan->nomor_kwh }}</td>
                <td style="text-align: right;">Rp {{ number_format($row->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">GRAND TOTAL</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($laporan->sum('total_bayar'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Petugas Administrasi,</p>
        <br><br><br>
        <p>( __________________ )</p>
    </div>

</body>
</html>