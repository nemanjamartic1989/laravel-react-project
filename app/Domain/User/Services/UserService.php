<?php

namespace App\Domain\User\Services;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService
{
    public function __construct(protected UserRepositoryInterface $repository)
    {

    }

    /**
     * Get all users
     * @param int $perPage
     * @return AnonymousResourceCollection
     */
    public function getAll(int $perPage = 10): AnonymousResourceCollection
    {
        return $this->repository->getAll($perPage);
    }

    /**
     * Create user
     * @param RegisterUserDataDTO $dto
     * @return User
     */
    public function createUser(RegisterUserDataDTO $dto): User
    {
        return $this->repository->createUser($dto);
    }
}
