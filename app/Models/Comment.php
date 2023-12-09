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
}
