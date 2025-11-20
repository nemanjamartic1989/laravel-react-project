<?php

namespace App\Domain\Post\Repositories;

use App\Domain\Post\DTO\CreatePostDataDTO;
use App\Domain\Post\DTO\UpdatePostDataDTO;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface PostRepositoryInterface
{
    public function getAll(int $perPage): AnonymousResourceCollection;

    public function store(CreatePostDataDTO $dto): Post;

    public function update(Post $post, UpdatePostDataDTO $dto): Post;
}
