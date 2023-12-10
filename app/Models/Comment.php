<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Dashboard\App\Interfaces\HasMedia;
use Packages\Dashboard\App\Traits\HasMediaTrait;

class Comment extends Model implements HasMedia
{
    use HasFactory, HasMediaTrait;

    protected $fillable = [
        'body',
        'question_id',
        'user_id',
        'report_count',
        'report_data',
        'votes_count',
        'is_passcode_user',
    ];

    /*
    * @var array
    */
    protected $conversions = [
        'images' => [
            '100x100',
        ],
    ];


    protected $casts = [
        'report_data' => 'array',
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->morphMany(CommentVote::class, 'commentable');
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
}
