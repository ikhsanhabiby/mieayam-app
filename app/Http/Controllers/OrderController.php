<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Carbon\Carbon;

class OrderController extends Controller
{
    // ==========================================
    // 1. BAGIAN CUSTOMER (MENU & KERANJANG)
    // ==========================================

    public function menu(Request $request) {
        $meja = $request->query('meja', '1'); // Default meja 1
        $menus = Menu::where('stok', '>', 0)->get();
        return view('customer.menu', compact('meja', 'menus'));
    }

    public function tambahKeranjang(Request $request) {
        $cart = session()->get('cart', []);
        $menu = $request->menu;
        $harga = (int)$request->harga;
        $jumlah = (int)($request->jumlah ?? 1);

        if ($jumlah < 1) {
            $jumlah = 1;
        }

        if(isset($cart[$menu])) {
            $cart[$menu]['jumlah'] += $jumlah;
        } else {
            $cart[$menu] = [
                "nama" => $menu,
                "harga" => $harga,
                "jumlah" => $jumlah
            ];
        }

        session()->put('meja', $request->meja);
        session()->put('cart', $cart);

        $totalPorsi = 0;
        foreach($cart as $item) {
            $totalPorsi += (int)($item['jumlah'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'total_item' => $totalPorsi,
            'total_menu' => count($cart)
        ]);
    }

    public function ubahJumlahKeranjang(Request $request) {
        $cart = session()->get('cart', []);
        $menu = $request->menu;
        $delta = (int)$request->delta; // +1 or -1

        if(isset($cart[$menu])) {
            $cart[$menu]['jumlah'] += $delta;
            if($cart[$menu]['jumlah'] <= 0) {
                unset($cart[$menu]);
            }
            session()->put('cart', $cart);
        }

        return back();
    }

    public function lihatKeranjang() {
        $cart = session()->get('cart', []);
        $meja = session()->get('meja', '1');
        return view('customer.keranjang', compact('cart', 'meja'));
    }

    public function hapusKeranjang($id) {
        $cart = session()->get('cart', []);
        $decoded = urldecode($id);

        if(isset($cart[$id])) {
            unset($cart[$id]);
        } elseif(isset($cart[$decoded])) {
            unset($cart[$decoded]);
        }

        session()->put('cart', $cart);
        return back();
    }

    // ==========================================
    // 2. BAGIAN CHECKOUT & PEMBAYARAN
    // ==========================================

    public function prosesCheckout(Request $request) {
        $cart = session()->get('cart');
        
        if(!$cart || count($cart) === 0) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $detailPesanan = [];
        $totalHarga = 0;
        foreach($cart as $item) {
            $porsi = (int)($item['jumlah'] ?? 1);
            $harga = (int)($item['harga'] ?? 0);
            $detailPesanan[] = $porsi . 'x ' . $item['nama'];
            $totalHarga += ($porsi * $harga);
        }
        $stringPesanan = implode(', ', $detailPesanan);

        $order = new Order();
        $order->nomor_meja = session()->get('meja', '1');
        $order->menu_pesanan = $stringPesanan;
        $order->total_bayar = $totalHarga;
        $order->metode_pembayaran = 'cash'; // default
        $order->status_pembayaran = 'menunggu_konfirmasi';
        $order->status_pesanan = 'dimasak';
        $order->save();

        session()->forget('cart');

        return redirect('/pembayaran/' . $order->id);
    }

    public function checkout($id) {
        $order = Order::findOrFail($id);
        
        // Hitung total jika total_bayar masih 0
        if (!$order->total_bayar || $order->total_bayar == 0) {
            $order->total_bayar = self::hitungTotalPesanan($order);
            $order->save();
        }

        return view('customer.checkout', compact('order'));
    }

    public function bayar(Request $request, $id) {
        $order = Order::findOrFail($id);
        $metode = $request->input('metode', 'cash');
        
        $order->metode_pembayaran = $metode;
        if ($metode === 'cash') {
            $order->status_pembayaran = 'menunggu_konfirmasi';
        } else {
            $order->status_pembayaran = 'lunas';
        }
        
        // Pastikan total_bayar terisi
        if (!$order->total_bayar || $order->total_bayar == 0) {
            $order->total_bayar = self::hitungTotalPesanan($order);
        }
        
        $order->save();
        
        return redirect('/menunggu/' . $order->id);
    }

    // ==========================================
    // 3. BAGIAN NOTIFIKASI & MENUNGGU
    // ==========================================

    public function menunggu($id) {
        $order = Order::findOrFail($id);
        if (!$order->total_bayar || $order->total_bayar == 0) {
            $order->total_bayar = self::hitungTotalPesanan($order);
            $order->save();
        }
        return view('customer.menunggu', compact('order'));
    }

    public function cekStatus($id) {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['status' => 'not_found'], 404);
        }
        return response()->json([
            'status' => $order->status_pesanan,
            'status_pesanan' => $order->status_pesanan,
            'status_pembayaran' => $order->status_pembayaran ?? 'lunas',
            'metode_pembayaran' => $order->metode_pembayaran ?? 'cash',
        ]);
    }

    // ==========================================
    // 4. BAGIAN ADMIN (DASHBOARD & PRINT QR)
    // ==========================================

    public function admin() {
        $orders = Order::where('status_pesanan', 'dimasak')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCashCount = Order::where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', '!=', 'lunas')
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->count();

        return view('admin.dashboard', compact('orders', 'pendingCashCount'));
    }

    public function tandaiSiap($id) {
        $order = Order::findOrFail($id);
        $order->status_pesanan = 'siap';
        $order->save();
        return back()->with('success', 'Pesanan Meja ' . $order->nomor_meja . ' telah ditandai Siap!');
    }

    public function cetakQr() {
        $mejas = \App\Models\Meja::orderBy('nomor_meja','asc')->get();
        return view('admin.cetak-qr', compact('mejas'));
    }

    // ==========================================
    // 5. BAGIAN KASIR (KONFIRMASI PEMBAYARAN CASH)
    // ==========================================

    public function pembayaranIndex(Request $request) {
        $tab = $request->query('tab', 'pending');

        // Update orders yang total_bayar masih 0 agar akurat
        $zeroOrders = Order::where('total_bayar', 0)->orWhereNull('total_bayar')->get();
        foreach($zeroOrders as $zo) {
            $zo->total_bayar = self::hitungTotalPesanan($zo);
            $zo->save();
        }

        // 1. Pesanan Cash yang Menunggu Konfirmasi
        $pendingOrders = Order::where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', '!=', 'lunas')
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Riwayat Cash Lunas Hari Ini
        $today = Carbon::today();
        $historyOrders = Order::where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', 'lunas')
            ->whereDate('updated_at', $today)
            ->orderBy('updated_at', 'desc')
            ->get();

        // 3. Semua Transaksi Terakhir (Cash & Lainnya)
        $allOrders = Order::orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Statistik Kasir
        $totalPendingCount = $pendingOrders->count();
        $totalKasMasukHariIni = Order::where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', 'lunas')
            ->whereDate('updated_at', $today)
            ->sum('total_bayar');

        $totalTransaksiHariIni = Order::where('status_pembayaran', 'lunas')
            ->whereDate('updated_at', $today)
            ->count();

        return view('admin.pembayaran.index', compact(
            'pendingOrders',
            'historyOrders',
            'allOrders',
            'totalPendingCount',
            'totalKasMasukHariIni',
            'totalTransaksiHariIni',
            'tab'
        ));
    }

    public function konfirmasiPembayaran(Request $request, $id) {
        $order = Order::findOrFail($id);
        
        if (!$order->total_bayar || $order->total_bayar == 0) {
            $order->total_bayar = self::hitungTotalPesanan($order);
        }

        $order->status_pembayaran = 'lunas';
        $order->metode_pembayaran = 'cash';
        $order->save();

        $formattedTotal = 'Rp ' . number_format($order->total_bayar, 0, ',', '.');
        return back()->with('success', "Pembayaran Tunai Meja {$order->nomor_meja} (Order #{$order->id}) sebesar {$formattedTotal} berhasil dikonfirmasi LUNAS!");
    }

    public function batalPesanan(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->status_pesanan = 'dibatalkan';
        $order->status_pembayaran = 'dibatalkan';
        $order->save();

        return back()->with('success', "Pesanan Meja {$order->nomor_meja} (Order #{$order->id}) berhasil dibatalkan.");
    }

    public function apiPendingCash() {
        $pendingOrders = Order::where('metode_pembayaran', 'cash')
            ->where('status_pembayaran', '!=', 'lunas')
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'count' => $pendingOrders->count(),
            'orders' => $pendingOrders
        ]);
    }

    // ==========================================
    // 6. HELPER ESTIMASI / PERHITUNGAN HARGA
    // ==========================================

    public static function hitungTotalPesanan($order) {
        if (!empty($order->total_bayar) && $order->total_bayar > 0) {
            return (int)$order->total_bayar;
        }

        $total = 0;
        $items = explode(',', $order->menu_pesanan ?? '');
        foreach ($items as $item) {
            $item = trim($item);
            if (preg_match('/^(\d+)x\s*(.*)$/', $item, $matches)) {
                $qty = (int)$matches[1];
                $nama = trim($matches[2]);
                $menu = Menu::where('nama_menu', $nama)->first();
                if ($menu) {
                    $total += $qty * (int)$menu->harga;
                } else {
                    $total += $qty * 15000; // default estimasi
                }
            }
        }
        return $total;
    }
}