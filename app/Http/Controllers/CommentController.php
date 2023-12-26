<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request, $questionId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);
    
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->question_id = $questionId;
        $comment->user_id = auth()->id();
        $comment->save();
    
        return back();
    }    
}
