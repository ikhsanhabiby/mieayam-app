<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Code Meja - Mie Ayam Kita</title>
    
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .page-container {
                padding: 0 !important;
                max-width: 100% !important;
            }
            .kartu-qr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                box-shadow: none !important;
                border: 2px dashed #94a3b8 !important;
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen p-4 sm:p-6 selection:bg-brand-500 selection:text-white">

    <!-- TOP CONTROL BAR (Disembunyikan saat cetak) -->
    <div class="no-print max-w-5xl mx-auto mb-8 bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a 
                href="/admin/meja" 
                class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition active:scale-95"
                title="Kembali ke Kelola Meja"
            >
                <span class="material-icons-round text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="font-extrabold text-base text-slate-900 leading-tight">Cetak QR Code Meja</h1>
                <p class="text-xs text-slate-400">Siap cetak di kertas A4 / Sticker Stand Meja</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button 
                onclick="window.print()" 
                class="w-full sm:w-auto bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-extrabold text-xs px-6 py-3 rounded-2xl shadow-md transition-all flex items-center justify-center gap-2"
            >
                <span class="material-icons-round text-base text-brand-400">print</span>
                <span>Cetak Lembar QR</span>
            </button>
        </div>
    </div>

    <!-- PETUNJUK (Disembunyikan saat cetak) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-amber-50 border border-amber-200/80 rounded-2xl p-4 flex items-start gap-3">
        <span class="material-icons-round text-brand-600 text-lg shrink-0 mt-0.5">tips_and_updates</span>
        <p class="text-xs text-amber-900 leading-relaxed font-medium">
            <strong>Tips Percetakan:</strong> Klik tombol <strong>Cetak Lembar QR</strong> di atas. Gunting sesuai garis putus-putus dan tempelkan pada akrilik meja (Table Tent) atau meja makan agar pelanggan dapat langsung memesan secara mandiri.
        </p>
    </div>

    <!-- GRID STAND KARTU QR -->
    <div class="max-w-5xl mx-auto page-container">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($mejas as $m)
                <div class="kartu-qr bg-white rounded-3xl p-6 border-2 border-dashed border-slate-300 shadow-sm flex flex-col items-center text-center relative overflow-hidden">
                    
                    <!-- Header Kartu -->
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-400 flex items-center justify-center text-white shadow-md shadow-brand-500/20 mb-2">
                        <span class="material-icons-round text-2xl">ramen_dining</span>
                    </div>

                    <h2 class="text-base font-black text-slate-900 tracking-tight leading-tight">Mie Ayam Kita</h2>
                    <span class="text-[9px] font-extrabold text-brand-700 uppercase tracking-widest block mb-4">Self-Service Dining</span>

                    <!-- Badge Nomor Meja -->
                    <div class="w-full bg-slate-900 text-white rounded-2xl py-2 px-4 mb-4 shadow-sm">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block">Nomor Meja</span>
                        <span class="text-xl font-black text-amber-400 leading-none">MEJA {{ $m->nomor_meja }}</span>
                    </div>

                    <!-- QR Code Frame -->
                    <div class="p-3 bg-white border-2 border-slate-900 rounded-2xl shadow-inner mb-3">
                        {!! QrCode::size(170)->generate(url('/pesan?meja=' . $m->nomor_meja)) !!}
                    </div>

                    <p class="text-xs font-black text-slate-900 uppercase tracking-wider">
                        Scan untuk Memesan
                    </p>
                    <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">
                        Buka kamera HP atau aplikasi scanner untuk melihat menu & bayar.
                    </p>

                    <!-- Steps Icon -->
                    <div class="w-full mt-4 pt-3 border-t border-slate-100 flex items-center justify-around text-[9px] font-bold text-slate-500">
                        <div class="flex flex-col items-center">
                            <span class="material-icons-round text-sm text-brand-600">qr_code_scanner</span>
                            <span>1. Scan QR</span>
                        </div>
                        <span class="text-slate-300">➔</span>
                        <div class="flex flex-col items-center">
                            <span class="material-icons-round text-sm text-brand-600">touch_app</span>
                            <span>2. Pilih Menu</span>
                        </div>
                        <span class="text-slate-300">➔</span>
                        <div class="flex flex-col items-center">
                            <span class="material-icons-round text-sm text-brand-600">soup_kitchen</span>
                            <span>3. Disajikan</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-slate-200 p-8">
                    <span class="material-icons-round text-5xl text-slate-300 block mb-2">table_restaurant</span>
                    <h3 class="font-extrabold text-base text-slate-900">Belum Ada Meja</h3>
                    <p class="text-xs text-slate-400 mt-1">Daftarkan nomor meja di menu Kelola Meja terlebih dahulu.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>