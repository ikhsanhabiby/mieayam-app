<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Status Pesanan #{{ $order->id }} - Mie Ayam Kita</title>
    
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
        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 1; }
        }
        .animate-glow {
            animation: pulseGlow 2s infinite ease-in-out;
        }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-100 min-h-screen flex justify-center selection:bg-brand-500 selection:text-white">

    <div class="w-full max-w-md bg-white min-h-screen relative shadow-2xl flex flex-col border-x border-slate-200/70">
        
        <!-- TOP APP BAR -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 px-5 pt-4 pb-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-50 border border-brand-200/80 flex items-center justify-center text-brand-700">
                    <span class="material-icons-round text-2xl">soup_kitchen</span>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 leading-tight">Live Status Pesanan</h1>
                    <p class="text-[11px] font-semibold text-slate-400">Update otomatis real-time</p>
                </div>
            </div>

            <!-- Badge Meja & Order ID -->
            <div class="text-right">
                <span class="inline-block bg-brand-500 text-white font-extrabold px-2.5 py-0.5 rounded-full text-xs shadow-xs">
                    Meja {{ $order->nomor_meja }}
                </span>
                <span class="block text-[10px] font-bold text-slate-400 mt-0.5">Order #{{ $order->id }}</span>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="flex-1 px-5 pt-5 pb-8 flex flex-col justify-between overflow-y-auto">
            
            <div>
                <!-- STEPPER PROGRESS BAR -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/70 mb-6">
                    <div class="flex items-center justify-between relative">
                        <!-- Connecting line -->
                        <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-1 bg-slate-200 -z-0">
                            <div id="progressBar" class="h-full bg-brand-500 transition-all duration-700 w-1/2"></div>
                        </div>

                        <!-- Step 1: Dipesan -->
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                <span class="material-icons-round text-sm">check</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 mt-1">Diterima</span>
                        </div>

                        <!-- Step 2: Dimasak -->
                        <div class="flex flex-col items-center relative z-10" id="stepDimasak">
                            <div class="step-icon-2 w-8 h-8 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-bold shadow-md shadow-brand-500/20 animate-pulse">
                                <span class="material-icons-round text-sm">outdoor_grill</span>
                            </div>
                            <span class="text-[10px] font-extrabold text-brand-700 mt-1">Dimasak</span>
                        </div>

                        <!-- Step 3: Siap -->
                        <div class="flex flex-col items-center relative z-10" id="stepSiap">
                            <div class="step-icon-3 w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-xs font-bold transition-all">
                                <span class="material-icons-round text-sm">room_service</span>
                            </div>
                            <span class="step-text-3 text-[10px] font-bold text-slate-400 mt-1">Siap</span>
                        </div>
                    </div>
                </div>

                <!-- STATE 1: SEDANG DIMASAK -->
                <div id="statusDimasak" class="text-center py-6">
                    <div class="relative w-36 h-36 mx-auto mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-brand-100/60 animate-glow"></div>
                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-brand-500 to-amber-400 flex items-center justify-center text-white shadow-xl shadow-brand-500/25 relative z-10">
                            <span class="material-icons-round text-5xl animate-bounce">ramen_dining</span>
                        </div>
                    </div>

                    <div class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-200 text-amber-800 px-3 py-1 rounded-full text-xs font-bold mb-3">
                        <span class="w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                        <span>Pesanan Sedang Dimasak</span>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-900 leading-tight">Harap Tunggu Sebentar</h2>
                    <p class="text-xs text-slate-500 mt-1.5 max-w-[280px] mx-auto leading-relaxed">
                        Koki kami sedang meracik mie ayam hangat dan menyiapkan pesanan terbaik untuk 
                        <span class="font-extrabold text-slate-800">Meja {{ $order->nomor_meja }}</span>.
                    </p>
                </div>

                <!-- STATE 2: PESANAN SIAP (Hidden by default) -->
                <div id="statusSiap" class="hidden text-center py-6">
                    <div class="relative w-36 h-36 mx-auto mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-emerald-100 animate-ping opacity-75"></div>
                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-xl shadow-emerald-500/25 relative z-10">
                            <span class="material-icons-round text-6xl">done_all</span>
                        </div>
                    </div>

                    <div class="inline-flex items-center gap-1.5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold mb-3">
                        <span class="material-icons-round text-sm text-emerald-600">check_circle</span>
                        <span>Pesanan Sudah Selesai!</span>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-900 leading-tight">Pesanan Siap Disajikan! 🎉</h2>
                    <p class="text-xs text-slate-500 mt-1.5 max-w-[280px] mx-auto leading-relaxed">
                        Hore! Makanan untuk <span class="font-extrabold text-slate-800">Meja {{ $order->nomor_meja }}</span> sudah siap dinikmati. Selamat makan!
                    </p>
                </div>

                <!-- RINCIAN PESANAN KARTU -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/70 mt-2">
                    <div class="flex items-center justify-between border-b border-slate-200/70 pb-2.5 mb-2.5">
                        <span class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">Item Dipesan</span>
                        <span class="text-[10px] font-bold text-slate-500 bg-white border border-slate-200 px-2 py-0.5 rounded-md uppercase">
                            {{ $order->metode_pembayaran ?? 'Belum Dibayar' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-700 font-semibold leading-relaxed">
                        {{ $order->menu_pesanan }}
                    </p>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="pt-6">
                <a 
                    href="/pesan?meja={{ $order->nomor_meja }}" 
                    class="w-full bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-bold text-xs py-3.5 rounded-2xl shadow-lg shadow-slate-900/10 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <span class="material-icons-round text-base">restaurant_menu</span>
                    <span>Pesan Menu Lain / Kembali</span>
                </a>
            </div>

        </main>

    </div>

    <!-- SCRIPT POLLING STATUS -->
    <script>
        let isDone = false;
        const soundUrl = "{{ asset('audio/ting.wav') }}";

        function playAlertSound() {
            try {
                let audio = new Audio(soundUrl);
                audio.play().catch(e => {
                    // Fallback to online sample if local file error
                    let fallbackAudio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                    fallbackAudio.play().catch(() => {});
                });
            } catch (err) {
                console.log('Audio notification error', err);
            }
        }

        // Cek status setiap 3 detik
        const intervalId = setInterval(function() {
            if (isDone) return;

            fetch('/cek-status/{{ $order->id }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'siap') {
                        isDone = true;
                        clearInterval(intervalId);

                        // Update Stepper
                        let progressBar = document.getElementById('progressBar');
                        if (progressBar) progressBar.classList.remove('w-1/2'), progressBar.classList.add('w-full'), progressBar.classList.remove('bg-brand-500'), progressBar.classList.add('bg-emerald-500');

                        let stepIcon2 = document.querySelector('.step-icon-2');
                        if (stepIcon2) {
                            stepIcon2.classList.remove('bg-brand-500', 'animate-pulse');
                            stepIcon2.classList.add('bg-emerald-500');
                            stepIcon2.innerHTML = '<span class="material-icons-round text-sm">check</span>';
                        }

                        let stepIcon3 = document.querySelector('.step-icon-3');
                        if (stepIcon3) {
                            stepIcon3.classList.remove('bg-slate-200', 'text-slate-400');
                            stepIcon3.classList.add('bg-emerald-500', 'text-white', 'shadow-md', 'shadow-emerald-500/20');
                        }

                        let stepText3 = document.querySelector('.step-text-3');
                        if (stepText3) {
                            stepText3.classList.remove('text-slate-400');
                            stepText3.classList.add('text-emerald-700', 'font-extrabold');
                        }

                        // Sembunyikan layar masak, tampilkan layar siap
                        let statusDimasak = document.getElementById('statusDimasak');
                        let statusSiap = document.getElementById('statusSiap');
                        if(statusDimasak) statusDimasak.classList.add('hidden');
                        if(statusSiap) statusSiap.classList.remove('hidden');

                        // Bunyikan suara
                        playAlertSound();
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }, 3000);
    </script>
</body>
</html>