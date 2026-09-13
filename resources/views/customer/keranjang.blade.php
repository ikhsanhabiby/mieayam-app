<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Keranjang Pesanan - Mie Ayam Kita</title>
    
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
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-100 min-h-screen flex justify-center selection:bg-brand-500 selection:text-white">

    <div class="w-full max-w-md bg-white min-h-screen relative shadow-2xl flex flex-col border-x border-slate-200/70">
        
        <!-- TOP APP BAR -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 px-5 pt-4 pb-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a 
                    href="/pesan?meja={{ $meja }}" 
                    class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 active:scale-95 flex items-center justify-center text-slate-700 transition-all"
                    aria-label="Kembali ke Menu"
                >
                    <span class="material-icons-round text-xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 leading-tight">Keranjang Pesanan</h1>
                    <p class="text-[11px] font-semibold text-slate-400">Review pesanan sebelum checkout</p>
                </div>
            </div>

            <!-- Badge Meja -->
            <div class="flex items-center gap-1.5 bg-brand-50 border border-brand-200/80 px-3 py-1.5 rounded-full shadow-sm">
                <span class="material-icons-round text-brand-700 text-sm">table_restaurant</span>
                <span class="text-xs font-bold text-brand-900">Meja {{ $meja }}</span>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="flex-1 px-4 pt-4 pb-36 overflow-y-auto">
            
            @if(session('error'))
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
                <span class="material-icons-round text-base">error_outline</span>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if(count($cart) > 0)
                <!-- List Items -->
                <div class="space-y-3">
                    @php 
                        $totalSemua = 0; 
                        $totalItemCount = 0;
                    @endphp

                    @foreach($cart as $id => $item)
                        @php 
                            $porsi = (int)($item['jumlah'] ?? 1);
                            $subtotal = (int)$item['harga'] * $porsi; 
                            $totalSemua += $subtotal; 
                            $totalItemCount += $porsi;
                        @endphp
                        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex items-center justify-between gap-3 hover:border-brand-200 transition-all">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-50 to-amber-100 border border-brand-200/60 flex items-center justify-center text-brand-700 shrink-0 font-black text-sm shadow-xs">
                                    {{ $porsi }}x
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-extrabold text-xs text-slate-900 truncate leading-snug">{{ $item['nama'] }}</h3>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">
                                        @ Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs font-black text-brand-700 mt-1">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Porsi Control (+ / -) & Hapus -->
                            <div class="flex items-center gap-2 shrink-0">
                                <div class="flex items-center bg-slate-50 rounded-xl p-1 border border-slate-200/70 shadow-xs">
                                    <form action="/keranjang/ubah-jumlah" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="menu" value="{{ $item['nama'] }}">
                                        <input type="hidden" name="delta" value="-1">
                                        <button 
                                            type="submit" 
                                            title="Kurangi 1 Porsi"
                                            class="w-6 h-6 rounded-lg bg-white shadow-xs border border-slate-200/70 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 active:scale-95 transition"
                                        >
                                            <span class="material-icons-round text-xs">remove</span>
                                        </button>
                                    </form>

                                    <span class="w-7 text-center font-extrabold text-xs text-slate-900">{{ $porsi }}</span>

                                    <form action="/keranjang/ubah-jumlah" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="menu" value="{{ $item['nama'] }}">
                                        <input type="hidden" name="delta" value="1">
                                        <button 
                                            type="submit" 
                                            title="Tambah 1 Porsi"
                                            class="w-6 h-6 rounded-lg bg-white shadow-xs border border-slate-200/70 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 active:scale-95 transition"
                                        >
                                            <span class="material-icons-round text-xs">add</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Tombol Hapus -->
                                <a 
                                    href="/keranjang/hapus/{{ urlencode($item['nama']) }}" 
                                    onclick="return confirm('Hapus {{ addslashes($item['nama']) }} dari keranjang?')"
                                    class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-500 hover:text-rose-600 flex items-center justify-center active:scale-95 transition-all shrink-0"
                                    title="Hapus semua porsi menu ini"
                                >
                                    <span class="material-icons-round text-base">delete_outline</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Ringkasan Pembayaran (Receipt Card) -->
                <div class="mt-6 bg-slate-50 rounded-2xl p-4 border border-slate-200/80">
                    <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <span class="material-icons-round text-brand-600 text-base">receipt</span>
                        Rincian Tagihan
                    </h4>

                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Jumlah Porsi</span>
                            <span class="font-bold text-slate-900">{{ $totalItemCount }} item</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal Menu</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Layanan & Meja</span>
                            <span class="font-bold text-emerald-600">GRATIS</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200/80 flex justify-between items-center text-sm font-extrabold text-slate-900">
                            <span>Total Pembayaran</span>
                            <span class="text-brand-700 text-base font-black">Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tambah Menu Lagi CTA -->
                <div class="mt-4 text-center">
                    <a href="/pesan?meja={{ $meja }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-700 hover:text-brand-800 transition">
                        <span class="material-icons-round text-sm">add_circle_outline</span>
                        <span>Ingin tambah menu lainnya?</span>
                    </a>
                </div>

            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <div class="w-24 h-24 bg-brand-50 rounded-3xl flex items-center justify-center text-brand-500 mb-4 shadow-inner">
                        <span class="material-icons-round text-5xl">shopping_cart</span>
                    </div>
                    <h3 class="font-extrabold text-base text-slate-900">Keranjang Belanja Masih Kosong</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-[260px] leading-relaxed">
                        Yuk, pilih menu mie ayam lezat dan minuman segar favoritmu sekarang!
                    </p>
                    <a 
                        href="/pesan?meja={{ $meja }}" 
                        class="mt-6 bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-bold text-xs px-6 py-3 rounded-2xl shadow-lg shadow-slate-900/10 transition-all flex items-center gap-2"
                    >
                        <span class="material-icons-round text-base">restaurant_menu</span>
                        <span>Lihat Buku Menu</span>
                    </a>
                </div>
            @endif

        </main>

        <!-- STICKY BOTTOM CHECKOUT ACTION -->
        @if(count($cart) > 0)
        <div class="fixed bottom-0 w-full max-w-md bg-white/95 backdrop-blur-md border-t border-slate-200/80 px-5 py-4 shadow-[0_-8px_25px_rgba(0,0,0,0.06)] z-40">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-[11px] font-semibold text-slate-400 block">Total Pembayaran</span>
                    <span class="text-lg font-black text-brand-800 leading-tight">
                        Rp {{ number_format($totalSemua ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                <span class="text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                    {{ $totalItemCount ?? 0 }} Item
                </span>
            </div>

            <form action="/checkout" method="POST" class="m-0">
                @csrf
                <button 
                    type="submit" 
                    class="w-full bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-bold text-xs py-3.5 rounded-2xl shadow-lg shadow-slate-900/10 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <span>Lanjut ke Pembayaran</span>
                    <span class="material-icons-round text-base">arrow_forward</span>
                </button>
            </form>
        </div>
        @endif

    </div>

</body>
</html>