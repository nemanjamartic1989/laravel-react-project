<?php

namespace App\Domain\Comment\DTO;

class CreateCommentDataDTO
{
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
        $this->description = $data['description'];
        $this->userId = $data['user_id'];
    }
}
