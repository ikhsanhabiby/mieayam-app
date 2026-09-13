<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // ==========================================
    // 1. BAGIAN CUSTOMER (MENU & KERANJANG)
    // ==========================================

    public function menu(Request $request) {
        $meja = $request->query('meja', '1'); // Default meja 1
        $menus = \App\Models\Menu::where('stok', '>', 0)->get();
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
        
        if(!$cart) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $detailPesanan = [];
        foreach($cart as $item) {
            $detailPesanan[] = $item['jumlah'] . 'x ' . $item['nama'];
        }
        $stringPesanan = implode(', ', $detailPesanan);

        $order = new Order();
        $order->nomor_meja = session()->get('meja');
        $order->menu_pesanan = $stringPesanan;
        $order->status_pesanan = 'dimasak';
        $order->save();

        session()->forget('cart');

        return redirect('/pembayaran/' . $order->id);
    }

    public function checkout($id) {
        $order = Order::find($id);
        return view('customer.checkout', compact('order'));
    }

    public function bayar(Request $request, $id) {
        $order = Order::find($id);
        $order->metode_pembayaran = $request->metode;
        $order->save();
        
        return redirect('/menunggu/' . $order->id);
    }

    // ==========================================
    // 3. BAGIAN NOTIFIKASI & MENUNGGU
    // ==========================================

    public function menunggu($id) {
        $order = Order::find($id);
        return view('customer.menunggu', compact('order'));
    }

    public function cekStatus($id) {
        $order = Order::find($id);
        return response()->json(['status' => $order->status_pesanan]);
    }

    // ==========================================
    // 4. BAGIAN ADMIN (DASHBOARD & PRINT QR)
    // ==========================================

    public function admin() {
        $orders = Order::where('status_pesanan', 'dimasak')->get();
        return view('admin.dashboard', compact('orders'));
    }

    public function tandaiSiap($id) {
        $order = Order::find($id);
        $order->status_pesanan = 'siap';
        $order->save();
        return back();
    }

    public function cetakQr() {
        $totalMeja = 6; 
        return view('admin.cetak-qr', compact('totalMeja'));
    }
}