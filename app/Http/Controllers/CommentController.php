<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private function sanitizeInput($inputText)
    {
        // Strip HTML Tags
        $cleanText = strip_tags($inputText);

        // Clean (remove) unwanted characters
        $cleanText = filter_var($cleanText, FILTER_SANITIZE_STRING);

        return $cleanText;
    }

    public function createComment(Request $request, $questionId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);
    
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->question_id = $questionId; // Set the question ID
        $comment->user_id = auth()->id(); // Set the user ID
        $comment->save();
    
        return back();
    }
    
    
    
}
