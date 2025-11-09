<?php

namespace Tests\Unit;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepositoryInterface $repository;
    protected UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepositoryInterface::class);
        $this->service = new UserService($this->repository);
    }

    /** @test */
    public function it_calls_repository_to_get_all_users()
    {
        $users = User::factory()->count(2)->make();
        $resourceCollection = \App\Http\Resources\UserResource::collection($users);

        $this->repository
            ->shouldReceive('getAll')
            ->once()
            ->with(10)
            ->andReturn($resourceCollection);

        $result = $this->service->getAll();

        $this->assertInstanceOf(\Illuminate\Http\Resources\Json\AnonymousResourceCollection::class, $result);
        $this->assertCount(2, $result->collection);
    }

    /** @test */
    public function it_creates_user_using_repository()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ];

        $expectedUser = new User($data);

        $this->repository
            ->shouldReceive('createUser')
            ->once()
            ->with(Mockery::on(fn($dto) => $dto instanceof RegisterUserDataDTO && $dto->email === 'john@example.com'))
            ->andReturn($expectedUser);

        $user = $this->service->store($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
    }

    /** @test */
    public function it_updates_user_using_repository()
    {
        $user = User::factory()->make();
        $data = ['name' => 'Updated', 'email' => 'updated@example.com'];

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with($user, Mockery::on(fn($dto) => $dto->email === 'updated@example.com'))
            ->andReturn($user);

        $result = $this->service->update($user, $data);

        $this->assertInstanceOf(User::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
