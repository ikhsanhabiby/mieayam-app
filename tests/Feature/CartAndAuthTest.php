<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartAndAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_tambah_keranjang_dengan_jumlah_5()
    {
        $response = $this->postJson('/keranjang/tambah', [
            'menu' => 'Mie Ayam Bakso Spesial',
            'harga' => 20000,
            'jumlah' => 5,
            'meja' => '3'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total_item' => 5,
                'total_menu' => 1
            ]);

        $this->assertEquals(5, session('cart')['Mie Ayam Bakso Spesial']['jumlah']);
        $this->assertEquals(20000, session('cart')['Mie Ayam Bakso Spesial']['harga']);
        $this->assertEquals('3', session('meja'));
    }

    public function test_tambah_akumulasi_kuantitas_pada_menu_yang_sama()
    {
        $this->postJson('/keranjang/tambah', [
            'menu' => 'Es Teh Manis',
            'harga' => 5000,
            'jumlah' => 2,
            'meja' => '1'
        ]);

        $response = $this->postJson('/keranjang/tambah', [
            'menu' => 'Es Teh Manis',
            'harga' => 5000,
            'jumlah' => 3,
            'meja' => '1'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'total_item' => 5,
                'total_menu' => 1
            ]);

        $this->assertEquals(5, session('cart')['Es Teh Manis']['jumlah']);
    }

    public function test_ubah_jumlah_porsi_di_keranjang()
    {
        $this->withSession([
            'cart' => [
                'Mie Ayam Komplit' => [
                    'nama' => 'Mie Ayam Komplit',
                    'harga' => 25000,
                    'jumlah' => 5
                ]
            ],
            'meja' => '2'
        ]);

        // Kurangi 1
        $this->post('/keranjang/ubah-jumlah', [
            'menu' => 'Mie Ayam Komplit',
            'delta' => -1
        ]);

        $this->assertEquals(4, session('cart')['Mie Ayam Komplit']['jumlah']);

        // Tambah 1
        $this->post('/keranjang/ubah-jumlah', [
            'menu' => 'Mie Ayam Komplit',
            'delta' => 1
        ]);

        $this->assertEquals(5, session('cart')['Mie Ayam Komplit']['jumlah']);
    }

    public function test_user_guest_tidak_bisa_mengakses_halaman_admin()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        $responseMenu = $this->get('/admin/menu');
        $responseMenu->assertRedirect('/login');

        $responseMeja = $this->get('/admin/meja');
        $responseMeja->assertRedirect('/login');
    }

    public function test_admin_terautentikasi_bisa_mengakses_halaman_admin()
    {
        $admin = User::factory()->create([
            'name' => 'Admin Resto',
            'email' => 'admin@resto.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

        $responseMenu = $this->actingAs($admin)->get('/admin/menu');
        $responseMenu->assertStatus(200);
    }
}
