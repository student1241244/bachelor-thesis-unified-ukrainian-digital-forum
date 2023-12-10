<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Comment;
use Packages\Threads\App\Models\Category;
use App\Http\Requests\Thread\StoreRequest;
use App\Http\Requests\Thread\AddCommentRequest;

class ThreadController extends Controller
{
    private function isPasscodeValid() {
        $rawPasscode = session('passcode');
        if (!$rawPasscode) {
            return redirect('/');
        }
    
        // Retrieve the hashed passcode from the database
        $payment = Payment::where('status', 'completed')->first();
    
        // Assuming the hashed passcode is stored in a column named 'passcode'
        if ($payment && password_verify($rawPasscode, $payment->passcode)) {
            return true;
        }
    
        return false;
    }    
    
    public function showThreadsHome()
    {
        $categories = Category::all();

        return view('threads-home', compact('categories'));
    }

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
        $data = $request->validated();
        $data['is_passcode_user'] = $this->isPasscodeValid();
        
        $thread = Thread::create($data);
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

    public function addComment(AddCommentRequest $request, $threadId)
    {
        $data = $request->validated();
        $data['thread_id'] = $threadId;
        $data['is_passcode_user'] = $this->isPasscodeValid();
    
        Comment::create($data);
    
        return response()->json([
            'message' => 'Comment created successfully.',
        ]);
    }

    public function showByCategory($categoryId)
    {
        // Assuming each thread belongs to a category and 'category_id' is the foreign key in the 'threads' table
        $category = Category::findOrFail($categoryId);
        $threads = Thread::where('category_id', $categoryId)->latest()->paginate(4);
        return view('threads.index', compact('threads', 'categoryId'));
    }

}
