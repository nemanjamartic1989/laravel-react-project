<?php

namespace App\Domain\User\Services;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserService
{
    public function __construct(protected UserRepositoryInterface $repository)
    {

    }

    public function createUser(RegisterUserDataDTO $dto): User
    {
        return $this->repository->createUser($dto);
    }
}
