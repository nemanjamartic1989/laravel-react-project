<?php

namespace Tests\Unit\Post;

use App\Domain\Post\DTO\CreatePostDataDTO;
use App\Domain\Post\DTO\UpdatePostDataDTO;
use App\Domain\Post\Repositories\PostRepositoryInterface;
use App\Domain\Post\Services\PostService;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    protected $repository;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock repository
        $this->repository = Mockery::mock(PostRepositoryInterface::class);

        // Mock authenticated user
        $user = new class {
            public $id = 1;
        };
        Auth::shouldReceive('user')->andReturn($user);

        // Service instance
        $this->service = new PostService($this->repository);
    }

    public function testStoreCreatesPost()
    {
        $data = [
            'title' => 'Test Post',
            'description' => 'Test description',
            'image' => 'test.jpg',
        ];

        $dto = new CreatePostDataDTO(array_merge($data, ['user_id' => 1]));

        $post = new Post($data);

        $this->repository
            ->shouldReceive('store')
            ->once()
            ->with(Mockery::on(function ($arg) use ($dto) {
                return $arg instanceof CreatePostDataDTO &&
                    $arg->title === $dto->title &&
                    $arg->description === $dto->description &&
                    $arg->image === $dto->image &&
                    $arg->userId === $dto->userId;
            }))
            ->andReturn($post);

        $result = $this->service->store($data);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals('Test Post', $result->title);
    }

    public function testUpdateUpdatesPost()
    {
        $post = new Post([
            'id' => 1,
            'title' => 'Old Title',
            'description' => 'Old description',
            'image' => 'old.jpg',
        ]);

        $data = [
            'title' => 'New Title',
            'description' => 'New description',
            'image' => 'new.jpg',
        ];

        $dto = new UpdatePostDataDTO($data);

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with($post, Mockery::on(fn($arg) => $arg instanceof UpdatePostDataDTO && $arg->title === $dto->title))
            ->andReturn($post);

        $result = $this->service->update($post, $data);

        $this->assertInstanceOf(Post::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
