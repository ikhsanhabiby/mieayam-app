@extends('admin.layout')

@section('title', 'Kasir & Konfirmasi Pembayaran Cash')

@section('content')
    <!-- HEADER SECTION -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white mb-8 shadow-xl relative overflow-hidden border border-slate-700/60">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-bold px-3 py-1 rounded-full mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    <span>Point of Sale (POS) & Cashier</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Konfirmasi Pembayaran Cash</h1>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-lg">
                    Verifikasi pembayaran tunai pelanggan dari meja, hitung uang kembalian, dan tandai lunas secara instan.
                </p>
            </div>

            <!-- Auto Refresh Toggle & Live Status -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="bg-slate-800/80 backdrop-blur-md border border-slate-700 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs">
                    <input type="checkbox" id="autoRefreshKasir" checked class="w-4 h-4 accent-amber-500 rounded cursor-pointer">
                    <label for="autoRefreshKasir" class="text-slate-300 text-xs font-semibold cursor-pointer">Auto Refresh (6s)</label>
                </div>

                <button 
                    onclick="window.location.reload()" 
                    class="bg-amber-500 hover:bg-amber-600 active:scale-95 text-slate-950 px-4 py-3 rounded-2xl font-extrabold text-xs flex items-center gap-1.5 shadow-md shadow-amber-500/20 transition-all"
                >
                    <span class="material-icons-round text-base">refresh</span>
                    <span>Segarkan</span>
                </button>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- STATISTIK KASIR HARI INI -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <!-- Card 1: Menunggu Konfirmasi -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 shrink-0">
                <span class="material-icons-round text-3xl">hourglass_top</span>
            </div>
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Menunggu Kasir</span>
                <div class="flex items-baseline gap-2 mt-0.5">
                    <span class="text-2xl font-black text-slate-900">{{ $totalPendingCount }}</span>
                    <span class="text-xs font-bold text-amber-600">Pesanan</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Kas Masuk Hari Ini -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-center justify-center text-emerald-600 shrink-0">
                <span class="material-icons-round text-3xl">account_balance_wallet</span>
            </div>
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Kas Masuk Hari Ini</span>
                <div class="flex items-baseline gap-1 mt-0.5">
                    <span class="text-xl sm:text-2xl font-black text-emerald-700">Rp {{ number_format($totalKasMasukHariIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Transaksi Selesai -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-200/80 flex items-center justify-center text-blue-600 shrink-0">
                <span class="material-icons-round text-3xl">task_alt</span>
            </div>
            <div>
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Transaksi Lunas</span>
                <div class="flex items-baseline gap-2 mt-0.5">
                    <span class="text-2xl font-black text-slate-900">{{ $totalTransaksiHariIni }}</span>
                    <span class="text-xs font-bold text-blue-600">Transaksi Hari Ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS FILTER -->
    <div class="flex items-center gap-2 border-b border-slate-200/80 pb-3 mb-6 overflow-x-auto">
        <a 
            href="/admin/pembayaran?tab=pending" 
            class="px-5 py-2.5 rounded-2xl text-xs font-extrabold transition-all flex items-center gap-2 whitespace-nowrap {{ ($tab ?? 'pending') === 'pending' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/60' }}"
        >
            <span class="material-icons-round text-base {{ ($tab ?? 'pending') === 'pending' ? 'text-amber-400' : 'text-slate-400' }}">pending_actions</span>
            <span>Menunggu Konfirmasi</span>
            @if($totalPendingCount > 0)
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ ($tab ?? 'pending') === 'pending' ? 'bg-amber-500 text-slate-950' : 'bg-rose-500 text-white' }}">
                    {{ $totalPendingCount }}
                </span>
            @endif
        </a>

        <a 
            href="/admin/pembayaran?tab=history" 
            class="px-5 py-2.5 rounded-2xl text-xs font-extrabold transition-all flex items-center gap-2 whitespace-nowrap {{ ($tab ?? 'pending') === 'history' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/60' }}"
        >
            <span class="material-icons-round text-base {{ ($tab ?? 'pending') === 'history' ? 'text-emerald-400' : 'text-slate-400' }}">history</span>
            <span>Riwayat Cash Hari Ini ({{ count($historyOrders) }})</span>
        </a>

        <a 
            href="/admin/pembayaran?tab=all" 
            class="px-5 py-2.5 rounded-2xl text-xs font-extrabold transition-all flex items-center gap-2 whitespace-nowrap {{ ($tab ?? 'pending') === 'all' ? 'bg-slate-900 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/60' }}"
        >
            <span class="material-icons-round text-base {{ ($tab ?? 'pending') === 'all' ? 'text-blue-400' : 'text-slate-400' }}">receipt_long</span>
            <span>Semua Transaksi ({{ count($allOrders) }})</span>
        </a>
    </div>

    <!-- CONTENT TAB 1: MENUNGGU KONFIRMASI (PENDING CASH) -->
    @if(($tab ?? 'pending') === 'pending')
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                    <span>Tagihan Cash Perlu Dikonfirmasi ({{ count($pendingOrders) }})</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">Terima uang tunai lalu klik Konfirmasi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pendingOrders as $order)
                    @php
                        $nominal = $order->total_bayar > 0 ? $order->total_bayar : \App\Http\Controllers\OrderController::hitungTotalPesanan($order);
                        $items = explode(',', $order->menu_pesanan);
                    @endphp
                    <div class="bg-white rounded-3xl border-2 border-amber-200/90 shadow-[0_6px_25px_rgba(245,158,11,0.08)] hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden relative">
                        
                        <!-- Top Accent Bar -->
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-3.5 text-slate-950 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center font-black text-lg">
                                    {{ $order->nomor_meja }}
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base leading-tight">Meja {{ $order->nomor_meja }}</h3>
                                    <p class="text-[11px] font-bold text-amber-950/80">Order ID: #{{ $order->id }}</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 bg-slate-950 text-amber-300 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                                    <span>CASH</span>
                                </span>
                                <span class="block text-[10px] font-bold text-amber-950/80 mt-1">
                                    {{ $order->created_at ? $order->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Body: Menu Items & Total -->
                        <div class="p-5 flex-1">
                            <!-- Total Tagihan Box -->
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50/60 border border-amber-200/80 rounded-2xl p-3.5 mb-4 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-extrabold text-amber-900/80 uppercase tracking-wider block">
                                        Total Tagihan Tunai
                                    </span>
                                    <span class="text-xl font-black text-amber-900 block leading-tight">
                                        Rp {{ number_format($nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-black shadow-sm">
                                    <span class="material-icons-round text-xl">payments</span>
                                </div>
                            </div>

                            <!-- Detail Rincian Menu -->
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2">
                                Rincian Pesanan
                            </span>

                            <div class="space-y-1.5 mb-4">
                                @foreach($items as $item)
                                    <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-100 text-xs font-bold text-slate-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                        <span class="truncate">{{ trim($item) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Footer Actions: Kalkulator & Konfirmasi Cepat -->
                        <div class="p-5 pt-0 space-y-2">
                            <button 
                                type="button"
                                onclick="openCalculatorModal('{{ $order->id }}', '{{ $order->nomor_meja }}', {{ $nominal }})"
                                class="w-full bg-amber-500 hover:bg-amber-600 active:scale-95 text-slate-950 font-extrabold text-xs py-3 rounded-2xl shadow-md shadow-amber-500/20 transition-all flex items-center justify-center gap-2"
                            >
                                <span class="material-icons-round text-base">calculate</span>
                                <span>Hitung Kembalian & Konfirmasi</span>
                            </button>

                            <div class="grid grid-cols-2 gap-2">
                                <form action="/admin/pembayaran/konfirmasi/{{ $order->id }}" method="POST" class="m-0">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        onclick="return confirm('Konfirmasi bahwa Meja {{ $order->nomor_meja }} telah membayar tunai Rp {{ number_format($nominal, 0, ',', '.') }} (LUNAS)?')"
                                        class="w-full bg-slate-900 hover:bg-emerald-600 active:scale-95 text-white font-extrabold text-[11px] py-2.5 rounded-xl transition flex items-center justify-center gap-1.5"
                                        title="Konfirmasi Lunas Langsung"
                                    >
                                        <span class="material-icons-round text-sm text-emerald-400">check_circle</span>
                                        <span>Lunas Langsung</span>
                                    </button>
                                </form>

                                <form action="/admin/pembayaran/batal/{{ $order->id }}" method="POST" class="m-0">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        onclick="return confirm('Batalkan pesanan Meja {{ $order->nomor_meja }} ini?')"
                                        class="w-full bg-rose-50 hover:bg-rose-100 active:scale-95 text-rose-600 font-extrabold text-[11px] py-2.5 rounded-xl border border-rose-200/70 transition flex items-center justify-center gap-1"
                                        title="Batalkan Pesanan"
                                    >
                                        <span class="material-icons-round text-sm">cancel</span>
                                        <span>Batalkan</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                        <div class="w-20 h-20 rounded-3xl bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-4">
                            <span class="material-icons-round text-4xl">check_circle</span>
                        </div>
                        <h3 class="font-extrabold text-base text-slate-900">Tidak Ada Tagihan Cash yang Menunggu</h3>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                            Semua pembayaran tunai telah dikonfirmasi lunas atau pelanggan membayar via QRIS. Antrean kasir bersih!
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- CONTENT TAB 2: RIWAYAT CASH HARI INI -->
    @if(($tab ?? 'pending') === 'history')
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>Riwayat Pembayaran Tunai Hari Ini ({{ count($historyOrders) }})</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">Transaksi cash yang telah terverifikasi lunas</span>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-400 uppercase font-extrabold text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4 pl-6">Order & Meja</th>
                                <th class="p-4">Rincian Menu</th>
                                <th class="p-4">Waktu Konfirmasi</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 pr-6 text-right">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($historyOrders as $h)
                                @php
                                    $hNominal = $h->total_bayar > 0 ? $h->total_bayar : \App\Http\Controllers\OrderController::hitungTotalPesanan($h);
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4 pl-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 font-black flex items-center justify-center border border-emerald-200/60">
                                                {{ $h->nomor_meja }}
                                            </div>
                                            <div>
                                                <span class="font-extrabold text-slate-900 block">Meja {{ $h->nomor_meja }}</span>
                                                <span class="text-[10px] text-slate-400">#{{ $h->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 max-w-xs truncate">
                                        <span class="font-semibold text-slate-800">{{ $h->menu_pesanan }}</span>
                                    </td>
                                    <td class="p-4 text-slate-500 whitespace-nowrap">
                                        {{ $h->updated_at ? $h->updated_at->format('H:i:s') : '-' }} WIB
                                        <span class="block text-[10px] text-slate-400">{{ $h->updated_at ? $h->updated_at->diffForHumans() : '' }}</span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-[10px] font-extrabold">
                                            <span class="material-icons-round text-xs">check</span>
                                            <span>LUNAS (CASH)</span>
                                        </span>
                                    </td>
                                    <td class="p-4 pr-6 text-right whitespace-nowrap">
                                        <span class="font-black text-slate-900 text-sm">Rp {{ number_format($hNominal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">
                                        Belum ada riwayat pembayaran cash yang dikonfirmasi hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- CONTENT TAB 3: SEMUA TRANSAKSI -->
    @if(($tab ?? 'pending') === 'all')
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span>Semua Transaksi Terakhir ({{ count($allOrders) }})</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">Log pesanan QRIS, Cash, dan semua status</span>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-400 uppercase font-extrabold text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4 pl-6">Meja & ID</th>
                                <th class="p-4">Pesanan</th>
                                <th class="p-4">Metode Bayar</th>
                                <th class="p-4">Status Bayar</th>
                                <th class="p-4">Status Dapur</th>
                                <th class="p-4 pr-6 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($allOrders as $o)
                                @php
                                    $oNominal = $o->total_bayar > 0 ? $o->total_bayar : \App\Http\Controllers\OrderController::hitungTotalPesanan($o);
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4 pl-6">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-800 font-black flex items-center justify-center">
                                                {{ $o->nomor_meja }}
                                            </div>
                                            <div>
                                                <span class="font-extrabold text-slate-900 block leading-tight">Meja {{ $o->nomor_meja }}</span>
                                                <span class="text-[10px] text-slate-400">Order #{{ $o->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 max-w-xs truncate font-semibold text-slate-800">
                                        {{ $o->menu_pesanan }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        <span class="uppercase font-extrabold text-[10px] px-2.5 py-1 rounded-lg {{ $o->metode_pembayaran === 'cash' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-blue-50 text-blue-800 border border-blue-200' }}">
                                            {{ $o->metode_pembayaran ?? 'Cash' }}
                                        </span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if($o->status_pembayaran === 'lunas')
                                            <span class="inline-flex items-center gap-1 text-emerald-700 font-extrabold text-[11px]">
                                                <span class="material-icons-round text-sm">check_circle</span>
                                                <span>Lunas</span>
                                            </span>
                                        @elseif($o->status_pembayaran === 'dibatalkan')
                                            <span class="inline-flex items-center gap-1 text-rose-600 font-extrabold text-[11px]">
                                                <span class="material-icons-round text-sm">cancel</span>
                                                <span>Batal</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-amber-600 font-extrabold text-[11px]">
                                                <span class="material-icons-round text-sm">hourglass_empty</span>
                                                <span>Menunggu</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @if($o->status_pesanan === 'siap')
                                            <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Siap Disajikan</span>
                                        @elseif($o->status_pesanan === 'dimasak')
                                            <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded text-[10px] font-bold">Sedang Dimasak</span>
                                        @else
                                            <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold">{{ ucfirst($o->status_pesanan) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4 pr-6 text-right whitespace-nowrap font-black text-slate-900">
                                        Rp {{ number_format($oNominal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KALKULATOR UANG KEMBALIAN KASIR -->
    <div id="calculatorModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200/80 transform transition-transform duration-200 scale-95" id="calculatorModalCard">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center font-black">
                        <span class="material-icons-round text-xl">calculate</span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900 leading-tight">Kalkulator Pembayaran</h3>
                        <p class="text-[11px] font-bold text-slate-400" id="calcMejaLabel">Meja - (Order #-)</p>
                    </div>
                </div>

                <button onclick="closeCalculatorModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <span class="material-icons-round text-base">close</span>
                </button>
            </div>

            <!-- Total Tagihan -->
            <div class="bg-slate-900 text-white rounded-2xl p-4 mb-4">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Tagihan</span>
                <span class="text-2xl font-black text-amber-400 block mt-0.5" id="calcTotalTagihan">Rp 0</span>
            </div>

            <!-- Quick Cash Preset Buttons -->
            <div class="mb-4">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2">Uang Cepat</span>
                <div class="grid grid-cols-4 gap-1.5" id="quickButtons">
                    <!-- Dynamic Buttons -->
                </div>
            </div>

            <!-- Input Uang Diterima -->
            <div class="mb-4">
                <label for="uangDiterima" class="block text-xs font-extrabold text-slate-800 mb-1.5">
                    Uang Diterima dari Pelanggan (Rp)
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-extrabold text-slate-400 text-sm">Rp</span>
                    <input 
                        type="number" 
                        id="uangDiterima" 
                        placeholder="Contoh: 50000" 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 font-black text-slate-900 text-base outline-hidden transition"
                        oninput="hitungKembalian()"
                    >
                </div>
            </div>

            <!-- Box Hasil Kembalian -->
            <div id="boxKembalian" class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-5 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block" id="labelKembalian">
                            Uang Kembalian
                        </span>
                        <span class="text-xl font-black text-slate-900 block mt-0.5" id="calcNominalKembalian">
                            Rp 0
                        </span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center font-black" id="iconKembalian">
                        <span class="material-icons-round text-xl">change_circle</span>
                    </div>
                </div>
            </div>

            <!-- Form Submit Konfirmasi Lunas -->
            <form id="calcConfirmForm" method="POST" action="">
                @csrf
                <button 
                    type="submit" 
                    id="btnConfirmCalc"
                    class="w-full bg-slate-900 hover:bg-emerald-600 active:scale-95 text-white font-extrabold text-xs py-3.5 rounded-2xl shadow-lg shadow-slate-900/10 transition-all flex items-center justify-center gap-2"
                >
                    <span class="material-icons-round text-base text-amber-400">check_circle</span>
                    <span>Konfirmasi Pembayaran Lunas</span>
                </button>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    let currentTotal = 0;
    let currentOrderId = null;

    function openCalculatorModal(orderId, nomorMeja, total) {
        currentOrderId = orderId;
        currentTotal = total;

        document.getElementById('calcMejaLabel').innerText = 'Meja ' + nomorMeja + ' (Order #' + orderId + ')';
        document.getElementById('calcTotalTagihan').innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
        document.getElementById('calcConfirmForm').action = '/admin/pembayaran/konfirmasi/' + orderId;

        // Render Quick Cash Presets
        const quickContainer = document.getElementById('quickButtons');
        quickContainer.innerHTML = '';

        const presets = [
            { label: 'Uang Pas', value: total },
            { label: 'Rp 20.000', value: 20000 },
            { label: 'Rp 50.000', value: 50000 },
            { label: 'Rp 100.000', value: 100000 }
        ];

        presets.forEach(p => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'bg-slate-100 hover:bg-amber-100 hover:text-amber-900 active:scale-95 text-slate-700 font-bold text-[10px] py-2 px-1 rounded-xl transition truncate border border-slate-200/60';
            btn.innerText = p.label;
            btn.onclick = () => {
                document.getElementById('uangDiterima').value = p.value;
                hitungKembalian();
            };
            quickContainer.appendChild(btn);
        });

        // Set default to uang pas
        document.getElementById('uangDiterima').value = total;
        hitungKembalian();

        const modal = document.getElementById('calculatorModal');
        const card = document.getElementById('calculatorModalCard');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
            document.getElementById('uangDiterima').focus();
        }, 10);
    }

    function closeCalculatorModal() {
        const modal = document.getElementById('calculatorModal');
        const card = document.getElementById('calculatorModalCard');
        modal.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function hitungKembalian() {
        const inputVal = parseFloat(document.getElementById('uangDiterima').value) || 0;
        const selisih = inputVal - currentTotal;
        const box = document.getElementById('boxKembalian');
        const label = document.getElementById('labelKembalian');
        const nominal = document.getElementById('calcNominalKembalian');
        const icon = document.getElementById('iconKembalian');
        const submitBtn = document.getElementById('btnConfirmCalc');

        if (selisih >= 0) {
            box.className = 'bg-emerald-50 border border-emerald-200 rounded-2xl p-4 mb-5 transition-all text-emerald-950';
            label.innerText = selisih === 0 ? 'Uang Pas (Tidak Ada Kembalian)' : 'Kembalian yang Harus Diberikan';
            label.className = 'text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 block';
            nominal.innerText = 'Rp ' + Number(selisih).toLocaleString('id-ID');
            nominal.className = 'text-xl font-black text-emerald-800 block mt-0.5';
            icon.className = 'w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black';
            icon.innerHTML = '<span class="material-icons-round text-xl">savings</span>';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            box.className = 'bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-5 transition-all text-rose-950';
            label.innerText = 'Uang Masih Kurang';
            label.className = 'text-[10px] font-extrabold uppercase tracking-wider text-rose-600 block';
            nominal.innerText = '- Rp ' + Number(Math.abs(selisih)).toLocaleString('id-ID');
            nominal.className = 'text-xl font-black text-rose-700 block mt-0.5';
            icon.className = 'w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center font-black';
            icon.innerHTML = '<span class="material-icons-round text-xl">error_outline</span>';
        }
    }

    // Auto Refresh Kasir setiap 6 detik
    setInterval(() => {
        let checkbox = document.getElementById('autoRefreshKasir');
        let modal = document.getElementById('calculatorModal');
        // Hanya refresh jika modal kalkulator tidak sedang dibuka
        if (checkbox && checkbox.checked && modal && modal.classList.contains('hidden')) {
            window.location.reload();
        }
    }, 6000);
</script>
@endsection
