<?php

namespace App\Domain\Post\DTO;

class UpdatePostDataDTO
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

    /**
     * Image
     * @var string
     */
    public string $image;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->userId = $data['user_id'];
        $this->image = $data['image'];
    }
}
