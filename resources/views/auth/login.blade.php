<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Executive Energy</title>
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
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute top-0 left-1/4 w-96 h-96 bg-luxury-gold/10 rounded-full blur-3xl -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl translate-y-1/2"></div>

    <div class="w-full max-w-md p-8 glass-panel rounded-2xl shadow-2xl relative z-10 border-t border-gray-700/50">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-luxury-gold to-transparent"></div>

        <div class="text-center mb-8">
            <h1 class="font-serif text-3xl font-bold text-white tracking-wide">
                Executive<span class="text-luxury-gold">Energy</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2 tracking-widest uppercase">Secure Access Portal</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/30 border border-red-800/50 rounded-lg text-red-200 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="name@executive.com">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-luxury-gold uppercase tracking-wider mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full input-luxury rounded-lg px-4 py-3 placeholder-gray-600 focus:text-white"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-700 bg-luxury-900 text-luxury-gold shadow-sm focus:ring-luxury-gold" name="remember">
                    <span class="ml-2 text-sm text-gray-400">Remember me</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-500 hover:text-luxury-gold transition duration-200" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-black font-bold py-3 px-4 rounded-lg shadow-lg transform transition hover:-translate-y-1 hover:shadow-yellow-500/20 tracking-wide uppercase text-sm">
                Sign In to Dashboard
            </button>
        </form>

        <div class="mt-6 text-center pt-4 border-t border-gray-700/50">
            <p class="text-sm text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-luxury-gold hover:text-white font-bold transition duration-200 tracking-wide ml-1">
                    Create Account
                </a>
            </p>
        </div>

        <div class="mt-6 text-center text-xs text-gray-600">
            &copy; {{ date('Y') }} Executive Energy System.
        </div>
    </div>

</body>
</html>