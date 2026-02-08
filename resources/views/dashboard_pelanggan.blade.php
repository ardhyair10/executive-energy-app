<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan | Executive Energy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            900: '#0f172a',
                            800: '#1e293b',
                            gold: '#d4af37',
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
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
    </style>
</head>
<body class="antialiased h-screen flex overflow-hidden">

    <aside class="w-64 bg-luxury-900 border-r border-gray-800 hidden md:flex flex-col">
        <div class="h-20 flex items-center px-8 border-b border-gray-800">
            <span class="text-xl font-serif font-bold text-luxury-gold tracking-wider">Executive<span class="text-white">Energy</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-luxury-gold/10 text-luxury-gold rounded-lg border border-luxury-gold/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-bold">Dashboard</span>
            </a>
            
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Edit Profile</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Bantuan & Support</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-red-400 hover:text-red-300 transition text-sm w-full px-4 py-2 rounded hover:bg-red-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto no-scrollbar relative">
        
        <header class="h-20 bg-luxury-900/80 backdrop-blur-md sticky top-0 z-40 px-8 flex items-center justify-between border-b border-gray-800">
            <div class="md:hidden text-luxury-gold font-serif font-bold text-xl">Executive Energy</div>
            
            <div class="flex-1 hidden md:block">
                <h1 class="text-xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
                <p class="text-xs text-gray-500">ID Pelanggan: <span class="font-mono text-luxury-gold">{{ Auth::user()->nomor_kwh ?? 'N/A' }}</span></p>
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-r from-luxury-gold to-yellow-600 px-4 py-2 rounded-lg shadow-lg text-black font-bold text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}
                </div>
            </div>
        </header>

        <div class="p-8 space-y-8">

            @if(session('success'))
                <div class="bg-green-900/30 border border-green-700 text-green-200 p-4 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-bold">Total Pemakaian</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $total_kwh }} <span class="text-sm text-gray-500 font-normal">kWh</span></h3>
                    <div class="mt-4 h-1 w-full bg-gray-700 rounded-full"><div class="h-1 bg-blue-500 rounded-full" style="width: 70%"></div></div>
                </div>

                <div class="glass-panel p-6 rounded-2xl relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-bold">Tagihan Belum Bayar</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $tagihan_pending }} <span class="text-sm text-gray-500 font-normal">Bulan</span></h3>
                    <div class="mt-4 h-1 w-full bg-gray-700 rounded-full">
                        <div class="h-1 {{ $tagihan_pending > 0 ? 'bg-red-500' : 'bg-green-500' }} rounded-full" style="width: {{ $tagihan_pending > 0 ? '100%' : '0%' }}"></div>
                    </div>
                </div>

                <div class="glass-panel p-6 rounded-2xl relative overflow-hidden bg-gradient-to-br from-luxury-gold/20 to-transparent border-luxury-gold/20">
                    <p class="text-luxury-gold text-xs uppercase tracking-widest font-bold">Status Layanan</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="relative flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>
                        </span>
                        <h3 class="text-2xl font-bold text-white">Aktif</h3>
                    </div>
                    <p class="text-xs text-gray-400 mt-4">Jaringan stabil & aman.</p>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-2xl">
                <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Statistik Penggunaan Listrik (6 Bulan Terakhir)
                </h3>
                <div class="h-64 w-full">
                    <canvas id="usageChart"></canvas>
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-6 overflow-hidden">
                <h3 class="text-white font-bold mb-6">Riwayat Tagihan & Pembayaran</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-luxury-800 text-luxury-gold uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Periode</th>
                                <th class="px-6 py-4">Meteran (Awal - Akhir)</th>
                                <th class="px-6 py-4">Pemakaian</th>
                                <th class="px-6 py-4 text-center rounded-tr-lg">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800 text-sm">
                            @forelse($tagihan as $t)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 font-medium text-white">{{ $t->bulan }} {{ $t->tahun }}</td>
                                <td class="px-6 py-4 text-gray-400 font-mono">{{ $t->penggunaan->meter_awal }} - {{ $t->penggunaan->meter_akhir }}</td>
                                <td class="px-6 py-4 text-white font-bold">{{ $t->jumlah_meter }} kWh</td>
                                <td class="px-6 py-4 text-center">
                                    @if($t->status == 'Belum Bayar')
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-900/30 text-red-400 border border-red-800">Unpaid</span>
                                            <form action="{{ route('pelanggan.bayar', $t->id_tagihan) }}" method="POST" onsubmit="return confirm('Bayar tagihan ini dengan saldo Anda?')">
                                                @csrf
                                                <button class="bg-luxury-gold hover:bg-yellow-500 text-black px-3 py-1 rounded text-xs font-bold shadow-lg transition transform hover:scale-105">
                                                    ⚡ Bayar Kilat
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-900/30 text-green-400 border border-green-800">Paid</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        const ctx = document.getElementById('usageChart').getContext('2d');
        
        // Data dari Controller Laravel
        const labels = @json($chart_bulan); 
        const data = @json($chart_kwh);

        // Bikin Gradient Warna Emas buat Grafik
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(212, 175, 55, 0.5)'); // Emas terang
        gradient.addColorStop(1, 'rgba(212, 175, 55, 0.0)'); // Transparan

        new Chart(ctx, {
            type: 'line', // Bisa ganti 'bar' kalau mau batang
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pemakaian (kWh)',
                    data: data,
                    borderColor: '#d4af37', // Garis Emas
                    backgroundColor: gradient, // Isi gradient
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#d4af37',
                    fill: true,
                    tension: 0.4 // Garis melengkung halus
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Sembunyikan legenda biar bersih
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                }
            }
        });
    </script>
</body>
</html>