<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Packages\Threads\App\Models\Comment;

class CommentsSection extends Component
{
    public $threadId;
    public $perPage = 10;
    public $page = 1;
    public $comments;
    public $totalComments;

    public function mount($threadId)
    {
        $this->threadId = $threadId;
        $this->comments = collect([]);
        $this->totalComments = Comment::where('thread_id', $this->threadId)->count();
        $this->loadComments();
    }

    public function loadMore()
    {
        $this->page++;
        $this->loadComments();
    }

    public function loadComments()
    {
        $newComments = Comment::where('thread_id', $this->threadId)
                              ->forPage($this->page, $this->perPage)
                              ->get();

        $this->comments = $this->comments->merge($newComments);
    }

    public function render()
    {
        return view('livewire.comments-section', [
            'comments' => $this->comments,
            'countComments' => Comment::where('thread_id', $this->threadId)->count(),
            'hasMorePages' => ($this->perPage * $this->page) < $this->totalComments,
        ]);
    }
}
