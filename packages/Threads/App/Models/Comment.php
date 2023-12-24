<?php
namespace Packages\Threads\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Packages\Dashboard\App\Interfaces\HasMedia;
use Packages\Dashboard\App\Traits\HasMediaTrait;

class Comment extends Model implements HasMedia
{
    use HasFactory, HasMediaTrait;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'threads_comments';
    /**
    * @var bool
    */

    /**
     * @var array
    */
    protected $fillable = [
        'thread_id',
        'body',
        'report_count',
        'report_data',
        'is_passcode_user'
    ];

    protected $conversions = [
        'images' => [
            '100x100',
        ],
    ];

    protected $casts = [
        'report_data' => 'array',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
