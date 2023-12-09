<?php

namespace App\Http\Controllers;

use App\Http\Requests\Thread\AddCommentRequest;
use App\Http\Requests\Thread\StoreRequest;
use Packages\Threads\App\Models\Category;
use Packages\Threads\App\Models\Comment;
use Packages\Threads\App\Models\Thread;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::query()
            ->with(['category'])
            ->paginate(12);

        return view('threads.index', get_defined_vars());
    }

    public function create()
    {
        $categories = Category::get()->pluck('title', 'id')->toArray();

        return view('threads.create', get_defined_vars());
    }

    public function store(StoreRequest $request)
    {
        $thread = Thread::create($request->validated());
        if ($request->hasFile('image')) {
            $thread->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return response()->json([
            'message' => 'Thread created successfully.',
        ]);
    }

    public function show(int $id)
    {
        $thread = Thread::findOrFail($id);

        $comments = Comment::query()
            ->where('thread_id', $id)
            ->get();

        $countComments = $comments->count();

        return view('threads.show', get_defined_vars());
    }

    public function addComment(int $id, AddCommentRequest $request)
    {
        $thread = Thread::findOrFail($id);
        $data = $request->validated();
        $data['thread_id'] = $thread->id;

        Comment::create($data);

        return response()->json([
            'message' => 'Comment was posted successfully.',
        ]);
    }

}
