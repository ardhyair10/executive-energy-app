<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-yellow-500">Laporan Pembayaran Listrik</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white">Kembali ke Dashboard</a>
        </div>

        <form method="GET" action="{{ route('admin.laporan') }}" class="bg-gray-800 p-4 rounded-lg mb-6 flex gap-4">
            <select name="bulan" class="bg-gray-700 text-white p-2 rounded">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="12">Desember</option>
            </select>
            <input type="number" name="tahun" value="{{ date('Y') }}" class="bg-gray-700 text-white p-2 rounded w-24">
            <button type="submit" class="bg-blue-600 px-4 py-2 rounded font-bold hover:bg-blue-500">Filter</button>
            
            <a href="{{ route('admin.laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" 
               class="bg-yellow-500 text-black px-4 py-2 rounded font-bold hover:bg-yellow-400 ml-auto flex items-center gap-2">
               🖨️ Cetak PDF
            </a>
        </form>

        <table class="w-full text-left border border-gray-700">
            <thead class="bg-gray-800 text-yellow-500">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Pelanggan</th>
                    <th class="p-3">KWH</th>
                    <th class="p-3">Admin</th>
                    <th class="p-3 text-right">Total Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($laporan as $row)
                <tr>
                    <td class="p-3">{{ $row->tanggal_pembayaran }}</td>
                    <td class="p-3">{{ $row->pelanggan->name }} <br><span class="text-xs text-gray-500">{{ $row->pelanggan->nomor_kwh }}</span></td>
                    <td class="p-3">{{ $row->tagihan->jumlah_meter }} kWh</td>
                    <td class="p-3">Rp {{ number_format($row->biaya_admin) }}</td>
                    <td class="p-3 text-right font-bold text-green-400">Rp {{ number_format($row->total_bayar) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-6 text-center text-gray-500">Tidak ada transaksi bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>