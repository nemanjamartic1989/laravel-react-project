<?php

namespace App\Domain\Comment\Services;

use App\Domain\Comment\DTO\CreateCommentDataDTO;
use App\Domain\Comment\DTO\UpdateCommentDataDTO;
use App\Domain\Comment\Repositories\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function __construct(protected CommentRepositoryInterface $repository)
    {

    }

    /**
     * Get comments by post
     * @param Post $post
     * @return Collection
     */
    public function get(Post $post): Collection
    {
        return $this->repository->get($post);
    }

    /**
     * Create comment
     * @param Post $post
     * @param array $data
     * @return Comment
     */
    public function store(Post $post, array $data): Comment
    {
        $data['user_id'] = Auth::user()->id;
        $dto = new CreateCommentDataDTO($data);

        return $this->repository->store($post, $dto);
    }

    /**
     * Create comment
     * @param Comment $comment
     * @param array $data
     * @return Comment
     */
    public function update(Comment $comment, array $data): Comment
    {
        $dto = new UpdateCommentDataDTO($data);
        return $this->repository->update($comment, $dto);
    }
}
