<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Mie Ayam Kita</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            dark: '#1e1b18'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 text-slate-100 flex items-center justify-center p-4 selection:bg-brand-500 selection:text-white">

    <div class="w-full max-w-md">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-3xl bg-gradient-to-tr from-brand-600 to-brand-400 items-center justify-center text-white shadow-xl shadow-brand-500/20 mb-3">
                <span class="material-icons-round text-3xl">restaurant_menu</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Mie Ayam Kita</h1>
            <p class="text-xs font-medium text-slate-400 mt-1">Portal Manajemen Dapur & Restoran</p>
        </div>

        <!-- Card Login -->
        <div class="bg-slate-900/90 border border-slate-800 backdrop-blur-xl rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/50">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                <div>
                    <h2 class="text-base font-bold text-white">Masuk Administrator</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Gunakan akun admin terdaftar</p>
                </div>
                <span class="w-8 h-8 rounded-xl bg-slate-800 text-brand-400 flex items-center justify-center">
                    <span class="material-icons-round text-lg">lock</span>
                </span>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="mb-5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2.5">
                    <span class="material-icons-round text-emerald-400 text-lg shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 bg-rose-500/10 border border-rose-500/20 text-rose-300 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2.5">
                    <span class="material-icons-round text-rose-400 text-lg shrink-0">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 bg-rose-500/10 border border-rose-500/20 text-rose-300 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2.5">
                    <span class="material-icons-round text-rose-400 text-lg shrink-0">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Email Admin
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <span class="material-icons-round text-lg">email</span>
                        </div>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            placeholder="admin@mieayam.com"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 rounded-2xl pl-10 pr-4 py-3 text-xs text-white placeholder-slate-500 outline-none transition-all font-medium"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <span class="material-icons-round text-lg">key</span>
                        </div>
                        <input 
                            type="password" 
                            id="passInput"
                            name="password" 
                            required 
                            placeholder="••••••••"
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 rounded-2xl pl-10 pr-10 py-3 text-xs text-white placeholder-slate-500 outline-none transition-all font-medium"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 transition"
                        >
                            <span class="material-icons-round text-lg" id="passIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 active:scale-95 text-slate-950 font-extrabold text-xs py-3.5 rounded-2xl shadow-lg shadow-brand-500/25 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Masuk ke Dashboard</span>
                        <span class="material-icons-round text-base">arrow_forward</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-4 border-t border-slate-800/80 text-center">
                <a href="/pesan" class="text-[11px] font-semibold text-slate-400 hover:text-brand-400 transition flex items-center justify-center gap-1">
                    <span class="material-icons-round text-sm">arrow_back</span>
                    <span>Kembali ke Halaman Pelanggan</span>
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            let passInput = document.getElementById('passInput');
            let passIcon = document.getElementById('passIcon');
            if(passInput) {
                if(passInput.type === 'password') {
                    passInput.type = 'text';
                    passIcon.innerText = 'visibility_off';
                } else {
                    passInput.type = 'password';
                    passIcon.innerText = 'visibility';
                }
            }
        }
    </script>
</body>
</html>