<?php

namespace App\Domain\Post\Repositories;

use App\Domain\Post\DTO\CreatePostDataDTO;
use App\Domain\Post\DTO\UpdatePostDataDTO;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get all posts
     * @param int $perPage
     * @return AnonymousResourceCollection
     */
    public function getAll(int $perPage): AnonymousResourceCollection
    {
        return PostResource::collection(Post::query()
            ->orderBy('id', 'desc')
            ->paginate(10));

    }
    /**
     * Create post
     * @param CreatePostDataDTO $data
     * @return Post
     */
    public function store(CreatePostDataDTO $dto): Post
    {
        return Post::create([
            'title'        => $dto->title,
            'description'  => $dto->description,
            'user_id'      => $dto->userId,
            'image'        => $dto->image,
        ]);
    }

    /**
     * Update post
     * @param Post $post
     * @param array $data
     * @return Post
     */
    public function update(Post $post, UpdatePostDataDTO $dto): Post
    {
        $data = [
            'title'        => $dto->title,
            'description'  => $dto->description,
        ];

        if (!is_null($dto->image)) {
            $data['image'] = $dto->image;
        }

        $post->update($data);

        return $post->refresh();
    }
}
