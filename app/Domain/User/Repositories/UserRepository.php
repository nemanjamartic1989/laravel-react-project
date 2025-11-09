<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Domain\User\DTO\UpdateUserDataDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users
     * @param int $perPage
     * @return AnonymousResourceCollection
     */
    public function getAll(int $perPage): AnonymousResourceCollection
    {
        return UserResource::collection(User::query()
            ->orderBy('id', 'desc')
            ->paginate(10));

    }
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

    /**
     * Update user
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, UpdateUserDataDTO $dto): User
    {
        $user->update($dto->toArray());
        return $user;
    }
}
