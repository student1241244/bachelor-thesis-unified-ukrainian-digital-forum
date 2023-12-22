<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'user_id', 'vote'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
