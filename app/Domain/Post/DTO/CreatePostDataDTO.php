<?php

namespace App\Domain\Post\DTO;

class CreatePostDataDTO
{
    /**
     * Full name
     * @var string
     */
    public string $title;

    /**
     * Email
     * @var string
     */
    public string $description;

    /**
     * User ID
     * @var int
     */
    public int $userId;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->userId = bcrypt($data['user_id']);
    }
}
