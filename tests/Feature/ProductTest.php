<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProducts()
    {
        $cateogry = \App\Models\Category::create([
            'nombre' => 'Prueba Solati2',
            'descripcion' => 'PRUEBA',
        ]);
        $products = Product::factory()->make();

        $user = \App\Models\User::create([
            'name' => 'Prueba Solati2',
            'email' => 'solati2@prueba.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $token = \JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('GET', '/api/products');

        $response->assertStatus(200);
    }
}
