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
            $vote = $request->input('vote', 0); // vote should be 1 or -1
        
            // Ensure that $vote is either 1 or -1
            if (!in_array($vote, [1, -1])) {
                return response()->json(['error' => 'Invalid vote value'], 400);
            }
        
            $question->vote(auth()->user(), $vote);
        
            return response()->json(['newVoteCount' => $question->votes_count]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Vote Error: ' . $e->getMessage());
    
            // Return a meaningful error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }       
}
