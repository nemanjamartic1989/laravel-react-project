<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(RegisterUserDataDTO $dto): User;
}
