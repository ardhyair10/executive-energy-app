<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | Executive Energy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            900: '#0f172a',
                            gold: '#d4af37',
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
            background: rgba(30, 41, 59, 0.4);
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
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <nav class="border-b border-gray-800 bg-[#0f172a]/90 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-2">
                    <a href="{{ url('/dashboard') }}" class="text-2xl font-serif font-bold text-luxury-gold tracking-wider hover:text-white transition">
                        Executive<span class="text-white">Energy</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-400 hidden md:inline">Pengaturan Akun</span>
                    <a href="{{ url('/dashboard') }}" class="text-xs border border-gray-600 px-3 py-1 rounded text-gray-300 hover:bg-gray-800 transition">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-10 max-w-6xl">
        
        <div class="mb-10">
            <h1 class="text-3xl font-serif text-white mb-2">Profile & Security</h1>
            <p class="text-gray-500">Kelola informasi pribadi, alamat, dan keamanan akun Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="glass-panel p-8 rounded-2xl shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-luxury-gold"></div>
                
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-luxury-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Profil
                </h2>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full input-luxury rounded-lg px-4 py-3">
                        @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full input-luxury rounded-lg px-4 py-3">
                        @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if($user->role == 'pelanggan')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nomor KWH</label>
                            <input type="text" value="{{ $user->nomor_kwh }}" readonly class="w-full bg-[#0b0f19] border border-gray-800 text-gray-500 rounded-lg px-4 py-3 cursor-not-allowed" title="Hubungi Admin untuk ubah No KWH">
                        </div>
                        <div>
                             <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Saldo (E-Wallet)</label>
                             <div class="w-full bg-[#0b0f19] border border-luxury-gold/30 text-luxury-gold font-mono rounded-lg px-4 py-3">
                                Rp {{ number_format($user->saldo, 0, ',', '.') }}
                             </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Pemasangan</label>
                        <textarea name="alamat" rows="3" class="w-full input-luxury rounded-lg px-4 py-3">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-luxury-gold hover:bg-yellow-600 text-black font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-400"
                            >Tersimpan.</p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="glass-panel p-8 rounded-2xl shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-1 h-full bg-blue-500"></div>
                
                <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Ganti Password
                </h2>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" autocomplete="current-password" class="w-full input-luxury rounded-lg px-4 py-3">
                        @error('current_password', 'updatePassword') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Password Baru</label>
                        <input type="password" name="password" autocomplete="new-password" class="w-full input-luxury rounded-lg px-4 py-3">
                        @error('password', 'updatePassword') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full input-luxury rounded-lg px-4 py-3">
                        @error('password_confirmation', 'updatePassword') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                            Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-green-400">Password berhasil diubah.</p>
                        @endif
                    </div>
                </form>
            </div>

        </div>

        <div class="mt-8 border border-red-900/30 bg-red-900/10 p-6 rounded-2xl">
            <h3 class="text-red-500 font-bold mb-2">Danger Zone</h3>
            <p class="text-gray-400 text-sm mb-4">Setelah akun dihapus, semua data (Riwayat Tagihan, Penggunaan) akan hilang permanen.</p>
            
            <form method="post" action="{{ route('profile.destroy') }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen? Data tidak bisa dikembalikan.')">
                @csrf
                @method('delete')
                <div class="flex gap-4 items-center">
                    <input type="password" name="password" placeholder="Masukkan Password Anda" class="input-luxury text-sm px-3 py-2 rounded w-64" required>
                    <button type="submit" class="text-red-500 text-sm hover:text-red-400 font-bold underline">Hapus Akun Saya</button>
                </div>
                @error('password', 'userDeletion') <span class="text-red-400 text-xs mt-2 block">{{ $message }}</span> @enderror
            </form>
        </div>

    </main>

    <footer class="mt-auto border-t border-gray-800 py-6 text-center text-gray-600 text-sm">
        &copy; {{ date('Y') }} Executive Energy System.
    </footer>

</body>
</html>