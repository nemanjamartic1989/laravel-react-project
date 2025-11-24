<?php

namespace Tests\Unit\Post;

use App\Domain\Post\DTO\CreatePostDataDTO;
use App\Domain\Post\DTO\UpdatePostDataDTO;
use App\Domain\Post\Repositories\PostRepository;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected PostRepository $repository;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PostRepository();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_create_a_post()
    {
        $dto = new CreatePostDataDTO([
            'title' => 'Test Post',
            'description' => 'Test description',
            'user_id' => $this->user->id,
            'image' => 'images/default-photo.jpg',
        ]);

        $post = $this->repository->store($dto);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Test Post',
            'description' => 'Test description',
            'user_id' => $this->user->id,
            'image' => 'images/default-photo.jpg',
        ]);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Old Title',
            'description' => 'Old description',
            'image' => 'images/old-photo.jpg',
        ]);

        $dto = new UpdatePostDataDTO([
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'image' => 'images/updated-photo.jpg',
        ]);

        $updatedPost = $this->repository->update($post, $dto);

        $this->assertEquals('Updated Title', $updatedPost->title);
        $this->assertEquals('Updated description', $updatedPost->description);
        $this->assertEquals('images/updated-photo.jpg', $updatedPost->image);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'image' => 'images/updated-photo.jpg',
        ]);
    }
}
