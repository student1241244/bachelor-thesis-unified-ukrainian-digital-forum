<?php
declare( strict_types = 1 );

namespace Packages\Questions\App\Services\Crud;

use App\Models\Comment;

/**
 * Class CommentCrudService
 */
class CommentCrudService
{
    public function store(array $data): Comment
    {
        $comment = Comment::create($data);
        $this->attachMedia($comment);

        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        $this->attachMedia($comment);

        return $comment;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete($comment);
    }

    public function attachMedia(Comment $comment)
    {
        foreach (request()->file('images', []) as $image) {
            $comment->addMedia($image)->toMediaCollection('images');
        }

    }
}
