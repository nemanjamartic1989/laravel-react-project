<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create user
     * @param RegisterUserDataDTO $data
     * @return User
     */
    public function createUser(RegisterUserDataDTO $data): User
    {
        return User::create([
            'name'      => $data->name,
            'email'     => $data->email,
            'password'  => $data->password,
        ]);
    }
}
