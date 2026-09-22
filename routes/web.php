<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\AuthController;


// Redirect root ke /pesan
Route::get('/', function () {
    return redirect('/pesan');
});

// Halaman Customer (Menu & Keranjang)
Route::get('/pesan', [OrderController::class, 'menu']);
Route::post('/keranjang/tambah', [OrderController::class, 'tambahKeranjang']);
Route::post('/keranjang/ubah-jumlah', [OrderController::class, 'ubahJumlahKeranjang']);
Route::get('/keranjang', [OrderController::class, 'lihatKeranjang']);
Route::get('/keranjang/hapus/{id}', [OrderController::class, 'hapusKeranjang']);

// Checkout & Pembayaran
Route::post('/checkout', [OrderController::class, 'prosesCheckout']);
Route::get('/pembayaran/{id}', [OrderController::class, 'checkout']); // Halaman pilih pembayaran
Route::post('/bayar/{id}', [OrderController::class, 'bayar']);
Route::get('/menunggu/{id}', [OrderController::class, 'menunggu']);
Route::get('/cek-status/{id}', [App\Http\Controllers\OrderController::class, 'cekStatus']);

// API Polling Customer
Route::get('/api/cek-status/{id}', [OrderController::class, 'cekStatus']);

Route::get('/login', [AuthController::class, 'login'])->name('login'); 
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::post('/logout', [AuthController::class, 'logout']);

// SEMUA RUTE DI DALAM GRUP INI WAJIB LOGIN!
Route::middleware('auth')->group(function () {

    // Dashboard & Pesanan
    Route::get('/admin', [OrderController::class, 'admin']);
    Route::post('/admin/siap/{id}', [OrderController::class, 'tandaiSiap']);

    // Kasir & Konfirmasi Pembayaran Cash
    Route::get('/admin/pembayaran', [OrderController::class, 'pembayaranIndex']);
    Route::post('/admin/pembayaran/konfirmasi/{id}', [OrderController::class, 'konfirmasiPembayaran']);
    Route::post('/admin/pembayaran/batal/{id}', [OrderController::class, 'batalPesanan']);
    Route::get('/admin/api/pending-cash', [OrderController::class, 'apiPendingCash']);

    // Kelola Menu
    Route::get('/admin/menu', [MenuController::class, 'index']);
    Route::post('/admin/menu/tambah', [MenuController::class, 'store']);
    Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit']);
    Route::post('/admin/menu/update/{id}', [MenuController::class, 'update']);
    Route::get('/admin/menu/hapus/{id}', [MenuController::class, 'destroy']);

    // Kelola Meja & QR
    Route::get('/admin/meja', [MejaController::class, 'index']);
    Route::post('/admin/meja/tambah', [MejaController::class, 'store']);
    Route::get('/admin/meja/hapus/{id}', [MejaController::class, 'destroy']);
    Route::get('/admin/cetak-qr', [MejaController::class, 'cetakQr']);

});