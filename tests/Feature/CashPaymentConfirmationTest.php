<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashPaymentConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_checkout_cash_and_pending_status()
    {
        // Setup session cart
        $this->withSession([
            'cart' => [
                'Mie Ayam Spesial' => [
                    'nama' => 'Mie Ayam Spesial',
                    'harga' => 18000,
                    'jumlah' => 2
                ],
                'Es Jeruk' => [
                    'nama' => 'Es Jeruk',
                    'harga' => 6000,
                    'jumlah' => 1
                ]
            ],
            'meja' => '4'
        ]);

        // Proses Checkout
        $checkoutResponse = $this->post('/checkout');
        $order = Order::latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('4', $order->nomor_meja);
        $this->assertEquals(42000, $order->total_bayar); // (18000 * 2) + 6000
        $this->assertEquals('menunggu_konfirmasi', $order->status_pembayaran);

        // Pilih Pembayaran Cash
        $payResponse = $this->post('/bayar/' . $order->id, [
            'metode' => 'cash'
        ]);
        $payResponse->assertRedirect('/menunggu/' . $order->id);

        $order->refresh();
        $this->assertEquals('cash', $order->metode_pembayaran);
        $this->assertEquals('menunggu_konfirmasi', $order->status_pembayaran);

        // Cek API Status
        $statusResponse = $this->getJson('/cek-status/' . $order->id);
        $statusResponse->assertStatus(200)
            ->assertJson([
                'status_pesanan' => 'dimasak',
                'status_pembayaran' => 'menunggu_konfirmasi',
                'metode_pembayaran' => 'cash'
            ]);
    }

    public function test_admin_can_view_and_confirm_cash_payment()
    {
        $admin = User::factory()->create([
            'name' => 'Kasir Resto',
            'email' => 'kasir@resto.com',
            'password' => bcrypt('password123')
        ]);

        // Buat Order Cash Pending
        $order = Order::create([
            'nomor_meja' => '2',
            'menu_pesanan' => '1x Mie Ayam Jamur',
            'total_bayar' => 20000,
            'metode_pembayaran' => 'cash',
            'status_pembayaran' => 'menunggu_konfirmasi',
            'status_pesanan' => 'dimasak'
        ]);

        // Akses Halaman Kasir
        $responseKasir = $this->actingAs($admin)->get('/admin/pembayaran');
        $responseKasir->assertStatus(200)
            ->assertSee('Meja 2')
            ->assertSee('20.000');

        // Cek API pending cash count
        $apiResponse = $this->actingAs($admin)->getJson('/admin/api/pending-cash');
        $apiResponse->assertStatus(200)
            ->assertJson([
                'count' => 1
            ]);

        // Konfirmasi Pembayaran Lunas
        $confirmResponse = $this->actingAs($admin)->post('/admin/pembayaran/konfirmasi/' . $order->id);
        $confirmResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('lunas', $order->status_pembayaran);

        // Cek API pending cash count berkurang jadi 0
        $apiResponseAfter = $this->actingAs($admin)->getJson('/admin/api/pending-cash');
        $apiResponseAfter->assertStatus(200)
            ->assertJson([
                'count' => 0
            ]);

        // Cek Polling Customer status sekarang lunas
        $customerStatus = $this->getJson('/cek-status/' . $order->id);
        $customerStatus->assertStatus(200)
            ->assertJson([
                'status_pembayaran' => 'lunas'
            ]);
    }

    public function test_admin_can_cancel_unpaid_order()
    {
        $admin = User::factory()->create();

        $order = Order::create([
            'nomor_meja' => '5',
            'menu_pesanan' => '1x Bakso Goreng',
            'total_bayar' => 15000,
            'metode_pembayaran' => 'cash',
            'status_pembayaran' => 'menunggu_konfirmasi',
            'status_pesanan' => 'dimasak'
        ]);

        $cancelResponse = $this->actingAs($admin)->post('/admin/pembayaran/batal/' . $order->id);
        $cancelResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('dibatalkan', $order->status_pesanan);
        $this->assertEquals('dibatalkan', $order->status_pembayaran);
    }
}
