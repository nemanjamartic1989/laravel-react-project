<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Authenticate user
        Sanctum::actingAs($this->user);
    }

    /** @test */
    public function it_returns_posts_list()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'image']
                ]
            ]);
    }

    /** @test */
    public function it_creates_new_post_with_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->postJson('/api/posts', [
            'title' => 'My Title',
            'description' => 'My Description',
            'image' => $file,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'My Title');

        // Check file saved
        Storage::disk('public')->assertExists('posts/' . $file->hashName());
    }

    /** @test */
    public function it_shows_single_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $post->id);
    }

    /** @test */
    public function it_updates_post_without_changing_image()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'image' => 'images/old.jpg'
        ]);

        $response = $this->putJson("/api/posts/$post->id", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.image', 'images/old.jpg');
    }

    /** @test */
    public function it_updates_post_with_new_image()
    {
        Storage::fake('public');

        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'image' => 'images/old.jpg'
        ]);

        $file = UploadedFile::fake()->image('new-photo.jpg');

        $response = $this->putJson("/api/posts/$post->id", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'image' => $file
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title');

        Storage::disk('public')->assertExists('images/' . $file->hashName());
    }

    /** @test */
    public function it_deletes_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/$post->id");

        $response->assertStatus(204);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
}
