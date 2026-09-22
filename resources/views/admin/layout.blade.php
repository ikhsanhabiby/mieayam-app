<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Mie Ayam Kita</title>
    
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
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }
        .nav-active {
            background-color: #1e1b18 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(30, 27, 24, 0.15);
        }
    </style>
    @yield('styles')
</head>
<body class="text-slate-800 antialiased bg-slate-100 min-h-screen flex flex-col selection:bg-brand-500 selection:text-white">

    <!-- TOP NAVBAR -->
    <nav class="bg-white border-b border-slate-200/80 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="/admin" class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-400 flex items-center justify-center text-white shadow-md shadow-brand-500/20">
                            <span class="material-icons-round text-2xl">restaurant_menu</span>
                        </div>
                        <div>
                            <span class="font-extrabold text-base text-slate-900 tracking-tight block leading-tight">Mie Ayam Kita</span>
                            <span class="text-[10px] font-bold text-brand-700 uppercase tracking-wider block">Admin & Kitchen</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-1.5 bg-slate-100 p-1 rounded-2xl border border-slate-200/60">
                    <a 
                        href="/admin" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->is('admin') ? 'nav-active' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}"
                    >
                        <span class="material-icons-round text-base">soup_kitchen</span>
                        <span>Pesanan Dapur</span>
                    </a>

                    <a 
                        href="/admin/pembayaran" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 relative {{ request()->is('admin/pembayaran*') ? 'nav-active' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}"
                    >
                        <span class="material-icons-round text-base">payments</span>
                        <span>Konfirmasi Kasir</span>
                        <span id="navCashBadge" class="hidden ml-1 px-1.5 py-0.5 text-[10px] font-black rounded-full bg-rose-500 text-white animate-pulse">0</span>
                    </a>
                    
                    <a 
                        href="/admin/menu" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->is('admin/menu*') ? 'nav-active' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}"
                    >
                        <span class="material-icons-round text-base">fastfood</span>
                        <span>Kelola Menu</span>
                    </a>
                    
                    <a 
                        href="/admin/meja" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->is('admin/meja*') ? 'nav-active' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}"
                    >
                        <span class="material-icons-round text-base">table_restaurant</span>
                        <span>Kelola Meja</span>
                    </a>

                    <a 
                        href="/admin/cetak-qr" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->is('admin/cetak-qr*') ? 'nav-active' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80' }}"
                    >
                        <span class="material-icons-round text-base">qr_code_2</span>
                        <span>Cetak QR</span>
                    </a>
                </div>

                <!-- Actions (View Store, Refresh, Logout) -->
                <div class="flex items-center gap-2">
                    <a 
                        href="/pesan?meja=1" 
                        target="_blank"
                        title="Buka Halaman Customer"
                        class="hidden sm:flex items-center gap-1 bg-brand-50 hover:bg-brand-100 text-brand-800 text-xs font-bold px-3 py-2 rounded-xl border border-brand-200/80 transition"
                    >
                        <span class="material-icons-round text-sm">open_in_new</span>
                        <span>Lihat Menu Pelanggan</span>
                    </a>

                    <button 
                        onclick="window.location.reload()" 
                        title="Segarkan Data"
                        class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition active:scale-95"
                    >
                        <span class="material-icons-round text-lg">refresh</span>
                    </button>

                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button 
                            type="submit" 
                            title="Keluar Akun"
                            class="bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold px-3 py-2 rounded-xl border border-rose-200/80 transition flex items-center gap-1 active:scale-95"
                        >
                            <span class="material-icons-round text-sm">logout</span>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <!-- MOBILE SUB NAV -->
    <div class="md:hidden bg-white border-b border-slate-200 px-4 py-2 flex items-center gap-2 overflow-x-auto">
        <a href="/admin" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ request()->is('admin') ? 'nav-active' : 'bg-slate-100 text-slate-600' }}">
            Dapur
        </a>
        <a href="/admin/pembayaran" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap flex items-center gap-1 {{ request()->is('admin/pembayaran*') ? 'nav-active' : 'bg-slate-100 text-slate-600' }}">
            <span>Kasir (Cash)</span>
            <span id="navMobileCashBadge" class="hidden px-1.5 py-0.2 text-[9px] font-black rounded-full bg-rose-500 text-white">0</span>
        </a>
        <a href="/admin/menu" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ request()->is('admin/menu*') ? 'nav-active' : 'bg-slate-100 text-slate-600' }}">
            Menu
        </a>
        <a href="/admin/meja" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ request()->is('admin/meja*') ? 'nav-active' : 'bg-slate-100 text-slate-600' }}">
            Meja
        </a>
        <a href="/admin/cetak-qr" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ request()->is('admin/cetak-qr*') ? 'nav-active' : 'bg-slate-100 text-slate-600' }}">
            Cetak QR
        </a>
    </div>

    <!-- MAIN CONTAINER -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                <span class="material-icons-round text-emerald-600 text-lg">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                <span class="material-icons-round text-rose-600 text-lg">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl text-xs font-bold shadow-xs">
                <div class="flex items-center gap-2 mb-1">
                    <span class="material-icons-round text-rose-600 text-lg">warning</span>
                    <span>Terdapat beberapa kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 ml-6 font-normal">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200/80 py-4 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Mie Ayam Kita — Sistem Restoran Self-Service Modern</p>
    </footer>

    <!-- REAL-TIME BADGE POLLING SCRIPT -->
    <script>
        function checkPendingCash() {
            fetch('/admin/api/pending-cash')
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById('navCashBadge');
                    const mBadge = document.getElementById('navMobileCashBadge');
                    if (data.count > 0) {
                        if (badge) {
                            badge.innerText = data.count;
                            badge.classList.remove('hidden');
                        }
                        if (mBadge) {
                            mBadge.innerText = data.count;
                            mBadge.classList.remove('hidden');
                        }
                    } else {
                        if (badge) badge.classList.add('hidden');
                        if (mBadge) mBadge.classList.add('hidden');
                    }
                })
                .catch(() => {});
        }

        // Run immediately and every 7 seconds
        checkPendingCash();
        setInterval(checkPendingCash, 7000);
    </script>

    @yield('scripts')
</body>
</html>
