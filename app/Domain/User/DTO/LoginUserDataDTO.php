<?php

namespace App\DTO;

class LoginUserDataDTO
{
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
        $this->email = $data['email'];
        $this->password = $data['password'];
    }
}
