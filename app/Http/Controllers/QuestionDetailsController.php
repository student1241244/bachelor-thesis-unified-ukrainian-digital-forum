<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionDetailsController extends Controller
{
    public function questionDetails() {
        return view('/question-details');
    }

    public function voteQuestion(Request $request, $id)
    {
        try {
            $question = Question::findOrFail($id);
            $vote = $request->input('vote', 0);
        
            if (!in_array($vote, [1, -1])) {
                return response()->json(['error' => 'Invalid vote value'], 400);
            }
            $question->vote(auth()->user(), $vote);
            Log::error('Question: ' . $question->votes_count);
            return response()->json(['newVoteCount' => $question->votes_count]);
        } catch (\Exception $e) {
            Log::error('Vote Error: ' . $e->getMessage());
    
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function voteAnswer(Request $request, $questionId, $commentId)
    {
        try {
            $question = Question::findOrFail($questionId);
            $answer = $question->comments()->findOrFail($commentId);
            $vote = $request->input('vote', 0);
            
            if (!in_array($vote, [1, -1])) {
                return response()->json(['error' => 'Invalid vote value'], 400);
            }
            
            $answer->vote(auth()->user(), $vote);
            
            return response()->json(['newVoteCount' => $answer->votes_count]);
        } catch (\Exception $e) {
            Log::error('Vote Error: ' . $e->getMessage());
        
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }    
}
