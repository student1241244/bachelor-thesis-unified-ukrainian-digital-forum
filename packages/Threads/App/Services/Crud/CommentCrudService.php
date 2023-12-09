<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Services\Crud;

use Packages\Threads\App\Models\Comment;

/**
 * Class CommentCrudService
 */
class CommentCrudService
{
    public function store(array $data): Comment
    {
        $comment = Comment::create($data);

        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);

        return $comment;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete($comment);
    }
}
