<?php

namespace App\Domain\Comment\Repositories;

use App\Domain\Comment\DTO\CreateCommentDataDTO;
use App\Domain\Comment\DTO\UpdateCommentDataDTO;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Get comments by post
     * @param Post $post
     * @return Collection
     */
    public function get(Post $post): Collection
    {
        return $post->with('comments')->get();
    }

    /**
     * Create post
     * @param Post $post
     * @param CreateCommentDataDTO $data
     * @return Post
     */
    public function store(Post $post, CreateCommentDataDTO $dto): Comment
    {
        return $post->comments()->create([
            'description' => $dto->description,
            'user_id'     => $dto->userId,
        ]);
    }

    /**
     * Update Comment
     * @param Comment $comment
     * @param array $data
     * @return Comment
     */
    public function update(Comment $comment, UpdateCommentDataDTO $dto): Comment
    {
        $data = [
            'description' => $dto->description,
            'user_id'     => $dto->userId,
        ];

        $comment->update($data);

        return $comment->refresh();
    }
}
