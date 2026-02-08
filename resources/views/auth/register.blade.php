<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Executive Energy</title>
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
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center relative overflow-hidden py-10">

    <div class="absolute top-0 right-1/4 w-96 h-96 bg-luxury-gold/10 rounded-full blur-3xl -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-900/20 rounded-full blur-3xl translate-y-1/2"></div>

    <div class="w-full max-w-md p-8 glass-panel rounded-2xl shadow-2xl relative z-10 border-t border-gray-700/50">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-luxury-gold to-transparent"></div>

        <div class="text-center mb-6">
            <h1 class="font-serif text-2xl font-bold text-white tracking-wide">
                Join <span class="text-luxury-gold">Executive</span>
            </h1>
            <p class="text-gray-500 text-xs mt-1 uppercase tracking-widest">Registrasi Pelanggan Baru</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/30 border border-red-800/50 rounded-lg text-red-200 text-xs">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="Contoh: Budi Santoso">
            </div>

            <div>
                <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="email@contoh.com">
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Nomor KWH (Meteran)</label>
                    <input type="number" name="nomor_kwh" value="{{ old('nomor_kwh') }}" required
                        class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                        placeholder="1122334455">
                </div>
                <div>
                    <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Alamat Pemasangan</label>
                    <textarea name="alamat" required rows="2"
                        class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                        placeholder="Jl. Mawar No 10, Jakarta">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="Minimal 8 karakter">
            </div>

            <div>
                <label class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="Ulangi password">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-black font-bold py-3 px-4 rounded-lg shadow-lg transform transition hover:-translate-y-1 hover:shadow-yellow-500/20 tracking-wide uppercase text-sm mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-luxury-gold hover:text-white font-bold transition duration-200">
                    Login di sini
                </a>
            </p>
        </div>
    </div>

</body>
</html>