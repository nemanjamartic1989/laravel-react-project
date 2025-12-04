<?php

namespace App\Domain\Comment\Repositories;

use App\Domain\Comment\DTO\CreateCommentDataDTO;
use App\Domain\Comment\DTO\UpdateCommentDataDTO;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function get(Post $post): Collection;

    public function store(Post $post, CreateCommentDataDTO $dto): Comment;

    public function update(Comment $comment, UpdateCommentDataDTO $dto): Comment;
}
