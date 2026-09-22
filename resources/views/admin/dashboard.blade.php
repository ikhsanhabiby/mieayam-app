@extends('admin.layout')

@section('title', 'Pesanan Dapur')

@section('content')
    <!-- HEADER SECTION -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white mb-6 shadow-xl relative overflow-hidden border border-slate-700/60">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-brand-500/20 border border-brand-500/30 text-brand-300 text-xs font-bold px-3 py-1 rounded-full mb-2">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-ping"></span>
                    <span>Kitchen Display System (KDS)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Antrean Dapur & Pesanan</h1>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-lg">
                    Pantau pesanan pelanggan yang baru masuk dan tandai siap jika makanan sudah matang.
                </p>
            </div>

            <!-- Stats & Auto Refresh Toggle -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="bg-slate-800/80 backdrop-blur-md border border-slate-700 px-5 py-3 rounded-2xl flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center">
                        <span class="material-icons-round text-2xl">pending_actions</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-white leading-none">{{ count($orders) }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perlu Dimasak</span>
                    </div>
                </div>

                <div class="bg-slate-800/80 backdrop-blur-md border border-slate-700 px-4 py-3 rounded-2xl flex items-center gap-2 text-xs">
                    <input type="checkbox" id="autoRefresh" checked class="w-4 h-4 accent-brand-500 rounded cursor-pointer">
                    <label for="autoRefresh" class="text-slate-300 text-xs font-semibold cursor-pointer">Auto Refresh</label>
                </div>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- PENDING CASH ALERT BANNER -->
    @if(($pendingCashCount ?? 0) > 0)
        <div class="bg-gradient-to-r from-amber-500 via-amber-400 to-orange-400 rounded-3xl p-4 sm:p-5 text-slate-950 mb-6 shadow-lg shadow-amber-500/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-amber-300">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-slate-950 text-amber-400 flex items-center justify-center shrink-0 shadow-md">
                    <span class="material-icons-round text-2xl animate-bounce">payments</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="bg-slate-950 text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Perhatian Kasir</span>
                        <h3 class="font-extrabold text-sm sm:text-base">Ada {{ $pendingCashCount }} Pesanan Cash Menunggu Konfirmasi!</h3>
                    </div>
                    <p class="text-xs text-slate-900/80 font-medium mt-0.5">
                        Pelanggan telah memilih bayar tunai di kasir. Silakan terima pembayaran dan konfirmasi lunas.
                    </p>
                </div>
            </div>

            <a 
                href="/admin/pembayaran" 
                class="bg-slate-950 hover:bg-slate-800 text-white px-5 py-2.5 rounded-2xl font-extrabold text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shrink-0 shadow-md"
            >
                <span class="material-icons-round text-base text-amber-400">calculate</span>
                <span>Buka Menu Kasir Cash</span>
                <span class="material-icons-round text-sm">arrow_forward</span>
            </a>
        </div>
    @endif

    <!-- GRID PESANAN AKTIF -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                <span>Pesanan yang Sedang Berjalan ({{ count($orders) }})</span>
            </h2>
            <span class="text-xs text-slate-400 font-medium">Klik tombol jika pesanan selesai</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($orders as $o)
                @php
                    $isCash = ($o->metode_pembayaran === 'cash' || empty($o->metode_pembayaran));
                    $isLunas = ($o->status_pembayaran === 'lunas' || $o->metode_pembayaran === 'ewallet');
                    $nominal = $o->total_bayar > 0 ? $o->total_bayar : \App\Http\Controllers\OrderController::hitungTotalPesanan($o);
                @endphp
                <div class="bg-white rounded-3xl border {{ !$isLunas ? 'border-amber-300 ring-2 ring-amber-400/20' : 'border-slate-200/80' }} shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-lg transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    
                    <div>
                        <!-- Header Kartu Pesanan -->
                        <div class="bg-gradient-to-r {{ !$isLunas ? 'from-amber-500 to-orange-500' : 'from-brand-500 to-amber-500' }} p-4 text-slate-950 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center font-black text-lg">
                                    {{ $o->nomor_meja }}
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base leading-tight">Meja {{ $o->nomor_meja }}</h3>
                                    <p class="text-[11px] font-bold text-amber-950/80">Order ID: #{{ $o->id }}</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="inline-block bg-slate-950 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                    {{ $o->metode_pembayaran ? strtoupper($o->metode_pembayaran) : 'CASH' }}
                                </span>
                                <span class="block text-[10px] font-bold text-amber-950/80 mt-1">
                                    {{ $o->created_at ? $o->created_at->format('H:i') : '-' }} WIB
                                </span>
                            </div>
                        </div>

                        <!-- Status Pembayaran Bar -->
                        <div class="px-5 py-2.5 border-b border-slate-100 flex items-center justify-between text-xs {{ !$isLunas ? 'bg-amber-50/70' : 'bg-slate-50' }}">
                            <div class="flex items-center gap-1.5">
                                @if($isLunas)
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="font-extrabold text-emerald-700 text-[11px]">
                                        LUNAS {{ $o->metode_pembayaran === 'ewallet' ? '(QRIS)' : '(CASH)' }}
                                    </span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                    <span class="font-extrabold text-amber-800 text-[11px]">MENUNGGU KASIR</span>
                                @endif
                            </div>
                            <span class="font-black text-slate-900 text-xs">
                                Rp {{ number_format($nominal, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Daftar Item Pesanan -->
                        <div class="p-5">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block mb-3">
                                Rincian Menu Pesanan
                            </span>

                            @php
                                $items = explode(',', $o->menu_pesanan);
                            @endphp

                            <div class="space-y-2">
                                @foreach($items as $item)
                                    <div class="flex items-center gap-2.5 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                        <span class="w-2 h-2 rounded-full bg-brand-500 shrink-0"></span>
                                        <span class="font-extrabold text-xs text-slate-900 leading-snug">
                                            {{ trim($item) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Footer Kartu: Tombol Aksi -->
                    <div class="p-5 pt-0 space-y-2">
                        @if(!$isLunas)
                            <!-- Quick Cash Confirmation Button for Kitchen / Admin -->
                            <form action="/admin/pembayaran/konfirmasi/{{ $o->id }}" method="POST" class="m-0">
                                @csrf
                                <button 
                                    type="submit" 
                                    onclick="return confirm('Konfirmasi bahwa pembayaran Tunai Meja {{ $o->nomor_meja }} sebesar Rp {{ number_format($nominal, 0, ',', '.') }} sudah DITERIMA (Lunas)?')"
                                    class="w-full bg-amber-500 hover:bg-amber-600 active:scale-95 text-slate-950 font-extrabold text-xs py-2.5 rounded-2xl shadow-xs transition-all flex items-center justify-center gap-1.5"
                                >
                                    <span class="material-icons-round text-base">payments</span>
                                    <span>Konfirmasi Pembayaran Cash</span>
                                </button>
                            </form>
                        @endif

                        <form action="/admin/siap/{{ $o->id }}" method="POST" class="m-0">
                            @csrf
                            <button 
                                type="submit" 
                                onclick="return confirm('Tandai pesanan Meja {{ $o->nomor_meja }} sudah siap disajikan?')"
                                class="w-full bg-slate-900 hover:bg-emerald-600 active:scale-95 text-white font-extrabold text-xs py-3 rounded-2xl shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                            >
                                <span class="material-icons-round text-base text-brand-400">check_circle</span>
                                <span>Tandai Siap Disajikan</span>
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                    <div class="w-20 h-20 rounded-3xl bg-brand-50 text-brand-500 flex items-center justify-center mx-auto mb-4">
                        <span class="material-icons-round text-4xl">done_all</span>
                    </div>
                    <h3 class="font-extrabold text-base text-slate-900">Dapur Sedang Kosong</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Semua pesanan pelanggan sudah selesai dikerjakan. Halaman ini akan otomatis menampilkan tiket baru saat ada pesanan masuk.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Auto refresh halaman setiap 8 detik jika checkbox aktif
    setInterval(() => {
        let checkbox = document.getElementById('autoRefresh');
        if (checkbox && checkbox.checked) {
            window.location.reload();
        }
    }, 8000);
</script>
@endsection