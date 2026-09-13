<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pilih Pembayaran - Mie Ayam Kita</title>
    
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
        .payment-radio:checked + .payment-card {
            border-color: #f59e0b !important;
            background-color: #fffbeb !important;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.15);
        }
        .payment-radio:checked + .payment-card .radio-indicator {
            border-color: #f59e0b;
            background-color: #f59e0b;
        }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-100 min-h-screen flex justify-center selection:bg-brand-500 selection:text-white">

    <div class="w-full max-w-md bg-white min-h-screen relative shadow-2xl flex flex-col border-x border-slate-200/70">
        
        <!-- TOP APP BAR -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 px-5 pt-4 pb-3 flex items-center justify-between">
            <div>
                <h1 class="text-base font-extrabold text-slate-900 leading-tight">Metode Pembayaran</h1>
                <p class="text-[11px] font-semibold text-slate-400">Pilih cara pembayaran yang kamu inginkan</p>
            </div>

            <!-- Badge Meja & Order ID -->
            <div class="text-right">
                <span class="inline-block bg-brand-50 border border-brand-200/80 px-2.5 py-0.5 rounded-full text-xs font-extrabold text-brand-900">
                    Meja {{ $order->nomor_meja }}
                </span>
                <span class="block text-[10px] font-bold text-slate-400 mt-0.5">Order #{{ $order->id }}</span>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="flex-1 px-4 pt-4 pb-32 overflow-y-auto">
            
            <!-- Ringkasan Pesanan Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 text-white shadow-md shadow-slate-900/10 mb-5">
                <div class="flex items-center justify-between border-b border-slate-700/60 pb-2.5 mb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="material-icons-round text-brand-400 text-lg">receipt_long</span>
                        <span class="text-xs font-bold text-slate-200 uppercase tracking-wider">Ringkasan Pesanan</span>
                    </div>
                    <span class="text-[10px] font-extrabold bg-brand-500/20 text-brand-300 border border-brand-500/30 px-2 py-0.5 rounded-md">
                        Pesanan Baru
                    </span>
                </div>

                <div class="space-y-1 text-xs">
                    <p class="text-slate-300 text-xs font-medium leading-relaxed">
                        {{ $order->menu_pesanan }}
                    </p>
                </div>
            </div>

            <!-- PILIHAN PEMBAYARAN FORM -->
            <form action="/bayar/{{ $order->id }}" method="POST" id="paymentForm">
                @csrf
                
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    Pilih Cara Bayar
                </h3>

                <div class="space-y-3">
                    
                    <!-- Pilihan 1: QRIS / E-Wallet -->
                    <label class="block cursor-pointer">
                        <input type="radio" name="metode" value="ewallet" required checked class="payment-radio hidden">
                        <div class="payment-card bg-white rounded-2xl p-4 border-2 border-slate-100 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex items-center justify-between gap-3.5 transition-all">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                    <span class="material-icons-round text-2xl">qr_code_2</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-extrabold text-xs text-slate-900">QRIS / E-Wallet</h4>
                                        <span class="bg-blue-100 text-blue-700 text-[9px] font-extrabold px-1.5 py-0.5 rounded">Instan</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Gopay, OVO, Dana, ShopeePay, BCA Mobile, dll</p>
                                </div>
                            </div>
                            
                            <div class="radio-indicator w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0 transition-colors">
                                <span class="material-icons-round text-white text-xs">check</span>
                            </div>
                        </div>
                    </label>

                    <!-- Pilihan 2: Bayar Tunai di Kasir -->
                    <label class="block cursor-pointer">
                        <input type="radio" name="metode" value="cash" required class="payment-radio hidden">
                        <div class="payment-card bg-white rounded-2xl p-4 border-2 border-slate-100 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex items-center justify-between gap-3.5 transition-all">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                    <span class="material-icons-round text-2xl">payments</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-extrabold text-xs text-slate-900">Bayar Tunai di Kasir</h4>
                                        <span class="bg-emerald-100 text-emerald-700 text-[9px] font-extrabold px-1.5 py-0.5 rounded">Cash</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Bayar langsung ke kasir setelah konfirmasi</p>
                                </div>
                            </div>
                            
                            <div class="radio-indicator w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0 transition-colors">
                                <span class="material-icons-round text-white text-xs">check</span>
                            </div>
                        </div>
                    </label>

                </div>

                <!-- Info Box -->
                <div class="mt-5 bg-amber-50/80 border border-amber-200/70 rounded-2xl p-3.5 flex items-start gap-2.5">
                    <span class="material-icons-round text-brand-600 text-lg shrink-0 mt-0.5">info</span>
                    <p class="text-[11px] text-amber-900 leading-relaxed font-medium">
                        Setelah mengonfirmasi metode pembayaran, pesanan Anda akan langsung dikirimkan ke bagian dapur untuk segera dimasak.
                    </p>
                </div>
            </form>

        </main>

        <!-- STICKY BOTTOM BUTTON -->
        <div class="fixed bottom-0 w-full max-w-md bg-white/95 backdrop-blur-md border-t border-slate-200/80 px-5 py-4 shadow-[0_-8px_25px_rgba(0,0,0,0.06)] z-40">
            <button 
                type="submit" 
                form="paymentForm"
                class="w-full bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-bold text-xs py-3.5 rounded-2xl shadow-lg shadow-slate-900/10 transition-all duration-200 flex items-center justify-center gap-2"
            >
                <span class="material-icons-round text-base text-brand-400">check_circle</span>
                <span>Konfirmasi Pembayaran</span>
            </button>
        </div>

    </div>

</body>
</html>