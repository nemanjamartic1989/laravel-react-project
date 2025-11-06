<?php

namespace App\Domain\User\DTO;

class RegisterUserDataDTO
{
    /**
     * Full name
     * @var string
     */
    public string $name;

    /**
     * Email
     * @var string
     */
    public string $email;

    /**
     * Password
     * @var string
     */
    public string $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = bcrypt($data['password']);
    }
}
