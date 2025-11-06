<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Models\User;

class UserRepository
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
