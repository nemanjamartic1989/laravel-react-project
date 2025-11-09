<?php

namespace App\Domain\User\DTO;

class UpdateUserDataDTO
{
    public string $name;
    public string $email;
    public ?string $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];

        $this->password = isset($data['password']) && $data['password'] !== ''
            ? bcrypt($data['password'])
            : null;
    }

    /**
     * Format data for updating a user
     * @return array{
     *     name: string,
     *     email: string,
     *     password?: string
     * }
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password !== null) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}

