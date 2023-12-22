<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'votes_count',
        'report_count',
        'report_data',
        'category_id',
    ];

    protected $casts = [
        'report_data' => 'array',
    ];

    public function toSearchableArray() {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'question_id');
    }

    public function vote($user, $vote)
    {
        // Check if the user has already voted
        $existingVote = $this->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            // User has voted before, check if they are changing their vote
            if ($existingVote->vote != $vote) {
                $this->votes()->where('user_id', $user->id)->update(['vote' => $vote]);
                $this->votes_count += $vote; // Invert the previous vote and apply the new one
            }
            // If they are not changing their vote, do nothing
        } else {
            // This is a new vote
            $this->votes()->create([
                'user_id' => $user->id,
                'vote' => $vote
            ]);
            $this->votes_count += $vote;
        }

        $this->save();
    }

    public function calculateInterestingRating($question) {
        $totalQuestionUpvotes = $question->votes_count;
        $totalAnswers = $question->comments->count();
        $totalAnswerUpvotes = $question->comments->sum(function ($comment) {
            // Summing the 'votes_count' from each vote related to the comment
            return $comment->votes_count; // Ensure 'vote' is the correct column name in your CommentVote model
        });
    
        if ($totalAnswerUpvotes > 0) {
            return ($totalQuestionUpvotes - $totalAnswers) / $totalAnswerUpvotes;
        } else {
            return ($totalQuestionUpvotes - $totalAnswers) / 1;
        }
    }     
}
