<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
    }

    /** @test */
    public function authenticated_user_can_list_users()
    {
        $users = User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'email', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    /** @test */
    public function authenticated_user_can_create_user()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Secret123!',
            'password_confirmation' => 'Secret123!',
        ];

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->postJson('/api/users', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'John Doe')
                 ->assertJsonPath('data.email', 'john@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }

    /** @test */
    public function authenticated_user_can_update_user()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $payload = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => null,
        ];

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->putJson("/api/users/{$user->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Updated Name')
                 ->assertJsonPath('data.email', 'updated@example.com');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);
    }
}
