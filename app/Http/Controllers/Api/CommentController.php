<?php

namespace App\Http\Controllers\Api;

use App\Domain\Comment\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Collection;

class CommentController extends Controller
{
    public function __construct(protected CommentService $service)
    {

    }

    /**
     * Show comment data
     * @param Post $post
     * @return Collection
     */
    public function index(Post $post): Collection
    {
        return $this->service->get($post);
    }

    /**
     * Store comment data
     * @param Post $post
     * @param CreateCommentRequest $request
     * @return Comment
     */
    public function store(Post $post, CreateCommentRequest $request): Comment
    {
        $data = $request->validated();
        return $this->service->store($post, $data);
    }

    /**
     * Update comment data
     * @param Comment $comment
     * @param UpdateCommentRequest $request
     * @return Comment
     */
    public function update(Comment $comment, UpdateCommentRequest $request): Comment
    {
        $data = $request->validated();
        return $this->service->update($comment, $data);
    }
}
