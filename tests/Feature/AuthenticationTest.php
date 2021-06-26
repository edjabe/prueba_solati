<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;

class AuthenticationTest extends TestCase
{

    public function testSuccessfulLogin()
    {
        $user = \App\Models\User::create([
            'name' => 'Prueba Solati2',
            'email' => 'solati2@prueba.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);


        $loginData = ['email' => 'solati2@prueba.com', 'password' => 'password'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in"
            ]);

        $this->assertAuthenticated();
    }

    public function testFailedLogin()
    {
        $user = \App\Models\User::create([
            'name' => 'Prueba Solati2',
            'email' => 'solati2@prueba.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $loginData = ['email' => 'solati2@prueba.com', 'password' => 'password2'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "error" => "No esta autorizado"
            ]);
    }
}
