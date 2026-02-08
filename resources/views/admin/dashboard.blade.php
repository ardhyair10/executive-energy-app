<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Executive Energy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            900: '#0f172a', /* Dark Slate */
                            800: '#1e293b',
                            gold: '#d4af37', /* True Gold */
                            gold_hover: '#b5952f',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0b0f19; color: #e2e8f0; }
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .input-luxury {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
            transition: all 0.3s ease;
        }
        .input-luxury:focus {
            border-color: #d4af37;
            ring: 1px solid #d4af37;
            outline: none;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <nav class="border-b border-gray-800 bg-luxury-900/90 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <span class="font-serif text-2xl font-bold text-luxury-gold tracking-wider">
                        Executive<span class="text-white">Energy</span>
                    </span>
                    <span class="ml-3 text-xs uppercase tracking-widest bg-gray-800 px-2 py-1 rounded text-gray-400 border border-gray-700 hidden sm:inline-block">Admin Panel</span>
                </div>
                
                <div class="flex items-center gap-4">
                    
                    <a href="{{ route('admin.laporan') }}" class="flex items-center gap-2 text-sm font-medium text-gray-300 hover:text-luxury-gold transition border border-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="hidden md:inline">Laporan</span>
                    </a>

                    <div class="h-6 w-px bg-gray-700 mx-2"></div>

                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-300 hover:text-luxury-gold transition flex items-center gap-2 group">
                        <div class="h-8 w-8 rounded-full bg-luxury-gold flex items-center justify-center text-luxury-900 font-bold group-hover:bg-white transition">A</div>
                        <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition border border-red-900/30 px-3 py-1.5 rounded hover:bg-red-900/20" title="Keluar Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-10 max-w-7xl">
        
        <div class="mb-10 text-center">
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-2">Energy Management</h1>
            <p class="text-gray-400 font-light tracking-wide">Pencatatan Meteran & Validasi Pembayaran</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-900/30 border border-green-700 text-green-200 flex items-center gap-3 animate-pulse">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-900/30 border border-red-700 text-red-200 flex items-center gap-3">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-panel rounded-2xl p-6 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-luxury-gold to-transparent"></div>
                    
                    <h2 class="font-serif text-2xl text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Input Meteran
                    </h2>

                    <form action="{{ route('simpan.penggunaan') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-2">Pelanggan</label>
                            <select name="id_pelanggan" class="w-full input-luxury rounded-lg px-4 py-3 focus:ring-2 focus:ring-luxury-gold focus:border-transparent" required>
                                <option value="" class="bg-luxury-900 text-gray-500">Pilih Pelanggan...</option>
                                @foreach($pelanggan as $p)
                                    <option value="{{ $p->id }}" class="bg-luxury-900 text-white">
                                        {{ $p->name }} — {{ $p->nomor_kwh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bulan</label>
                                <select name="bulan" class="w-full input-luxury rounded-lg px-4 py-3">
                                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                        <option value="{{ $bulan }}" class="bg-luxury-900" {{ date('F') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tahun</label>
                                <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full input-luxury rounded-lg px-4 py-3">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Meter Awal</label>
                                <input type="number" name="meter_awal" class="w-full input-luxury rounded-lg px-4 py-3" placeholder="0000" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Meter Akhir</label>
                                <input type="number" name="meter_akhir" class="w-full input-luxury rounded-lg px-4 py-3" placeholder="0000" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-black font-bold py-3 px-4 rounded-lg shadow-lg transform transition hover:-translate-y-1 hover:shadow-yellow-500/20">
                            Simpan & Generate Tagihan
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="glass-panel rounded-2xl p-6 shadow-2xl h-full flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-serif text-2xl text-white">Daftar Tagihan</h2>
                        <span class="text-xs px-3 py-1 rounded-full border border-gray-600 text-gray-400 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-700 flex-grow">
                        <table class="w-full text-left">
                            <thead class="bg-luxury-900/50 text-luxury-gold uppercase text-xs font-bold tracking-wider border-b border-gray-700">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Pelanggan</th>
                                    <th class="px-6 py-4">Periode</th>
                                    <th class="px-6 py-4 text-center">Total (kWh)</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800 text-sm">
                                @forelse($tagihan as $t)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-mono text-gray-500">#{{ $t->id_tagihan }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $t->pelanggan->name ?? 'User Terhapus' }}</div>
                                        <div class="text-gray-500 text-xs">{{ $t->pelanggan->nomor_kwh ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-300">
                                        {{ $t->bulan }} <span class="text-gray-600">/</span> {{ $t->tahun }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-mono text-lg font-bold text-white">{{ $t->jumlah_meter }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status == 'Belum Bayar')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900/50 text-red-400 border border-red-800">Unpaid</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/50 text-green-400 border border-green-800">Paid</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status == 'Belum Bayar')
                                            <form action="{{ route('admin.bayar', $t->id_tagihan) }}" method="POST" onsubmit="return confirm('Konfirmasi: Pelanggan membayar secara tunai?')">
                                                @csrf
                                                <button type="submit" class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform transition hover:-translate-y-1 text-xs uppercase tracking-wider flex items-center gap-2 mx-auto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Bayar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-xs italic flex items-center justify-center gap-1">
                                                <svg class="w-4 h-4 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Lunas
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Belum ada data tagihan masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>