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
     * Image
     * @var string
     */
    public ?string $image;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->image = isset($data['image']) ? $data['image'] : null;
    }

    /**
     * Format data for updating a post
     * @return array{
     *     title: string,
     *     description: string,
     *     image?: string
     * }
     */
    public function toArray(): array
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        if (!is_null($this->image)) {
            $data['image'] = $this->image;
        }

        return $data;
    }
}
