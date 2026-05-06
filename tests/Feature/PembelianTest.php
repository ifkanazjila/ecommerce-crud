<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembelianTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_products_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_cart()
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_cart()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/cart');
        $response->assertStatus(200);
    }

    public function test_add_to_cart_requires_auth()
    {
        $response = $this->post('/cart/add', []);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_add_to_cart()
    {
        $user = User::factory()->create();
        $product = \App\Models\Barang::factory()->create(); // pastikan ada factory Barang

        $response = $this->actingAs($user)->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_cart()
    {
        $user = User::factory()->create();
        $product = \App\Models\Barang::factory()->create();
        // Tambahkan ke cart dulu
        $this->actingAs($user)->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);
        // Update cart
        $response = $this->actingAs($user)->patch('/cart/update/' . $product->id, [
            'quantity' => 5
        ]);
        $response->assertStatus(302);
    }

    public function test_authenticated_user_can_remove_from_cart()
    {
        $user = User::factory()->create();
        $product = \App\Models\Barang::factory()->create();
        $this->actingAs($user)->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);
        $response = $this->actingAs($user)->delete('/cart/remove/' . $product->id);
        $response->assertStatus(302);
    }
    public function test_register_and_login_views_are_accessible()
    {
        $this->get('/register')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
    }

    public function test_register_and_login_functionality()
    {
        $this->post('/register', [
            'name' => 'Raka',
            'email' => 'raka@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertRedirect('/login');

        $this->post('/login', [
            'email' => 'raka@example.com',
            'password' => 'password',
        ])->assertRedirect('/');
    }

    public function test_logout_requires_auth()
    {
        $this->get('/logout')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/logout');
        $response->assertRedirect('/login');
    }
}
