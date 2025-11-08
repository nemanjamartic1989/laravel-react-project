<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface UserRepositoryInterface
{
    public function getAll(int $perPage): AnonymousResourceCollection;

    public function createUser(RegisterUserDataDTO $dto): User;
}
