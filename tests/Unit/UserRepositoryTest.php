<?php

namespace Tests\Unit;

use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\User\DTO\UpdateUserDataDTO;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
    }

    /** @test */
    public function it_creates_a_user()
    {
        $dto = new RegisterUserDataDTO([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $user = $this->repository->createUser($dto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = User::factory()->create();

        $dto = new UpdateUserDataDTO([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $updated = $this->repository->update($user, $dto);

        $this->assertEquals('Updated Name', $updated->name);
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    /** @test */
    public function it_returns_paginated_users()
    {
        User::factory()->count(3)->create();

        $result = $this->repository->getAll(10);

        $this->assertTrue($result->resource->count() >= 1);
    }
}
