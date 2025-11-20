<?php

namespace App\Domain\Post\Services;

use App\Domain\Post\DTO\CreatePostDataDTO;
use App\Domain\Post\DTO\UpdatePostDataDTO;
use App\Domain\Post\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostService
{
    public function __construct(protected PostRepositoryInterface $repository)
    {

    }

    /**
     * Get all posts
     * @param int $perPage
     * @return AnonymousResourceCollection
     */
    public function getAll(int $perPage = 10): AnonymousResourceCollection
    {
        return $this->repository->getAll($perPage);
    }

    /**
     * Create post
     * @param array $data
     * @return Post
     */
    public function store(array $data): Post
    {
        $dto = new CreatePostDataDTO($data);
        return $this->repository->store($dto);
    }

    /**
     * Create post
     * @param array $data
     * @return Post
     */
    public function update(Post $post, array $data): Post
    {
        $dto = new UpdatePostDataDTO($data);
        return $this->repository->update($post, $dto);
    }
}
