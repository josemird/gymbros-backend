<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected string $apiUrl = '/api';

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->postJson($this->apiUrl . '/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@correo.com',
            'password' => 'testpassword',
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'test@correo.com']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('testpassword')
        ]);
        $response = $this->postJson($this->apiUrl . '/login', [
            'email' => $user->email,
            'password' => 'testpassword',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_unauthenticated_user_cannot_access_profile(): void
    {
        $response = $this->getJson($this->apiUrl . '/profile');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/profile');
        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');
        $response->assertStatus(200);
    }

    public function test_register_fails_with_short_password(): void
    {
        $response = $this->postJson($this->apiUrl . '/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test2@correo.com',
            'password' => 'short',
        ]);
        $response->assertStatus(422);
    }
}
